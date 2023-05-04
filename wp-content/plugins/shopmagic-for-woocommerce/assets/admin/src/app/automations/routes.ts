const routes = [
  {
    path: "/automations",
    name: "automationsHolder",
    component: () => import("./views/AutomationsView.vue"),
    children: [
      {
        path: "",
        component: () => import("./views/AutomationsPage.vue"),
        name: "automations",
      },
      {
        path: "recipes",
        component: () => import("./views/RecipesPage.vue"),
        name: "recipes",
      },
      {
        path: "/automations/:id",
        name: "automation",
        component: () => import("./views/AutomationEdit.vue"),
      },
      ...(window.ShopMagic.modules.includes("shopmagic-manual-actions")
        ? [
            {
              path: "/automations/:id/manual/run",
              name: "manual-run",
              component: () => import("./views/ManualPreview.vue"),
            },
          ]
        : []),
    ],
  },
];

export default routes;
