import type { DataTableColumns } from "naive-ui";
import GuestPreview from "../components/GuestPreview.vue";
import type { Client } from "@/stores/clients";
import { __ } from "@wordpress/i18n";
import { h } from "vue";
import dayjs from "dayjs";

export const guestsTableColumns: DataTableColumns<Client> = [
  {
    type: "selection",
  },
  {
    key: "email",
    title: __("Email", "shopmagic-for-woocommerce"),
  },
  {
    key: "lastActive",
    title: __("Last active", "shopmagic-for-woocommerce"),
    render: ({ lastActive }) =>
      dayjs(lastActive).format("D MMM, YYYY HH:mm:ss"),
  },
  {
    key: "created",
    title: __("Created", "shopmagic-for-woocommerce"),
    render: ({ created }) => dayjs(created).format("D MMM, YYYY HH:mm:ss"),
  },
  {
    key: "details",
    width: 150,
    title: __("Details", "shopmagic-for-woocommerce"),
    render: (guest) => h(GuestPreview, { guest }),
  },
];
