// Common...
import Home from '@pages/Home.vue'
import Login from '@pages/Login.vue'
import Contact from '@pages/Contact.vue'
import News from '@pages/News.vue'
import Register from '@pages/Register.vue'
import PasswordReset from '@pages/PasswordReset.vue'
import PasswordResetConfirm from '@pages/PasswordResetConfirm.vue'

export const commonRoute = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/news',
    name: 'News',
    component: News
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
    path: '/password/reset',
    name: 'PasswordReset',
    component: PasswordReset,
  },
  {
    path: '/password/reset/:token',
    name: 'PasswordResetConfirm',
    component: PasswordResetConfirm,
  },
]