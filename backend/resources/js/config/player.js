export const playerListTemplate = {
  id: null,
  name: null,
  rank: null,
  rate: null,
  sigma: null,
  win: null,
  defeat: null,
  draw: null,
  games: null,
  wp: null,
  gamePackages: null,
  enabled: null
}

export const playerProfileTabs = [
  {name: 'profile', label: '基本情報', icon: 'mdi-account', component: 'IndexBasicPlayerProfile', id: 0},
  {name: 'history', label: '対戦履歴', icon: 'mdi-menu', component: 'IndexWarsPlayerHistory', id: 1},
  {name: 'rating', label: 'レート遷移', icon: 'mdi-menu', component: 'IndexRatePlayerHisyory', id: 2},
]
