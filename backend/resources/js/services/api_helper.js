export const excludeNullParams = (obj) => {
  if (Object.keys(obj).length < 1) return {}
  Object.keys(obj).forEach( (key) => {
    if (!obj[key]) {
      delete obj[key]
    }
  })
  return obj
}

export const toString = (ary) => {
  if (!Array.isArray(ary)) return null
  let l = ary.filter( (item) => {
    return (item != null && item != '')
  })
  return l.join(',');
}