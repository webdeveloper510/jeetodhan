<script lang="ts" setup>
import { NButton, NH1, NInput, NSelect } from "naive-ui";
import { reactive, ref } from "vue";
import DataTable from "@/components/Table/DataTable.vue";
import { automationTableColumns } from "../data/table";
import { useAutomationResourcesStore } from "../resourceStore";
import { storeToRefs } from "pinia";
import { elementsAsOptions } from "@/_utils";
import router from "@/router";
import StatusSelect from "@/app/automations/components/StatusSelect.vue";
import { useDebounceFn } from "@vueuse/core";
import { useAutomationCollectionStore } from "@/app/automations/store";
import { useSingleAutomation } from "@/app/automations/singleAutomation";

const automationStore = useAutomationCollectionStore();
const { fetchItems, deleteAutomations } = automationStore;
const { loading, toArray, count } = storeToRefs(automationStore);
const events = ref([]);

// First, we want to fetch automations
fetchItems().then(() => {
  events.value = useAutomationResourcesStore().events;
});

const singleAutomationStore = useSingleAutomation();

const tableFilters = reactive({
  status: null,
  event: null,
  name: null,
});

const filterAutomations = useDebounceFn((v) => (tableFilters.name = v), 500, {
  maxWait: 5000,
});

const bulkAction = ref<string | null>(null);
const checkedRows = ref([]);

function executeBulkAction() {
  if (bulkAction.value === "delete") {
    try {
      deleteAutomations(checkedRows.value);
    } catch (e) {
      console.error(e);
    } finally {
      checkedRows.value = [];
    }
  }
}

const showImport = ref(false);
const automationImportFile = ref<File | null>(null);

function selectFile(e: Event) {
  const file = e.target?.files[0] as File;
  if (file.type !== "application/json") throw Error("Invalid file type");
  automationImportFile.value = file;
}
function importAutomation() {
  automationImportFile.value?.text().then((file) => {
    const content = JSON.parse(file);
    if (Array.isArray(content)) {
      content.forEach((automation) => {
        singleAutomationStore.addAutomation(automation);
        singleAutomationStore.save();
      });
    } else {
      singleAutomationStore.addAutomation(content);
      singleAutomationStore.save();
    }
  });
}

async function navigate() {
  await router.push({
    name: "automation",
    params: { id: "new" },
  });
}
</script>
<template>
  <div class="flex items-center gap-4">
    <NH1 class="m-0">{{ __("Automations", "shopmagic-for-woocommerce") }}</NH1>
    <NButton type="primary" @click="navigate">
      {{ __("Add new", "shopmagic-for-woocommerce") }}
    </NButton>
    <NButton @click="showImport = !showImport">
      {{ __("Import", "shopmagic-for-woocommerce") }}
    </NButton>
  </div>
  <div v-if="showImport" class="my-6 mx-auto w-[560px]">
    <p class="text-center">
      {{
        __(
          "If you have an automation in JSON format, you can import it by submitting the form below.",
          "shopmagic-for-woocommerce"
        )
      }}
    </p>
    <form class="flex justify-between p-8 bg-gray-50">
      <label class="sr-only" for="automation-file">{{
        __("JSON automation to import")
      }}</label>
      <input id="automation-file" type="file" @change="selectFile" />
      <NButton secondary type="info" @click="importAutomation">
        {{ __("Import automation", "shopmagic-for-woocommerce") }}
      </NButton>
    </form>
  </div>
  <DataTable
    v-model:checked-row-keys="checkedRows"
    :columns="automationTableColumns"
    :data="toArray"
    :error="null"
    :filters="tableFilters"
    :loading="loading"
    :total-count="count"
    @update:data="fetchItems"
  >
    <template #filters>
      <NInput
        :placeholder="__('Search automation', 'shopmagic-for-woocommerce')"
        clearable
        @update:value="(v) => filterAutomations(v)"
      />
      <StatusSelect @update:value="tableFilters.status = $event" />
      <NSelect
        :options="elementsAsOptions(events)"
        :placeholder="__('Select event', 'shopmagic-for-woocommerce')"
        clearable
        filterable
        @update:value="tableFilters.event = $event"
      />
    </template>
    <template #bulkActions>
      <NSelect
        v-model:value="bulkAction"
        :options="[
          {
            label: __('Delete', 'shopmagic-for-woocommerce'),
            value: 'delete',
          },
        ]"
        class="w-[320px]"
      />
      <NButton @click="executeBulkAction">
        {{ __("Execute", "shopmagic-for-woocommerce") }}
      </NButton>
    </template>
  </DataTable>
</template>
