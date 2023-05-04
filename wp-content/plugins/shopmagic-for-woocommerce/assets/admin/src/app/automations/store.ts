import { defineStore, storeToRefs } from "pinia";
import type { Automation } from "@/types/automation";
import { useAutomationResourcesStore } from "./resourceStore";
import type { Query } from "@/_utils";
import { get } from "@/_utils";
import { useWpFetch } from "@/composables/useWpFetch";
import { computed, ref, unref, watch, watchEffect } from "vue";
import { useSearchParams } from "@/composables/useSearchParams";
import useSWRV from "@/_utils/swrv";

export function revalidateAutomations() {
  useAutomationCollectionStore().revalidateAutomations();
}

export function fetchAutomations(query: Query): Promise<Automation[]> {
  return useAutomationCollectionStore().fetchItems(query);
}

export function findAutomationsBy(query: Query): Promise<Automation[]> {
  return useAutomationCollectionStore().findBy(query);
}

export function getAutomations() {
  return storeToRefs(useAutomationCollectionStore()).automations;
}

export const useAutomationCollectionStore = defineStore(
  "automationCollection",
  () => {
    const automationsUrl = ref<string | null>(null);
    const countUrl = ref<string | null>(null);
    const loading = ref(false);
    const { data, mutate } = useSWRV<Automation[]>(() => automationsUrl.value);

    watch(data, (data) => {
      if (data !== undefined) {
        loading.value = false;
      }
    });

    const { data: count } = useSWRV<number>(countUrl);

    function findBy(query: Query) {
      const searchQuery = useSearchParams(query);
      return get<Automation[]>(`/automations?${searchQuery}`);
    }

    function fetchItems(queryArgs?: Query) {
      loading.value = true;
      const previousUrl = unref(automationsUrl);
      if (queryArgs) {
        const searchQuery = useSearchParams(queryArgs);
        automationsUrl.value = "/automations?" + searchQuery;
        if (searchQuery.includes("filters")) {
          countUrl.value = "/automations/count?" + searchQuery;
        }
      } else {
        automationsUrl.value = "/automations";
        countUrl.value = "/automations/count";
      }
      if (previousUrl === automationsUrl.value) {
        loading.value = false;
      }
      return new Promise((resolve) => {
        watchEffect(() => {
          if (data.value !== undefined) {
            resolve(data.value);
          }
        });
      });
    }

    function revalidateAutomations() {
      loading.value = true;
      mutate().finally(() => {
        loading.value = false;
      });
    }

    function deleteAutomations(ids: number[]) {
      loading.value = true;
      Promise.all(ids.map((id) => useWpFetch(`/automations/${id}`).delete()))
        .then(() => mutate())
        .finally(() => (loading.value = false));
    }

    const toArray = computed(() => {
      if (typeof data.value === "undefined") {
        return [];
      }
      const { events, actions: actionsStore } = storeToRefs(
        useAutomationResourcesStore()
      );
      return data.value.map((automation) => {
        const event = events.value?.find(
          (e) => automation?.event.name === e.value
        );
        const actions = actionsStore.value
          ?.filter((a) => {
            return automation?.actions.map((au) => au.name).includes(a.value);
          })
          .map((a) => a.label as string);
        return {
          ...automation,
          event: event?.label || "No event selected",
          actions,
        };
      });
    });
    return {
      automations: data,
      toArray,
      loading,
      count,
      fetchItems,
      deleteAutomations,
      revalidateAutomations,
      findBy,
    };
  }
);
