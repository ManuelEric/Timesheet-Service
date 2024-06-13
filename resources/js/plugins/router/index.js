import { createRouter, createWebHistory } from 'vue-router'
import adminRoutes from './admin'
import userRoutes from './user'

const routes = [
  ...adminRoutes,
  ...userRoutes
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})


export default function (app) {
  app.use(router)
}
export { router }
