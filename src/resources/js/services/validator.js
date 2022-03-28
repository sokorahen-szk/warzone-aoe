const validator = function(rules) {
  let l = [];
  let append = [];

  if (!rules || !rules.types) return append

  if (Array.isArray(rules.types.split(','))) {
    l = rules.types.split(',')
  } else {
    return append;
  }
  l.forEach( value => {
    append.push(test(rules.label, value))
  })

  return append
}

const test = function(label, value) {
  if (value == null || value == '') return
  let a = value.split(':')
  switch(a[0]) {
    case 'required':
      return v => !!v || `${label}は必須です。`
    case 'min':
      return v => (v && v.length >= a[1]) || `${label}は${a[1]}以上で入力して下さい。`
    case 'max':
      return v => (v && v.length <= a[1]) || `${label}は${a[1]}以下で入力して下さい。`
    case 'confirm':
      return v => (v && v === a[1]) || `${label}が一致しません。`
  }
}

module.exports = {
  validator
}