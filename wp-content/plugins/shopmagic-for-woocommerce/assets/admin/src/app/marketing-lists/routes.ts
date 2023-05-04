export default [
  {
    path: "/marketing-lists",
    component: () => import("./views/MarketingListsView.vue"),
    children: [
      {
        path: "",
        component: () => import("./views/MarketingListsPage.vue"),
        name: "lists",
      },
      {
        path: "subscribers",
        component: () => import("./views/SubscribersPage.vue"),
        name: "subscribers",
      },
      {
        path: "transfer",
        component: () => import("./views/TransferPage.vue"),
        name: "transfer",
      },
      {
        path: "/marketing-lists/:id",
        name: "marketing-list",
        component: () => import("./views/MarketingListEdit.vue"),
      },
    ],
  },
];
