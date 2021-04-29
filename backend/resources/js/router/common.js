// Common...
import Home from '@/components/pages/Home.vue'
import Login from '@/components/pages/Login.vue'
import Contact from '@/components/pages/Contact.vue'
import Register from '@/components/pages/Register.vue'

export const commonRoute = [
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
]