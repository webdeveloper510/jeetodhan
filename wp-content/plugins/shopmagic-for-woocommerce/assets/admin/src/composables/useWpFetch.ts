import { createFetch } from "@vueuse/core";

export const fetchOptions = {
  headers: {
    Accept: "application/json, application/problem+json",
    "X-WP-Nonce": window.ShopMagic.nonce,
  },
};

export const useWpFetch = createFetch({
  baseUrl: window.ShopMagic.baseUrl.replace(/\/$/, ""),
  fetchOptions,
});
