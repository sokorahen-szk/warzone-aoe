import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/pages/Home.vue'
import Test from '@/components/pages/Test.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
        path: '/test',
        name: 'Test',
        component: Test
      },
  ]
})