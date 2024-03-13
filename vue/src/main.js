import './assets/app.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import PrimeVue from 'primevue/config';
import router from './router'

//theme
import "primevue/resources/themes/lara-light-indigo/theme.css";        
//core
import "primevue/resources/primevue.min.css";

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.use(PrimeVue, {
    "locale":{
        "startsWith":"Başlangıç",
        "contains":"Barındırır",
        "notContains":"İçinde Barındırmaz",
        "endsWith":"Bitiş",
        "equals":"Eşittir",
        "notEquals":"Eşit Değildir",
        "noFilter":"Filtresiz",
        "lt":"Daha az",
        "lte":"Daha az veya Eşit",
        "gt":"Daha Fazla",
        "gte":"Daha fazla veya Eşit",
        "dateIs":"Tarih",
        "dateIsNot":"Tarih değildir",
        "dateBefore":"Tarihten önce",
        "dateAfter":"Tarihten sonra",
        "custom":"Özel",
        "clear":"Temiz",
        "apply":"Uygula",
        "matchAll":"Tümüyle eşleşir",
        "matchAny":"Herhangi birine eşleşir",
        "addRule":"Kural Ekle",
        "removeRule":"Kuralı Sil",
        "accept":"Tamam",
        "reject":"İptal",
        "choose":"Seç",
        "upload":"Yükle",
        "cancel":"Vazgeç",
        "dayNames":["Pazar","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi"],
        "dayNamesShort":["Paz","Pzt","Sal","Çar","Per","Cum","Cmt"],
        "dayNamesMin":["Pz","Pt","Sa","Ça","Pe","Cu","Ct"],
        "monthNames":["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"],
        "monthNamesShort":["Oca","Şub","Mar","Nis","May","Haz","Tem","Ağu","Eyl","Eki","Kas","Ara"],
        "today":"Bugün",
        "weekHeader":"Hf",
        "firstDayOfWeek":0,
        "dateFormat":"dd/mm/yy",
        "weak":"Zayıf",
        "medium":"Orta",
        "strong":"Güçlü",
        "passwordPrompt":"Şifre Giriniz",
        "emptyFilterMessage":"Kullanılabilir seçenek yok",
        "emptyMessage":"Sonuç bulunamadı",
        "aria": { // neyse işte buradan türkçeleştirirsin
              "trueLabel": "Doğru",
              "falseLabel": "Yanlış",
              "nullLabel": "Seçilmedi",
              "pageLabel": "Sayfa",
              "firstPageLabel": "İlk Sayfa",
              "lastPageLabel": "Son Sayfa",
              "nextPageLabel": "Sonraki Sayfa",
              "previousPageLabel": "Önceki Sayfa", 
              "star": "1 star",
              "stars": "{star} stars",
              "selectAll": "All items selected",
              "unselectAll": "All items unselected",
              "close": "Close",
              "previous": "Previous",
              "next": "Next",
              "navigation": "Navigation",
              "scrollTop": "Scroll Top",
              "moveTop": "Move Top",
              "moveUp": "Move Up",
              "moveDown": "Move Down",
              "moveBottom": "Move Bottom",
              "moveToTarget": "Move to Target",
              "moveToSource": "Move to Source",
              "moveAllToTarget": "Move All to Target",
              "moveAllToSource": "Move All to Source",
              "rowsPerPageLabel": "Rows per page",
              "jumpToPageDropdownLabel": "Jump to Page Dropdown",
              "jumpToPageInputLabel": "Jump to Page Input",
              "selectRow": "Row Selected",
              "unselectRow": "Row Unselected",
              "expandRow": "Row Expanded",
              "collapseRow": "Row Collapsed",
              "showFilterMenu": "Show Filter Menu",
              "hideFilterMenu": "Hide Filter Menu",
              "filterOperator": "Filter Operator",
              "filterConstraint": "Filter Constraint",
              "editRow": "Row Edit",
              "saveEdit": "Save Edit",
              "cancelEdit": "Cancel Edit",
              "listView": "List View",
              "gridView": "Grid View",
              "slide": "Slide",
              "slideNumber": "{slideNumber}",
              "zoomImage": "Zoom Image",
              "zoomIn": "Zoom In",
              "zoomOut": "Zoom Out",
              "rotateRight": "Rotate Right",
              "rotateLeft": "Rotate Left"
            }
     }
});

app.mount('#app')
