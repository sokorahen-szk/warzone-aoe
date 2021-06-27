import {playerProfileTabs} from '@/config/player'

export const objCopy = (o, c) => {
  let obj = {}
  Object.keys(o).forEach( (key) => {
    if (Object.keys(c).indexOf(key) !== -1) {
      if (typeof o[key] == 'object' && typeof c[key] == 'object') {
        if (o[key] !== null && c[key] != null) {
          obj[key] = objCopy(o[key], c[key])
        } else {
          obj[key] = c[key]
        }
      } else {
        obj[key] = c[key]
      }
    } else {
      obj[key] = null;
    }
  })
  return obj
}

export const addStyleParser = styles => {
  let obj = []
  if (!styles || Object.keys(styles).length < 1) return ''

  Object.keys(styles).forEach( (attrName) => {
    obj.push(`${attrName}: ${styles[attrName]}`)
  })

  return obj.join(';')
}

export const selectParser = (ary, mappingKeys) => {
  let a =[]
  if (!Array.isArray(ary)) ary = [ary]
  if (ary.length < 1) return []
  ary.forEach( (item, i) => {
    a[i] = {}
    Object.keys(mappingKeys).forEach( key  => {
      a[i][key] = item[mappingKeys[key]]
    })
  })
  return a
}

export const playerProfileTab = (tabName) => {
  const tab = Object.keys(playerProfileTabs).find( (tab) => tab === tabName)
  return playerProfileTabs[tab]
}