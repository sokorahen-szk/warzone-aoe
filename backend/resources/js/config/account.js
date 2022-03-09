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

export const rightMenuModeleterList = {
  subHeader: '編集者メニュー',
  lists: [
    {
      icon: 'mdi-account-plus',
      label: '新規登録リクエスト',
      path: '/admin/request',
    },
    {
      icon: 'mdi-clipboard-edit-outline',
      label: 'レート管理',
      path: '/admin/rate',
    },
    {
      icon: 'mdi-gamepad-variant-outline',
      label: 'ゲーム管理',
      path: '/admin/game',
    },
  ]
}

export const rightMenuAdminList = {
  subHeader: '管理者メニュー',
  lists: [
    {
      icon: 'mdi-account-supervisor',
      label: 'ユーザ管理',
      path: '/admin/user',
    },
  ]
}

export const profileViewTemplate = {
  id: null,
  status: null,
  email: null,
  player: {
    joinedAt: null,
    enabled: null,
  },
  role: {
    name: null
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

export const raitingTemplate = {
  finishedAt: null,
  startedAt: null,
  gamePackageId: null,
  gameRecordId: null,
  playerMemoryId: null,
  rank: null,
  rate: null,
  status: null,
  team: null,
  winningTeam: null
}
