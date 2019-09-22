function objectToFormData(obj, form, namespace) {
  let fd = form || new FormData()

  for (let property in obj) {
    if (!obj.hasOwnProperty(property)) {
      continue
    }

    let formKey = namespace ? `${namespace}[${property}]` : property

    if (obj[property] === null) {
      fd.append(formKey, '')
      continue
    }
    if (obj[property] instanceof Array && obj[property].length === 0) {
      fd.append(formKey, '')
      continue
    }
    if (typeof obj[property] === 'boolean') {
      fd.append(formKey, obj[property] ? '1' : '0')
      continue
    }
    if (obj[property] instanceof Date) {
      fd.append(formKey, obj[property].toISOString())
      continue
    }
    if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
      objectToFormData(obj[property], fd, formKey)
      continue
    }
    fd.append(formKey, obj[property])
  }

  return fd
}

export { objectToFormData }
