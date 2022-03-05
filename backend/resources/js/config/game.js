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

export const gameStatus = {
  matching: 1,
  draw: 2,
  canceled: 3,
  finished: 4,
}

export const gameStatusLabels = [
  {id: gameStatus.matching, label: 'ゲーム中'},
  {id: gameStatus.draw, label: '引き分け'},
  {id: gameStatus.canceled, label: 'キャンセル'},
  {id: gameStatus.finished, label: '終了'},
]

export const gameWarsChangeStatusButtonTemplates = [
  {label: 'チーム1勝利', game_status: gameStatus.finished, winningTeam: 1, color: 'info'},
  {label: 'チーム2勝利', game_status: gameStatus.finished, winningTeam: 2, color: 'info'},
  {label: '引き分け', game_status: gameStatus.draw, winningTeam: null, color: 'warning'},
  {label: '取り消し', game_status: gameStatus.canceled, winningTeam: null, color: 'error'},
]

