export default [
  { path: '/', redirect: '/user/login' },
  {
    path: '/',
    component: () => import('@/layouts/default.vue'),
    meta: {
      middleware: "auth-user",
    },
    children: [
      {
        path: '/user/dashboard',
        component: () => import('@/pages/user/dashboard/dashboard.vue'),
      },
      {
        path: '/user/request',
        component: () => import('@/pages/user/request/request.vue'),
      },
      {
        path: '/user/timesheet',
        component: () => import('@/pages/user/timesheet/timesheet.vue'),
      },
      {
        path: '/user/timesheet/:id/:require',
        props: route => ({
          id:route.params.id,
          require:route.params.require
        }),
        component: () => import('@/pages/user/timesheet/timesheet-detail.vue'),
      },
      {
        path: '/user/account-settings',
        component: () => import('@/pages/user/setting/account.vue'),
      },
    ],
  },
  {
    path: '/user',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        path: '/user/login',
        name:'login-user',
        component: () => import('@/pages/auth/login.vue'),
      },
      {
        path: '/reset-password/:token?/:email?',
        component: () => import('@/pages/auth/login.vue'),
        props: route => ({
          token:route.query.token,
          email:route.query.email
        })
      },
      {
        path: '/user/forgot',
        component: () => import('@/pages/auth/forgot.vue'),
      },
      {
        path: '/user/register',
        component: () => import('@/pages/auth/register.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]
