export default [
  { path: '/admin', redirect: '/admin/login' },
  {
    path: '/admin',
    component: () => import('@/layouts/admin/default.vue'),
    children: [
      {
        path: '/admin/dashboard',
        component: () => import('@/pages/admin/dashboard/dashboard.vue'),
      },
      {
        path: '/admin/tutor',
        component: () => import('@/pages/admin/tutor/tutor.vue'),
      },
      {
        path: '/admin/program',
        component: () => import('@/pages/admin/program/program.vue'),
      },
      {
        path: '/admin/timesheet',
        component: () => import('@/pages/admin/timesheet/timesheet.vue'),
      },
      {
        path: '/admin/timesheet/:id',
        component: () => import('@/pages/admin/timesheet/timesheet-detail.vue'),
      },
      {
        path: '/admin/unpaid',
        component: () => import('@/pages/admin/cut-off/unpaid.vue'),
      },
      {
        path: '/admin/paid',
        component: () => import('@/pages/admin/cut-off/paid.vue'),
      },
      {
        path: '/admin/account-settings',
        component: () => import('@/pages/admin/setting/account.vue'),
      },
    ],
  },
  {
    path: '/admin',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        path: '/admin/login',
        component: () => import('@/pages/auth/login-admin.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]
