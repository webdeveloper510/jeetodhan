import {computed, isRef, ref, toRaw, unref} from "vue";
import type {Automation} from "@/types/automation";
import {useWpFetch} from "@/composables/useWpFetch";
import {get} from "@/_utils";
import {acceptHMRUpdate, defineStore} from "pinia";
import type {HttpProblem} from "@/types";
import {useAutomationCache} from "@/app/automations/composables/automationsCache";
import {revalidateAutomations} from "@/app/automations/store";

export function removeAutomation(id: number) {
  return useSingleAutomation().remove(id);
}

export function downloadAutomation(id: number) {
  return useSingleAutomation().download(id);
}

export const useSingleAutomation = defineStore("singleAutomation", () => {
  const automation = ref<Automation | null>(null);
  const path = window.location.href.replace(window.location.origin, "");

  // watch(
  //   automation,
  //   (a) => {
  //     if (a === null) return;
  //     localStorage.setItem(`automation-${path}-content`, JSON.stringify(a));
  //     localStorage.setItem(
  //       `automation-${path}-time`,
  //       JSON.stringify(Date.now())
  //     );
  //   },
  //   { deep: true }
  // );

  async function deleteAutomation(id: number) {
    await useWpFetch(`/automations/${id}`).delete();
    try {
      revalidateAutomations();
    } catch (e) {
      console.warn(
        "Directly editing single automation. No collection to revalidate."
      );
    }
  }

  async function downloadAutomation(id: number) {
    return getAutomation(id).then(() => {
      const exportAutomation = assign(unref(automation), { id: null });
      const blob = new Blob([JSON.stringify(exportAutomation)], {
        type: "application/json",
      });
      const url = URL.createObjectURL(blob);
      const anchor = document.createElement("a");
      anchor.href = url;
      anchor.download = "automation";
      document.body.appendChild(anchor);
      anchor.click();
      document.body.removeChild(anchor);
      URL.revokeObjectURL(url);
    });
  }

  const assign = <T extends object>(...sources: T[]) => {
    return sources.reduce((result, current) => {
      return {
        ...result,
        ...current,
      };
    }, {});
  };

  async function duplicateAutomation(id: number) {
    const fetchedAutomation = await getAutomation(id);
    let automationCopy;
    if (isRef(fetchedAutomation)) {
      automationCopy = assign<Automation>(fetchedAutomation.value);
    } else {
      automationCopy = assign<Automation>(fetchedAutomation);
    }
    automationCopy.name = `${automationCopy.name} (duplicate)`;
    automation.value = null;
    automation.value = automationCopy;
    await saveAutomation();
  }

  async function saveAutomation() {
    const cleanAutomation = assign(automation.value, { id: null });
    const { data: id, error } = await useWpFetch<number | string>(
      "/automations"
    ).post(cleanAutomation, "json");
    if (error.value) {
      const errorMessage: HttpProblem = JSON.parse(id.value);
      throw new Error(errorMessage.title, { cause: errorMessage.detail });
    }
    automation.value.id = id.value;
    try {
      revalidateAutomations();
    } catch (e) {
      console.warn(
        "Directly editing single automation. No collection to revalidate."
      );
    }
    return id;
  }

  const getAutomation = async (id: number) => {
    const cachedAutomation = useAutomationCache(id);
    if (cachedAutomation) {
      automation.value = cachedAutomation;
      return cachedAutomation;
    }

    automation.value = await get<Automation>(`/automations/${id}`);
    return automation;
  };

  async function updateAutomation() {
    const { data, error } = await useWpFetch(
      `/automations/${automation.value.id}`
    ).put(automation, "json");
    if (error.value) {
      const errorMessage: HttpProblem = JSON.parse(data.value);
      throw new Error(errorMessage.title, { cause: errorMessage.detail });
    }
    // revalidateAutomations();
  }

  function createNullAutomation(): Automation {
    return {
      id: null,
      name: "",
      event: {
        name: null,
        settings: {},
      },
      actions: [],
      filters: [],
      status: "draft",
    };
  }

  function addAutomation(newAutomation?: Automation) {
    automation.value = { ...createNullAutomation(), ...newAutomation };
    return automation;
  }

  function addAction() {
    automation.value.actions.push({
      name: null,
      settings: {},
    });
  }

  function removeAction(id: number) {
    const actions = automation.value.actions.slice();
    delete actions[id];
    automation.value.actions = actions.filter(() => true);
  }

  const hasFilters = computed(() => {
    const filters = automation.value?.filters;
    if (filters?.length === 0) return false;

    return filters?.reduce((hasContent, f) => {
      const length = toRaw(f).length;
      return length > 0 && hasContent;
    }, true);
  });

  function addFilterGroup() {
    automation.value?.filters.push([]);
  }

  function insertFilter(group: number) {
    automation.value?.filters[group].push({
      id: null,
      condition: null,
    });
  }

  function addOrFilterGroup() {
    addFilterGroup();
    insertFilter(automation.value.filters.length - 1);
  }

  function removeFilter(group: number, id: number) {
    if (automation.value) {
      let mutableFilters = automation.value.filters[group].slice();
      delete mutableFilters[id];
      mutableFilters = [...mutableFilters.filter(() => true)];
      automation.value.filters[group] = mutableFilters;
      if (automation.value.filters[group].length === 0) {
        let mutableGroups = automation.value.filters;
        delete mutableGroups[group];
        mutableGroups = [...mutableGroups.filter(() => true)];
        automation.value.filters = mutableGroups;
      }
    }
  }

  const filter = computed(
    () => (groupId: number, filterId: number) =>
      automation.value?.filters?.[groupId][filterId]
  );

  return {
    automation,
    get: getAutomation,
    remove: deleteAutomation,
    save: saveAutomation,
    update: updateAutomation,
    duplicate: duplicateAutomation,
    download: downloadAutomation,
    addAutomation,
    addAction,
    removeAction,
    hasFilters,
    insertFilter,
    addOrFilterGroup,
    removeFilter,
    filter,
  };
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useSingleAutomation, import.meta.hot));
}
