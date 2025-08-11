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
        name: 'user-dashboard',
        component: () => import('@/pages/user/dashboard/dashboard.vue'),
      },
      {
        path: '/user/request',
        name: 'user-request',
        component: () => import('@/pages/user/request/request.vue'),
      },
      {
        path: '/user/timesheet/:cat?',
        name: 'user-timesheet',
        props: route => ({
          cat:route.params.cat
        }),
        component: () => import('@/pages/user/timesheet/timesheet.vue'),
      },
      {
        path: '/user/timesheet/:id/:require',
        name: 'user-timesheet-detail',
        props: route => ({
          id:route.params.id,
          require:route.params.require
        }),
        component: () => import('@/pages/user/timesheet/timesheet-detail.vue'),
      },
      {
        path: '/user/account-settings',
        name: 'user-settings',
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
        path: '/user/login/:uuid',
        name:'login-uuid',
        component: () => import('@/pages/auth/login.vue'),
        props: route => ({
          uuid:route.params.uuid,
        }),
      },
      {
        path: '/reset-password/:token?/:email?',
        name: 'user-reset-password',
        component: () => import('@/pages/auth/login.vue'),
        props: route => ({
          token:route.query.token,
          email:route.query.email
        })
      },
      {
        path: '/user/forgot',
        name: 'user-forgot-password',
        component: () => import('@/pages/auth/forgot.vue'),
      },
      {
        path: '/user/register',
        name: 'user-register',
        component: () => import('@/pages/auth/register.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]
