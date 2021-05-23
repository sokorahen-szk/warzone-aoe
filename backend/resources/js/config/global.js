export const headerConfig = {
  site: {
    name: "warzone-aoe",
    home: '/',
  },
  links: [
    {label: "ホーム", uri: "/"},
    {label: "対戦履歴", uri: "/wars"},
    {label: "レーティング", uri: "/rating"},
    {label: "ゲーム作成", uri: "/games/newgame"},
  ]
}

export const alertTemplate = {
  show: false,
  type: 'info',
  message: null,
}

export const breadcrumbs = {
  mypage: {
    text: 'マイページ',
    disabled: false,
    href: '/account/mypage',

    profile: {
      text: 'プロフィール',
      disabled: true,
      href: '/account/mypage',
    }
  }
}

export const mobileMenuLists = [
  {label: 'ホーム', path: '/', icon: 'mdi-home', login: false},
  {label: '対戦履歴', path: '/wars', icon: 'mdi-view-list-outline', login: false},
  {label: 'レーティング', path: '/rating', icon: 'mdi-format-list-numbered', login: false},
  {label: 'ゲーム作成', path: '/games/newgame', icon: 'mdi-gamepad-variant', login: false},
  {
    label: 'アカウント',
    icon: 'mdi-account',
    login: true,
    subLists: [
      {
        label: 'マイページ',
        path: '/account/mypage',
      },
      {
        label: 'プロフィール',
        path: '/account/profile',
      },
      {
        label: '個人レーティング',
        path: '/account/history',
      },
      {
        label: '退会する',
        path: '/account/withdrawal',
      },
    ]
  },
]