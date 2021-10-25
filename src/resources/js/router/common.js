// Common...
import Home from '@pages/Home.vue'
import Login from '@pages/Login.vue'
import Contact from '@pages/Contact.vue'
import Register from '@pages/Register.vue'

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