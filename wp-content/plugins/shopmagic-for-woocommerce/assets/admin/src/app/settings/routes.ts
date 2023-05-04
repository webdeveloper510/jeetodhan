export default [
  {
    path: "/settings/:page?",
    name: "settings",
    component: () => import("./views/SettingsPage.vue"),
  },
];
