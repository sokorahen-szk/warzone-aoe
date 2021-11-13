export const gamePackageTemplate = {
  id: -1,
  label: null,
  value: null
}

export const gameMapTemplate = {
  id: -1,
  gamePackageId: -1,
  label: null,
  value: null
}

export const gameWarsChangeStatusButtonTemplates = [
  {label: 'チーム1勝利', game_status: 4, winningTeam: 1, color: 'info'},
  {label: 'チーム2勝利', game_status: 4, winningTeam: 2, color: 'info'},
  {label: '引き分け', game_status: 2, winningTeam: null, color: 'warning'},
  {label: '取り消し', game_status: 3, winningTeam: null, color: 'error'},
]