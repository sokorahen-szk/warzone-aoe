export const headerConfig = {
  site: {
    name: "warzone-aoe",
    home: '/',
  },
  links: [
    {label: "ホーム", uri: "/"},
    {label: "対戦履歴", uri: "/wars"},
    {label: "レーティング", uri: "/rating"},
    {label: "問い合わせ", uri: "/contact"},
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