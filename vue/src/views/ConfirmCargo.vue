<script setup>
import InputText from 'primevue/inputtext';
import { ref, onMounted, watch } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Textarea from 'primevue/textarea';
import Dropdown from 'primevue/dropdown';
import 'primeicons/primeicons.css';
import {api} from '../axios.js';
import { PrimeIcons } from "primevue/api";
import useAuthStore from "../stores/auth.store";
const AuthStore = useAuthStore();

const ImagePreview = ref();


const dt = ref();
const products = ref();
const productDialog = ref(false);
const product = ref({});
const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});
const submitted = ref(false);


function image(event){

    console.log(event);
    if (event.target.files.length === 0){
        return;
    }

    let image = event.target.files[0];
    let reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = event => {
        let preview = event.target.result;
        product.value.ReceiverImage = preview;
    }
}

/*
function image(e){
    var files = e.target.files || e.dataTransfer.files;
    if(!files.lenght)
        return;
    product.value.ReceiverImage = (files[0]);
}
*/

const orderStatuses = ref([
    {label: 'Teslim Alınmadı', value: '0'},
    {label: 'Teslim Alındı', value: '1'}
]);

onMounted(() => {
    getConfirmOrderTable();
});

/*
function b64toBlob(dataURI) {
    
    var byteString = atob(dataURI.split(',')[1]);
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([ab], { type: contentType });
}
*/
async function saveProduct() {
    submitted.value = true;   
    //product.value.Orderer = AuthStore.user;

    if (product.value.OrderReceived != null || product.value.ReceiverImage != null)
    {
        product.value.ReceiverImage = btoa(product.value.ReceiverImage);
        const updateRes = await api.post("updateConfirm.php?update", objectToQueryForApi(product.value), { headers: {"Authorization" : `Bearer ${AuthStore.token}`} });
        console.log(updateRes);
        console.log(product.value);
        productDialog.value = false;
        product.value = {};
        getConfirmOrderTable();
    }else{alert("Herhangi bir değişiklik yapmadınız!");}


};

async function getConfirmOrderTable(){
    const getRes = await api.get("getConfirmOrderTable.php?get", { headers: {"Authorization" : `Bearer ${AuthStore.token}`} });

    
    for(let i=0; i<getRes.data.table.length; i++){
        getRes.data.table[i].ReceiverImage = atob(getRes.data.table[i].ReceiverImage);
    }

    products.value = getRes.data.table;
}

const hideDialog = () => {
    productDialog.value = false;
    submitted.value = false;
};

function objectToQueryForApi (params) {
  let q = "";
  if (params) {
    for (const key in params) {
      let val;
      if (typeof params[key] == "object") {
        val = JSON.stringify(params[key]);
      } else {
        val = params[key];
      }

      q += `${key}=${val}&`;
    }
  }
  q = q.substring(0, q.length - 1);
  return q;
};

async function editProduct (prod) {
    //const editRes= await api.get("getOrder.php?get="+prod, { headers: {"Authorization" : `Bearer ${AuthStore.token}`} } );
    //product.value= editRes.data.order[0];
    //console.log(prod);
    product.value.Id = prod;
    console.log(product.value.Id);
    productDialog.value = true;
};


function disabled(){
    if(AuthStore.role == "Admin" || AuthStore.role == "Formen"){
        return false;
    }else{
        return true;
    }
}


</script>

<template>
    <h1>Kargo Onay</h1>
    <div>
        <div class="card">

            <DataTable ref="dt" :value="products" showGridlines dataKey="Id" 
                :paginator="true" :rows="100" :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[100,150,200,1000]"
                currentPageReportTemplate="Toplam {totalRecords} sipariş arasından {first}-{last} arası gösteriliyor">
                <template #header>
                    <div class="flex flex-wrap gap-2 align-items-center justify-content-between">
                        <h4 class="m-0">Verilen Siparişler</h4>
						<span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters['global'].value" placeholder="Ara..." />
                        </span>
					</div>
                </template>

                <Column field="Id" header="Sipariş No" sortable ></Column>
                <Column field="OrderName" header="Ürün Adı" sortable ></Column>
                <Column field="DateTime" header="Sipariş Tarihi" sortable ></Column>
                <Column field="OrderDescription" header="Ürün Bilgisi"></Column>
                <Column field="OrderedPro" header="Proje" sortable ></Column>
                <Column field="ReceiveStatus" header="Siparişi Teslim Alma Durumunuz" sortable ></Column>
                <Column header="Teslim Alınan Ürün Fotoğrafı">
                    <template #body="slotProps">
                        <img :src="slotProps.data.ReceiverImage" class="shadow-2 border-round" style="width: 64px" />
                    </template>
                </Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button :disabled="disabled()" icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct(slotProps.data.Id)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="productDialog" :style="{width: '450px'}" header="Sipariş Detayları" :modal="true" class="p-fluid">
            <div class="field">
                <label for="name">Ürün Teslimi</label>
                <Dropdown v-model="product.OrderReceived" :options="orderStatuses" optionValue="value" optionLabel="label" placeholder="Durum Seçin"/>
            </div>
            <div class="field">
                <label class="mb-3">Fotoğraf Ekle</label>
                <div class="card flex justify-content-center">
                    <img v-show="product.ReceiverImage" :src="product.ReceiverImage"/>
                </div>
                <div class="card flex justify-content-center">
                    <input type="file" accept="image/*" @change="image" id="file-input">
                </div>
            </div>
            <template #footer>
                <Button label="İptal" icon="pi pi-times" text @click="hideDialog"/>
                <Button label="Kaydet" icon="pi pi-check" text @click="saveProduct" />
            </template>
        </Dialog>

	</div>
</template>