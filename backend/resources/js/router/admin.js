// Common...
import AdminRequest from '@/components/pages/admin/Request.vue'

export const adminRoute = [
  {
    path: '/admin/request',
    name: 'AdminRequest',
    component: AdminRequest,
    meta: { requiresAuth: true }
  },
]