<script lang="ts" setup>
import { NA, NButton, NIcon, NProgress, NSkeleton, NSpace, NSpin, NTable } from "naive-ui";
import { Checkmark, CloseOutline } from "@vicons/ionicons5";
import { get } from "@/_utils";
import { useRoute } from "vue-router";
import { computed, ref, watch, watchEffect } from "vue";
import ShadyCard from "@/components/ShadyCard.vue";
import EditGroup from "../components/EditGroup.vue";
import { useAutomationResourcesStore } from "../resourceStore";
import { useWpFetch } from "@/composables/useWpFetch";
import { useSingleAutomation } from "@/app/automations/singleAutomation";
import { storeToRefs } from "pinia";

const { get: getAutomation } = useSingleAutomation();
const { automation } = storeToRefs(useSingleAutomation());
const { getAction } = useAutomationResourcesStore();

const STATES = {
  NOT_INITIALIZED: "notInitialized",
  LOADING: "loading",
  ERROR: "error",
  SUCCESS: "success",
} as const;

const { params: routeParams } = useRoute();
getAutomation(parseInt(routeParams.id));

const data = ref([]);
const total = ref(0);
const currentFetched = computed(() => data.value.length);
const loading = ref(true);
const queueDispatched = ref(STATES.NOT_INITIALIZED);
const BATCH_SIZE = 100;
const page = ref(1);
const error = ref<object | null>(null);
const maxPages = computed(() => Math.ceil(total.value / BATCH_SIZE));
const automationName = computed(() => automation.value?.name);
const automationActions = computed(() => {
  const rawActions = automation.value?.actions || [];
  return rawActions.map((action) => {
    const actionResource = getAction(action.name);
    return {
      ...action,
      name: actionResource?.label,
      description: action.settings?.description || "",
    };
  });
});
const processed = ref(0);
const processing = computed(() => Math.ceil((processed.value / maxPages.value) * 100));

watch(currentFetched, (items) => {
  if (items !== 0) {
    loading.value = false;
  }
});

function* getAllPreviewRuns() {
  for (; page.value <= maxPages.value; page.value++) {
    yield get(
      `/automations/${routeParams.id}/manual/matches?page_size=${BATCH_SIZE}&page=${page.value}`,
    )
      .then((matches) => data.value.push(...matches))
      .finally(() => processed.value++);
  }
}

get(`/automations/${routeParams.id}/manual/max`)
  .then((max) => {
    total.value = max;
  })
  .then(() => {
    Promise.all(getAllPreviewRuns()).finally(() => (loading.value = false));
  });

async function dispatchAutomations() {
  if (queueDispatched.value === STATES.SUCCESS) {
    return;
  }
  queueDispatched.value = STATES.LOADING;
  const { data: response, error: responseError } = useWpFetch(
    `/automations/${routeParams.id}/manual/run`,
  ).post(
    {
      resources: data.value.map(({ id, object }) => {
        return { id, object };
      }),
    },
    "json",
  );

  watchEffect(() => {
    if (response.value === undefined) {
      queueDispatched.value = STATES.LOADING;
      return;
    }

    if (!responseError.value) {
      queueDispatched.value = STATES.SUCCESS;
      return;
    }

    queueDispatched.value = STATES.ERROR;
    error.value = JSON.parse(response);
    return;
  });
}
</script>
<template>
  <EditGroup>
    <ShadyCard>
      <template #header>
        {{ __("Manual trigger sources for:") + " " }}
        <span v-if="automationName">
          {{ automationName }}
        </span>
        <NSkeleton v-else :width="150" text></NSkeleton>
      </template>
      <NSpin :show="loading">
        <ul class="h-[300px] overflow-y-scroll shadow-inner p-1">
          <li v-for="item in data" :key="item.id" class="p-1 rounded [&:nth-child(2n)]:bg-gray-50">
            <NA v-if="item.link" :href="item.link" target="_blank">
              {{ item.name }} #{{ item.id }}
            </NA>
            <span v-else> {{ item.name }} #{{ item.id }} </span>
          </li>
        </ul>
      </NSpin>
      <template #action>
        Total items: {{ currentFetched }}
        <NProgress
          :height="12"
          :percentage="processing"
          :processing="processing !== 100"
          :show-indicator="false"
          type="line"
        />
      </template>
    </ShadyCard>
    <ShadyCard title="Actions">
      <NTable>
        <thead>
          <tr>
            <th>{{ __("Type", "shopmagic-for-woocommerce") }}</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="automationActions.length === 0">
            <td>
              <NSkeleton :width="120" text />
            </td>
            <td>
              <NSkeleton :width="150" text />
            </td>
          </tr>
          <tr v-for="(action, i) in automationActions" :key="i">
            <td>{{ action.name }}</td>
            <td>{{ action.description }}</td>
          </tr>
        </tbody>
      </NTable>
    </ShadyCard>
    <NSpace>
      <NButton type="primary" @click="dispatchAutomations">
        <NSpin :show="queueDispatched === STATES.LOADING" :size="12" stroke="#eaeaea">
          <span v-if="queueDispatched === STATES.NOT_INITIALIZED">Run actions</span>
          <span v-else-if="queueDispatched === STATES.SUCCESS">
            <NIcon><Checkmark /> </NIcon>
          </span>
          <span v-else-if="queueDispatched === STATES.ERROR">
            <NIcon><CloseOutline /> </NIcon>
          </span>
        </NSpin>
      </NButton>
      <RouterLink :to="{ name: 'automation', params: routeParams }">
        <NButton>{{ __("Return to automation editor", "shopmagic-for-woocommerce") }}</NButton>
      </RouterLink>
    </NSpace>
  </EditGroup>
</template>
