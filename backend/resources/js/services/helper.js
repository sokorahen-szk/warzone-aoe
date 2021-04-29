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
    }
  })
  return obj
}