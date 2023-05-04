import { acceptHMRUpdate, defineStore } from "pinia";
import { ref, unref, watch } from "vue";
import type { Subscriber } from "./types";
import type { Query } from "@/_utils";
import { useSearchParams } from "@/composables/useSearchParams";
import useSWRV from "@/_utils/swrv";
import { useWpFetch } from "@/composables/useWpFetch";

export const useSubscribersStore = defineStore("subscribersStore", () => {
  const url = ref<string | null>(null);
  const { data: subscribers, mutate } = useSWRV<Subscriber[]>(() => url.value);
  const countUrl = ref<string | null>(null);
  const { data: subscribersTotal } = useSWRV<number>(() => countUrl.value);
  const error = ref(null);
  const loading = ref(true);

  watch(subscribers, (data) => {
    if (data !== undefined) {
      loading.value = false;
    }
  });

  function getSubscribers(query?: Query) {
    loading.value = true;
    const previousUrl = unref(url);
    if (query) {
      const searchQuery = useSearchParams(query);
      url.value = `/subscribers?${searchQuery}`;
      if (searchQuery.includes("filters")) {
        countUrl.value = `/subscribers/count?${searchQuery}`;
      }
    } else {
      url.value = "/subscribers";
      countUrl.value = "/subscribers/count";
    }
    if (previousUrl === url.value) {
      loading.value = false;
    }
  }

  function deleteSubscribers(ids: number[]) {
    loading.value = true;
    Promise.all(ids.map((id) => useWpFetch(`/subscribers/${id}`).delete()))
      .then(() => mutate())
      .finally(() => (loading.value = false));
  }

  return {
    subscribers,
    subscribersTotal,
    loading,
    error,
    getSubscribers,
    deleteSubscribers,
  };
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useSubscribersStore, import.meta.hot));
}
