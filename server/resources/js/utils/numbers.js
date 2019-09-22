Number.isInteger =
  Number.isInteger ||
  function(value) {
    return typeof value === 'number' && isFinite(value) && Math.floor(value) === value
  }

let format = (value, style) => {
  return new Intl.NumberFormat('fr-FR', {
    style,
    currency: 'EUR',
    minimumFractionDigits: Number.isInteger(value) ? 0 : 2
  }).format(value)
}

let formatDecimal = (value) => {
  return format(value, 'decimal')
}

let formatPercent = (value) => {
  return format(value / 100, 'percent')
}

let formatCurrency = (value) => {
  return format(value, 'currency')
}

export { formatDecimal, formatPercent, formatCurrency }
