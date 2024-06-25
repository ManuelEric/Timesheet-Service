export const saveToken = data => {
  window.localStorage.setItem('token', data)
}
  
export const getToken = () => {
  return window.localStorage.getItem('token')
}
  
export const destroyToken = () => {
  window.localStorage.removeItem('token')
}
  
export default { saveToken, getToken, destroyToken }
  