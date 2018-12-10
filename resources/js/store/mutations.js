export const setCount = (state, items) => {
  state.cart = items
}

export const removeCount = (state, index) => {
  state.cart.splice(index, 1)
}

export const appendToCart = (state, { product, choice }) => {
  const existing = state.cart.find((item) => {
    return item.id === product.id && item.options.choice == choice
  })
  const id = product.id
  if (existing) {

  } else {
    state.cart.push({
      id,
      options: {
        choice: choice
      }
    })
  }
}
