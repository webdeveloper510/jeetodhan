<script lang="ts" setup>
import EventsPicker from "../components/EventsPicker.vue";
import ActionEditor from "../components/ActionEditor.vue";
import EditGroup from "../components/EditGroup.vue";
import AutomationSidebar from "../components/AutomationSidebar.vue";
import {
  NLayout,
  NLayoutContent,
  NLayoutHeader,
  NLayoutSider,
  useMessage,
} from "naive-ui";
import FilterEditor from "../components/FilterEditor.vue";
import { useAutomationResourcesStore } from "../resourceStore";
import { storeToRefs } from "pinia";
import { useSingleAutomation } from "../singleAutomation";
import { onBeforeRouteLeave, useRoute, useRouter } from "vue-router";
import EditBar from "@/components/EditBar.vue";
import { __ } from "@wordpress/i18n";
import { h } from "vue";

const message = useMessage();

const { events } = storeToRefs(useAutomationResourcesStore());

const {
  get,
  save,
  update,
  remove,
  addAutomation,
  $patch: patchAutomation,
} = useSingleAutomation();
const { automation } = storeToRefs(useSingleAutomation());

onBeforeRouteLeave(() => {
  patchAutomation((state) => (state.automation = null));
});

const route = useRoute();
const router = useRouter();

if (route.params.id === "new" && automation.value === null) {
  addAutomation();
} else if (!isNaN(parseInt(route.params.id))) {
  get(parseInt(route.params.id)).catch(() => {
    // @todo redirect on 404
  });
}

async function saveAutomation() {
  const m = message.loading(
    __("Saving automation", "shopmagic-for-woocommerce"),
    {
      duration: 0,
    }
  );
  try {
    if (!isNaN(parseInt(route.params.id))) {
      await update();
    } else {
      const id = await save();
      if (route.params.id === "new") {
        router.replace({
          name: "automation",
          params: {
            id: id.value,
          },
        });
      }
    }
    m.content = __("Automation saved", "shopmagic-for-woocommerce");
    m.type = "success";
  } catch (e) {
    let message = e.message;
    if (e.cause) {
      message = () => h("div", {}, e.cause.replace("\\n", "\n"));
    }
    m.content = message;
    m.type = "error";
  } finally {
    setTimeout(m.destroy, 3500);
  }
}

async function updatePublish(value: boolean) {
  patchAutomation({
    automation: {
      status: value ? "publish" : "draft",
    },
  });
  await saveAutomation();
}

function updateName(value: string) {
  patchAutomation({
    automation: {
      name: value,
    },
  });
}

function updateLanguage(value: string) {
  patchAutomation({
    automation: {
      language: value,
    },
  });
}

function updateParent(value: string) {
  patchAutomation({
    automation: {
      parent: value,
    },
  });
}

function deleteAutomation() {
  if (automation.value?.id) {
    remove(automation.value.id).then(() => {
      router.push({
        name: "automations",
      });
    });
  }
}
</script>
<template>
  <NLayout class="shadow-lg">
    <NLayoutHeader bordered class="drop-shadow-lg py-3 px-4">
      <EditBar
        :name="automation?.name"
        :name-placeholder="
          __('My awesome automation', 'shopmagic-for-woocommerce')
        "
        :publish="automation?.status === 'publish'"
        @save="saveAutomation"
        @update:publish="updatePublish"
        @update:name="updateName"
      />
    </NLayoutHeader>
    <NLayout has-sider>
      <NLayoutContent class="bg-gray-200">
        <EditGroup>
          <EventsPicker :events="events || []" :automation="automation" />
          <FilterEditor />
          <ActionEditor />
        </EditGroup>
      </NLayoutContent>
      <NLayoutSider :width="280">
        <AutomationSidebar
          :automation="automation"
          :publish="automation?.status === 'publish'"
          @delete="deleteAutomation"
          @save="saveAutomation"
          @update:publish="updatePublish"
          @update:name="updateName"
          @update:language="updateLanguage"
          @update:parent="updateParent"
        />
      </NLayoutSider>
    </NLayout>
  </NLayout>
</template>
