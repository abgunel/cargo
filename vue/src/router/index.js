import { createRouter, createWebHistory } from 'vue-router'
import useAuthStore from '@/stores/auth.store.js';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Kullanıcı Girişi',
      component: () => import("@/views/Login.vue")
    },
    {
      path: '/orders',
      name: 'Siparişler',
      component: () => import("@/views/Orders.vue")
    },
    {
      path: '/cargo-status',
      name: 'Kargo Takip',
      component: () => import("@/views/CargoStatus.vue")
    },
    {
      path: '/cargo-confirm',
      name: 'Kargo Onay',
      component: () => import("@/views/ConfirmCargo.vue")
    }
  ]
});

router.beforeEach(async (to) => {
  // redirect to login page if not logged in and trying to access a restricted page
  const publicPages = ['/'];
  const authRequired = !publicPages.includes(to.path);
  const auth = useAuthStore();

  if (authRequired && !auth.user) {
      return '/';
  }
});


export default router
