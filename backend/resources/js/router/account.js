// Account...
import AccountMypage from '@/components/pages/account/Mypage.vue'
import AccountProfile from '@/components/pages/account/Profile.vue'
import AccountRating from '@/components/pages/account/Rating.vue'
import AccountHistory from '@/components/pages/account/History.vue'
import AccountWithdrawal from '@/components/pages/account/Withdrawal.vue'

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