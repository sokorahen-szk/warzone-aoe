export const rightMenuCommonList = {
  subHeader: '基本情報',
  lists: [
    {
      icon: 'mdi-account-edit-outline',
      label: 'プロフィール',
      path: '/account/profile',
    },
    {
      icon: 'mdi-view-list-outline',
      label: '個人レーティング',
      path: '/account/rating',
    },
    {
      icon: 'mdi-format-list-numbered',
      label: '対戦履歴',
      path: '/account/history',
    },
  ]
}

export const rightMenuOtherList = {
  subHeader: 'その他',
  lists: [
    {
      icon: 'mdi-trash-can-outline',
      label: '退会する',
      path: '/account/withdrawal',
    },
  ]
}

export const profileViewTemplate = {
  id: null,
  status: null,
  player: {
    joinedAt: null,
  }
}

export const profileTemplate = {
  name: null,
  steamId: null,
  twitterId: null,
  email: null,
  webSiteUrl: null,
  password: null,
  passwordConfirmation: null,
  avatorImage: null,
  player: {
    gamePackages: null,
  }
}