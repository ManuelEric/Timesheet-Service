export const saveUser = data => {
  window.localStorage.setItem('user-data', JSON.stringify(data))
}

export const getUser = () => {
  return JSON.parse(window.localStorage.getItem('user-data'))
}

export const destroyUser = () => {
  window.localStorage.removeItem('user-data')
}

export default { saveUser, getUser, destroyUser }
