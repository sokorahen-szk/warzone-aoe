export const rightMenuCommonList = {
  subHeader: '基本情報',
  lists: [
    {
      icon: 'mdi-account-edit-outline',
      label: 'プロフィール情報',
      path: '/account/profile',
    },
    {
      icon: 'mdi-view-list-outline',
      label: '個人レーティング',
      path: '/account/raiting',
    },
    {
      icon: 'mdi-format-list-numbered',
      label: '対戦履歴',
      path: '/account/wars',
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