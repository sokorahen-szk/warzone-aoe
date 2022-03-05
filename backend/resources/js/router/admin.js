// Common...
import AdminRequest from '@pages/admin/Request.vue'
import AdminGame from '@pages/admin/Game.vue'

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
]