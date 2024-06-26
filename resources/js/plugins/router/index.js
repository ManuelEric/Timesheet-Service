import { showNotif } from "@/helper/notification";
import { verifyAuth } from "@/helper/verifyAuth";
import { createRouter, createWebHistory } from "vue-router";
import adminRoutes from "./admin";
import userRoutes from "./user";

const routes = [...adminRoutes, ...userRoutes];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const verify = verifyAuth();

  if (to.meta.middleware == "auth-user") {
    if (verify.isAuthenticated.value) {
      next();
    } else {
      showNotif('error','Please login first!','bottom-end')
      next({ name: "login-user" });
    }
  } else if (to.meta.middleware == "auth-admin") {
    if (verify.isAuthenticated.value) {
      next();
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
