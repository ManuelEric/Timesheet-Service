export default [
  // LOGIN FROM MENTORING 
  { 
    path: '/mentoring/login/:email',
    props: route => ({
      email:route.params.email,
      token:route.query.token,
    }),
    component: () => import('@/pages/auth/login-admin.vue'),
  },
  { path: '/admin', redirect: '/admin/login' },
  {
    path: '/admin',
    component: () => import('@/layouts/admin/default.vue'),
    meta: {
      middleware: "auth-admin",
    },
    children: [
      {
        path: '/admin/dashboard',
        name:'admin-dashboard',
        component: () => import('@/pages/admin/dashboard/dashboard.vue'),
      },
      {
        path: '/admin/tutor',
        name:'admin-tutor-mentor',
        component: () => import('@/pages/admin/tutor/tutor.vue'),
      },
      {
        path: '/admin/program/:name',
        name:'admin-program',
        props: route => ({
          name:route.params.name,
        }),
        component: () => import('@/pages/admin/program/program.vue'),
      },
      {
        path: '/admin/timesheet/:name',
        name:'admin-timesheet',
        props: route => ({
          name:route.params.name,
        }),
        component: () => import('@/pages/admin/timesheet/timesheet.vue'),
      },
      {
        path: '/admin/timesheet/:name/:id',
        name:'admin-timesheet-detail',
        props: route => ({
          name:route.params.name,
          id:route.params.id,
        }),
        component: () => import('@/pages/admin/timesheet/timesheet-detail.vue'),
      },
      {
        path: '/admin/cut-off/pre',
        name:'admin-cut-off-pre',
        component: () => import('@/pages/admin/cut-off/pre.vue'),
      },
      {
        path: '/admin/cut-off/completed',
        name:'admin-cut-off-paid',
        component: () => import('@/pages/admin/cut-off/completed.vue'),
      }
    ],
  },
  {
    path: '/admin',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        name:'login-admin',
        path: '/admin/login',
        component: () => import('@/pages/auth/login-admin.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        name:'error-page',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]

// Admin Router 
