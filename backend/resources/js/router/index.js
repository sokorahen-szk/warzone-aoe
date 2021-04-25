import Vue from 'vue'
import Router from 'vue-router'

import store from '@/store/index'

// Common...
import Home from '@/components/pages/Home.vue'
import Login from '@/components/pages/Login.vue'
import Contact from '@/components/pages/Contact.vue'
import Register from '@/components/pages/Register.vue'

// Raiting
import RaitingIndex from '@/components/pages/raiting/Index.vue'

// Wars
import WarsIndex from '@/components/pages/wars/Index.vue'

// Account...
import Dashboard from '@/components/pages/account/Dashboard.vue'
Vue.use(Router)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { complitedAuthRedirect: true }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { complitedAuthRedirect: true }
  },
  {
    path: '/raiting',
    name: 'RaitingIndex',
    component: RaitingIndex,
  },
  {
    path: '/wars',
    name: 'WarsIndex',
    component: WarsIndex,
  },
  {
    path: '/account/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },
]

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters['authStore/isLogin'] === false) {
      next({
          path: '/login'
      });
    } else {
      next();
    }
  } else {
    if (store.getters['authStore/isLogin'] === true && to.matched.some(record => record.meta.complitedAuthRedirect) === true) {
      next({
        path: '/'
      });
    }
    next();
  }
});

export default router
