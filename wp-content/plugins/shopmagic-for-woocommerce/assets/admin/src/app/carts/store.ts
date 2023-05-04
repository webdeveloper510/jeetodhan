import { acceptHMRUpdate, defineStore } from "pinia";
import type { Query } from "@/_utils";
import { ref, unref, watch } from "vue";
import useSWRV from "@/_utils/swrv";
import { useSearchParams } from "@/composables/useSearchParams";

export const useCartsStore = defineStore("carts", () => {
  const cartsUrl = ref("/carts");
  const countUrl = ref("/carts/count");
  const loading = ref(true);
  const { data } = useSWRV(cartsUrl);
  const { data: count } = useSWRV(countUrl);

  watch(data, (data) => {
    if (data !== undefined) {
      loading.value = false;
    }
  });

  function fetchItems(queryArgs?: Query) {
    loading.value = true;
    const previousUrl = unref(cartsUrl);
    if (queryArgs) {
      const searchQuery = useSearchParams(queryArgs);
      cartsUrl.value = "/carts?" + searchQuery;
      if (searchQuery.includes("filters")) {
        countUrl.value = "/carts/count?" + searchQuery;
      }
    } else {
      cartsUrl.value = "/carts";
      countUrl.value = "/carts/count";
    }
    if (previousUrl === cartsUrl.value) {
      loading.value = false;
    }
  }

  return { carts: data, loading, count, fetchItems };
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useCartsStore, import.meta.hot));
}
