// Account...
import AccountMypage from '@pages/account/Mypage.vue'
import AccountProfile from '@pages/account/Profile.vue'
import AccountRating from '@pages/account/Rating.vue'
import AccountHistory from '@pages/account/History.vue'
import AccountWithdrawal from '@pages/account/Withdrawal.vue'

export const accountRoute = [
  {
    path: '/account/mypage',
    name: 'Mypage',
    component: AccountMypage,
    meta: { requiresAuth: true }
  },
  {
    path: '/account/profile',
    name: 'Profile',
    component: AccountProfile,
    meta: { requiresAuth: true }
  },
  {
    path: '/account/history',
    name: 'History',
    component: AccountHistory,
    meta: { requiresAuth: true }
  },
  {
    path: '/account/rating',
    name: 'Rating',
    component: AccountRating,
    meta: { requiresAuth: true }
  },
  {
    path: '/account/withdrawal',
    name: 'Withdrawal',
    component: AccountWithdrawal,
    meta: { requiresAuth: true }
  },
]