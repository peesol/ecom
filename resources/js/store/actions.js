export const addToCart = ({ commit }, { product, choice }) => {

  commit('appendToCart', { product, choice } )

  return axios.put(window.Data.url + '/cart/add/' + product.uid, {
    product, choice
  })

}

export const getCartCount = ({ commit }) => {

  return axios.get(window.Data.url + '/cart/get').then(response => {

    commit('setCount', response.data)

    return Promise.resolve()
  })
}

export const removeFromCart = ({ commit }) => {
  commit('removeCount')
}
