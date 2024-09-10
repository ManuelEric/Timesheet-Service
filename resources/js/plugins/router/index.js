import { showNotif } from "@/helper/notification";
import { verifyAuth } from "@/helper/verifyAuth";
import UserService from "@/services/UserService";
import { createRouter, createWebHistory } from "vue-router";
import adminRoutes from "./admin";
import userRoutes from "./user";

const routes = [...adminRoutes, ...userRoutes];

const router = createRouter({
  history: createWebHistory("/"),
  routes,
});

router.beforeEach((to, from, next) => {
  const verify = verifyAuth();
  const user = UserService.getUser()

  if (to.meta.middleware == "auth-user") {
    if (verify.isAuthenticated.value) {
      if(user.role=='Tutor' || user.role=='Mentor') {
        next();
      } else {
        showNotif('error','You have not permission!','bottom-end')
        next({path:'/admin/dashboard'})
      }
    } else {
      showNotif('error','Please login first!','bottom-end')
      next({ name: "login-user" });
    }
  } else if (to.meta.middleware == "auth-admin") {
    if (verify.isAuthenticated.value) {
      if(user.role=='Tutor' || user.role=='Mentor') {
        next({path:'/user/dashboard'})
        showNotif('error','You have not permission!','bottom-end')
      } else {
        next();
      }
    } else {
      showNotif('error','Please login first!','bottom-end')
      next({ name: "login-admin" });
    }
  } else {
    next()
  }
});

export default function (app) {
  app.use(router);
}
export { router };
