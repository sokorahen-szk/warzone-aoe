export const registerRequestEnum = {
  WAITING: 1,
  APPROVE: 2,
  REJECT: 3,
}
export const registerRequestTemplate = {
  id: -1,
  playerName: null,
  joinedAt: null,
  status: 0,
  remarks: null
}

export const roles = [
  {id: 1, label: 'オーナー'},
  {id: 2, label: '管理者'},
  {id: 3, label: '編集者'},
  {id: 4, label: '一般'},
]

export const editUserByAdminTemplate = {
  id: null,
  joinedAt: null,
  lastGameAt: null,
  avatorImage: null,
  name: null,
  playerName: null,
  email: null,
  password: null,
  status: null,
  roleId: null,
  steamId: null,
  twitter: null,
  webSiteUrl: null,
}

export const editUserTypes = {
  create: 1,
  edit: 2,
}