import { defineStore } from 'pinia';
import {api} from '../axios.js';

import router from '@/router/index.js';


const useAuthStore = defineStore({
    id: 'auth',
    state: () => ({
        // initialize state from local storage to enable user to stay logged in
        //user: JSON.parse(localStorage.getItem('user')),
        token: JSON.parse(localStorage.getItem('token')),
        user: JSON.parse(localStorage.getItem('user')),
        exp: JSON.parse(localStorage.getItem('exp')),
        role: JSON.parse(localStorage.getItem('role')),
        depId: JSON.parse(localStorage.getItem('depId')),
        id: JSON.parse(localStorage.getItem('id'))
    }),
    actions: {
        //API'ye login istegi atma kismi
        async login(username, password) {
            /*let req = JSON.stringify({
                id: username,
                pass: password
            })

            const login = await api.post('login.php', req, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });*/

            let req = JSON.stringify({
                id: username,
                pass: password
            })

            const login = await api.post("login.php", req);
            // kullanıcı bilgisi + şifre göndererek login ol. Dönen değeri kontrol et ve token'e ata.

            if (login.data == null){
                alert("Giriş Başarısız");
            }else{
            //const token = await axios;
            // update pinia state
            
            /*
            //Token'in süresi dolduğunda otomatik logout let expiration = +login.data.token.expires * 1000;
            let expiration = (login.data.token.expires - new Date().getUTCMilliseconds()) * 1000 ;
            setTimeout(() => {
                this.logout()
            }, expiration);
            */

            console.log(login);
            console.log(typeof(login));

            console.log(login.data.id);
            this.user = login.data.id;

            console.log(login.data.token.token);
            this.token = login.data.token.token;

            console.log(login.data.token.expires);
            this.exp = login.data.token.expires;

            console.log(login.data.role);
            this.role = login.data.role;

            console.log(login.data.depId);
            this.depId = login.data.depId;

            console.log(login.data.idno);
            this.id = login.data.idno;


            // saklamak istenilen değişkenleri localStorage'a kaydediyor
            localStorage.setItem('user', JSON.stringify(this.user));
            localStorage.setItem('token', JSON.stringify(this.token));
            localStorage.setItem('exp', JSON.stringify(this.exp));
            localStorage.setItem('role', JSON.stringify(this.role));
            localStorage.setItem('depId', JSON.stringify(this.depId));
            localStorage.setItem('id', JSON.stringify(this.id));
            // login işlemi bititkten sonra siparişler sayfasına geçiş yapıyor.
            router.push('/orders');

            }
        },
        //logout metoduyla saklanan değişkenler siliniyor ve kullanıcı giriş sayfasına yönlendiriliyor
        logout() {
            this.user = null;
            localStorage.removeItem('user');
            this.token = null;
            localStorage.removeItem('token');
            this.exp = null;
            localStorage.removeItem('exp');
            this.role = null;
            localStorage.removeItem('role');
            this.depId = null;
            localStorage.removeItem('depId');
            this.id = null;
            localStorage.removeItem('id');
            router.push('/');
        }
    }
});

export default useAuthStore;