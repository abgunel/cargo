<script setup>
import InputText from 'primevue/inputtext';
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Textarea from 'primevue/textarea';
import Dropdown from 'primevue/dropdown';
import 'primeicons/primeicons.css';
import {api} from '../axios.js';
import { PrimeIcons } from "primevue/api";
import useAuthStore from "../stores/auth.store";
const AuthStore = useAuthStore();

const newOrUpdate = ref();

const dt = ref();
const products = ref();
const productDialog = ref(false);
const deleteProductDialog = ref(false);
const deleteProductsDialog = ref(false);
const product = ref({});
const selectedProducts = ref();
const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});
const submitted = ref(false);
const departments = ref([]);
const users = ref([]);


onMounted(() => {
    getOrderTable();
});


async function getDepUsers(){
    const getDepUsers = await api.get("getDepUsers.php?get="+product.value.OrderedDepId, { headers: {"Authorization" : `Bearer ${AuthStore.token}`} } );
    users.value = getDepUsers.data;
    console.log(users.value);
}

async function getDep(){
    const getDep = await api.get("getDep.php?get", { headers: {"Authorization" : `Bearer ${AuthStore.token}`} } );
    departments.value = getDep.data;
    console.log(departments.value);
}



async function getOrderTable(){
    const getRes = await api.get("getOrderTable.php?get", { headers: {"Authorization" : `Bearer ${AuthStore.token}`} });
    products.value = getRes.data.table;
}



const openNew = () => {
    newOrUpdate.value = "new";
    getDep();
    product.value = {};
    submitted.value = false;
    productDialog.value = true;
};
const hideDialog = () => {
    productDialog.value = false;
    submitted.value = false;
};
async function saveProduct() {
    submitted.value = true;  
    if (AuthStore.role == "Formen"){
        product.value.OrderedDepId= AuthStore.depId;
        product.value.Orderer = AuthStore.id;
    }


    if(newOrUpdate.value=="new"){
        const postRes = await api.post("postOrderTable.php?add", objectToQueryForApi(product.value), { headers: {"Authorization" : `Bearer ${AuthStore.token}`} });
        console.log(postRes);
    }else{
        const updateRes = await api.post("updateOrder.php?update", objectToQueryForApi(product.value), { headers: {"Authorization" : `Bearer ${AuthStore.token}`} });
        console.log(updateRes);
    }
    newOrUpdate.value = "";
    productDialog.value = false;
    product.value = {};
    getOrderTable();
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
    getDep();

    //product.value = {...prod};
    const editRes= await api.get("getOrder.php?get="+prod, { headers: {"Authorization" : `Bearer ${AuthStore.token}`} } );
    product.value= editRes.data.order[0];
    product.value.Id= prod;
    newOrUpdate.value = "update";
    productDialog.value = true;
};
const confirmDeleteProduct = (prod) => {
    product.value = prod;
    deleteProductDialog.value = true;
};
async function deleteProduct () {
    //products.value = products.value.filter(val => val.id !== product.value.id);

    const removeSingleRes = await api.get("removeOrder.php?remove="+product.value.Id, { headers: {"Authorization" : `Bearer ${AuthStore.token}`} });
    console.log(removeSingleRes);
    deleteProductDialog.value = false;
    product.value = {};
    getOrderTable();
};


const confirmDeleteSelected = () => {
    deleteProductsDialog.value = true;
    console.log(selectedProducts.value);
    console.log(selectedProducts.value.length);
};
async function deleteSelectedProducts() {
    //products.value = products.value.filter(val => !selectedProducts.value.includes(val));
    for(let i=0; i<selectedProducts.value.length; i++){
        const removeMultiRes = await api.get("removeOrder.php?remove="+selectedProducts.value[i].Id, { headers: {"Authorization" : `Bearer ${AuthStore.token}`} })
        console.log(removeMultiRes);
    }
    deleteProductsDialog.value = false;
    selectedProducts.value = null;
    getOrderTable();
};


function disabled(){
    if(AuthStore.role == "Admin" || AuthStore.role == "Formen" || AuthStore.role == "Satın"){
        return false;
    }else{
        return true;
    }
}


</script>

<template>
    <h1>Sipariş Listesi</h1>
    <div>
        <div class="card">
            <Toolbar class="mb-4">
                <template #start>
                    <Button :disabled="disabled()" label="Yeni Sipariş Oluştur" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
                    <Button :disabled="disabled() || (!selectedProducts || !selectedProducts.length)" label="Sil" icon="pi pi-trash" severity="danger" @click="confirmDeleteSelected" />
                </template>
            </Toolbar>

            <DataTable ref="dt" :value="products" v-model:selection="selectedProducts" showGridlines dataKey="Id" 
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

                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="Id" header="Sipariş No" sortable></Column>
                <Column field="OrderName" header="Ürün Adı" sortable ></Column>
                <Column field="DateTime" header="Sipariş Tarihi" sortable ></Column>
                <Column field="OrderDescription" header="Ürün Bilgisi"></Column>
                <Column header="Fotoğraf">
                    <template #body="slotProps">
                        <img :src="slotProps.data.OrderImage" class="shadow-2 border-round" style="width: 64px" />
                    </template>
                </Column>
                <Column field="Name" header="Sipariş Eden" sortable></Column>
                <Column field="OrderedDep" header="Bölüm" sortable ></Column>
                <Column field="OrderedPro" header="Proje" sortable ></Column>
                <Column field="OrderLink" header="Ürün Link" ></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button :disabled="disabled()" icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct(slotProps.data.Id)" />
                        <Button :disabled="disabled()" icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDeleteProduct(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="productDialog" :style="{width: '450px'}" header="Sipariş Detayları" :modal="true" class="p-fluid">
            <img  class="block m-auto pb-3" />
            <div class="field">
                <label for="name">Ürün İsmi</label>
                <InputText id="name" v-model="product.OrderName" required="true" autofocus :class="{'p-invalid': submitted && !product.OrderName}" />
                <small class="p-error" v-if="submitted && !product.OrderName">Ürün ismi boş bırakılamaz.</small>
            </div>
            <div class="field">
                <label for="description">Ürün Açıklaması</label>
                <Textarea id="description" v-model="product.OrderDescription" required="true" rows="3" cols="20" />
            </div>

            <div v-if="AuthStore.role==('Satın' || 'Admin')? true:false" class="field">
				<label for="dep" class="mb-3">Sipariş Eden Bölüm</label>
				<Dropdown id="dep" v-model="product.OrderedDepId" v-on:change.native="getDepUsers" :options="departments" optionValue="OrderedDepId" optionLabel="OrderedDep" placeholder="Bölüm Seçin"/>
			</div>

            <div v-if="AuthStore.role==('Satın' || 'Admin')? true:false" class="field">
				<label for="orderer" class="mb-3">Sipariş Talep Eden Kişi</label>
                <Dropdown :disabled="product.OrderedDepId==null" id="dep" v-model="product.Orderer" :options="users" optionValue="Id" optionLabel="Name" placeholder="Kişi Seçin"/>
			</div>

            <div class="field">
                <label for="pro" class="mb-3">Proje</label>
                <InputText id="pro" v-model="product.OrderedPro" required="true" autofocus :class="{'p-invalid': submitted && !product.OrderedPro}" />
            </div>

            <div class="field">
                <label for="link" class="mb-3">Link</label>
                <InputText id="link" v-model.trim="product.OrderLink"/>
            </div>

            <div class="field">
                <label class="mb-3">Fotoğraf Ekle</label>
                <div class="field">
                    <img :src="product.OrderImage" v-if="product.OrderImage!==''" alt=" Fotoğraf Bulunamadı" class="shadow-2 border-round" style="width: 256px" />
                    <InputText v-model="product.OrderImage" />
                </div>


            </div>
            <template #footer>
                <Button label="İptal" icon="pi pi-times" text @click="hideDialog"/>
                <Button label="Kaydet" icon="pi pi-check" text @click="saveProduct" />
            </template>
        </Dialog>

        <Dialog v-model:visible="deleteProductDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
            <div class="confirmation-content">
                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                <span v-if="product">Siparişi silmek istediğine emin misin: <b>{{product.OrderName}}</b>?</span>
            </div>
            <template #footer>
                <Button label="Hayır" icon="pi pi-times" text @click="deleteProductDialog = false"/>
                <Button label="Evet" icon="pi pi-check" text @click="deleteProduct" />
            </template>
        </Dialog>

        <Dialog v-model:visible="deleteProductsDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
            <div class="confirmation-content">
                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                <span v-if="product">Seçili siparişleri silmek istediğine emin misin?</span>
            </div>
            <template #footer>
                <Button label="Hayır" icon="pi pi-times" text @click="deleteProductsDialog = false"/>
                <Button label="Evet" icon="pi pi-check" text @click="deleteSelectedProducts" />
            </template>
        </Dialog>
	</div>
</template>