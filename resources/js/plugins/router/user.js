export default [
  { path: '/', redirect: '/user/login' },
  {
    path: '/',
    component: () => import('@/layouts/default.vue'),
    children: [
      {
        path: '/user/dashboard',
        component: () => import('@/pages/user/dashboard/dashboard.vue'),
      },
      {
        path: '/user/timesheet',
        component: () => import('@/pages/user/timesheet/timesheet.vue'),
      },
      {
        path: '/user/timesheet/:id',
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
