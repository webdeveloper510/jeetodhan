export default [
  {
    path: "/logs",
    component: () => import("./views/OutcomesView.vue"),
    children: [
      {
        path: "outcomes",
        component: () => import("./views/OutcomesPage.vue"),
        name: "outcomes",
      },
      {
        path: "queue",
        component: () => import("./views/QueuePage.vue"),
        name: "queue",
      },
      {
        path: "tracker",
        component: () => import("./views/TrackerPage.vue"),
        name: "tracker",
      },
    ],
  },
]
