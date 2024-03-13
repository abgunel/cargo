<script setup>
import InputText from 'primevue/inputtext';
import { ref, onMounted } from 'vue';
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
import Calendar from 'primevue/calendar';

const AuthStore = useAuthStore();

const dt = ref();
const products = ref();
const productDialog = ref(false);
const product = ref({});
const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});
const submitted = ref(false);
const cargoStatus = ref([
    {CargoStatus: 'Sipariş Verildi', Id: 10},
    {CargoStatus: 'Kargoya Verildi', Id: 20},
    {CargoStatus: 'Teslim Alındı', Id: 30}
]);

const cargoFirms = ref([]);


onMounted(() => {
    getCargoStatusTable();
});

function LocalizeAndParseDate(date){
    let parsedDate = date.toLocaleDateString();
    parsedDate= parsedDate.split(".").reverse().join("/");
    return parsedDate;
}

function isIsoDate(str) {
  if (!/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z/.test(str)) return false;
  const d = new Date(str); 
  return d instanceof Date && !isNaN(d.getTime()) && d.toISOString()===str; // valid date 
}

async function saveProduct() {
    submitted.value = true;
    //burayi sonradan duzelt lenght undefined geliyor. Bu sekilde yinede dogru calisacak sekilde ayarladim.
    let length = product.value.CargoPostDate.length;
    console.log(length);
    if (length == undefined){
        product.value.CargoPostDate = LocalizeAndParseDate(product.value.CargoPostDate);
        }
    console.log(product.value.CargoPostDate);
    /*
    if (isIsoDate(product.value.CargoPostDate)){
        product.value.CargoPostDate = LocalizeAndParseDate(product.value.CargoPostDate);
    }else{
        delete product.CargoPostDate;
    }
    */

    const updateRes = await api.post("updateStatus.php?update", objectToQueryForApi(product.value), { headers: {"Authorization" : `Bearer ${AuthStore.token}`} });
    console.log(updateRes);
    productDialog.value = false;
    product.value = {};
    getCargoStatusTable();
};

async function getCargoStatusTable(){
    const getRes = await api.get("getCargoStatusTable.php?get", { headers: {"Authorization" : `Bearer ${AuthStore.token}`} });
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

async function getFirm(){
    const getFirm = await api.get("getFirm.php?get", { headers: {"Authorization" : `Bearer ${AuthStore.token}`} } );
    cargoFirms.value = getFirm.data;
    console.log(cargoFirms.value);
}

async function editProduct (prod) {
    getFirm();
    const editRes= await api.get("getCargoStatus.php?get="+prod, { headers: {"Authorization" : `Bearer ${AuthStore.token}`} } );
    product.value= editRes.data.order[0];
    productDialog.value = true;
};


function disabled(){
    if(AuthStore.role == "Admin" || AuthStore.role == "Satın" || AuthStore.role == "Stok"){
        return false;
    }else{
        return true;
    }
}

</script>

<template>
    <h1>Kargo Durumu</h1>
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
                <Column field="CargoPostDate" header="Kargoya Veriliş Tarihi"></Column>
                <Column field="CargoStatus" header="Kargo Durumu"></Column>
                <Column field="CargoFirm" header="Kargo Firması"></Column>
                <Column field="CargoTrackingCode" header="Kargo Takip Kodu"></Column>
                <Column field="Name" header="Sipariş Eden" sortable ></Column>
                <Column field="OrderedDep" header="Bölüm" sortable ></Column>
                <Column field="OrderedPro" header="Proje" sortable ></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button :disabled="disabled()" icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct(slotProps.data.Id)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="productDialog" :style="{width: '450px'}" header="Sipariş Detayları" :modal="true" class="p-fluid">
            <img  class="block m-auto pb-3" />
            <div class="field">
                <label for="cargoDate">Kargoya Veriliş Tarihi</label>
                <Calendar id="cargoDate" v-model="product.CargoPostDate"/>    
            </div>
            <div class="field">
                <label for="cargoStatus">Kargo Durumu</label>
                <Dropdown id="cargoStatus" v-model="product.CargoStatusId" :options="cargoStatus" option-value="Id" option-label="CargoStatus" placeholder="Durum Seçin" />
            </div>

            <div class="field">
				<label for="cargoFirm" class="mb-3">Kargo Firması</label>
				<Dropdown id="cargoFirm" v-model="product.CargoFirmId" :options="cargoFirms" optionValue="CargoFirmId" optionLabel="CargoFirm" placeholder="Bölüm Seçin"/>
			</div>

            <div class="field">
                <label for="trackingCode" class="mb-3">Kargo Takip Kodu</label>
                <InputText id="trackingCode" v-model.trim="product.CargoTrackingCode" />
            </div>
            <template #footer>
                <Button label="İptal" icon="pi pi-times" text @click="hideDialog"/>
                <Button label="Kaydet" icon="pi pi-check" text @click="saveProduct" />
            </template>
        </Dialog>

	</div>
</template>