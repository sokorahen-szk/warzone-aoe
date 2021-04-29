import Vue from 'vue'
import Router from 'vue-router'
import store from '@/store/index'

import {accountRoute} from '@/router/account'
import {commonRoute} from '@/router/common'
import {ratingRoute} from '@/router/rating'
import {warsRoute} from '@/router/wars'

Vue.use(Router)

const routes = [
  ...warsRoute,
  ...ratingRoute,
  ...commonRoute,
  ...accountRoute,
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
