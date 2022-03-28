// Common...
import AdminRequest from '@pages/admin/Request.vue'
import AdminGame from '@pages/admin/Game.vue'
import AdminUser from '@pages/admin/User.vue'
import AdminRate from '@pages/admin/Rate.vue'

export const adminRoute = [
  {
    path: '/admin/request',
    name: 'AdminRequest',
    component: AdminRequest,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/game',
    name: 'AdminGame',
    component: AdminGame,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/user',
    name: 'User',
    component: AdminUser,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/rate',
    name: 'Rate',
    component: AdminRate,
    meta: { requiresAuth: true }
  },
]