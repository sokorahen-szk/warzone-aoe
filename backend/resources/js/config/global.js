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