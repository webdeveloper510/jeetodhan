import { defineStore } from "pinia";
import type {
  ActionConfig,
  EventConfig,
  FilterConfig,
  PlaceholderConfig,
} from "@/types/automationConfig";
import type { Ref } from "vue";
import { computed, ref, unref } from "vue";
import useSWRV, { cache } from "@/_utils/swrv";
import { get } from "@/_utils";

type MaybeRef<T> = Ref<T> | T;

export const useAutomationResourcesStore = defineStore("automation", () => {
  const eventQuery = ref<string | null>(null);
  const { data: events } = useSWRV<EventConfig>("/resources/events", get, {
    cache,
    revalidateOnFocus: false,
  });
  const { data: actions } = useSWRV<ActionConfig[]>("/resources/actions", get, {
    cache,
    revalidateOnFocus: false,
  });
  const { data: filters } = useSWRV<FilterConfig[]>(
    () => `/resources/filters?event_slug=${eventQuery.value}`,
    get,
    { cache, revalidateOnFocus: false }
  );
  const { data: placeholders } = useSWRV<PlaceholderConfig[]>(
    () => `/resources/placeholders?event_slug=${eventQuery.value}`,
    get,
    { cache, revalidateOnFocus: false }
  );

  function fetchAvailableFilters(event: string | null) {
    eventQuery.value = event;
  }
  function fetchAvailablePlaceholders(event: string | null) {
    eventQuery.value = event;
  }

  const getFilter = computed(
    () => (search: MaybeRef<string>) =>
      filters.value?.find((f) => f.value === unref(search))
  );
  const getAction = computed(
    () => (name: MaybeRef<string>) =>
      actions.value?.find((a) => a.value === unref(name))
  );

  return {
    events,
    filters,
    actions,
    placeholders,
    getFilter,
    getAction,
    fetchAvailableFilters,
    fetchAvailablePlaceholders,
  };
});
