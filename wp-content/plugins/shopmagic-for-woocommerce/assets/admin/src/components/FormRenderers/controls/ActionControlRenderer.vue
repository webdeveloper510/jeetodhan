<template>
  <FieldWrapper :show-label="false" v-bind="controlWrapper">
    <NButton
      :id="control.id + '-action'"
      :disabled="!control.enabled"
      :readonly="control.schema.readOnly"
      secondary
      type="info"
      @click="callback"
      >{{ control.label }}</NButton
    >
  </FieldWrapper>
</template>

<script lang="ts">
import type { ControlElement } from "@jsonforms/core";
import { NButton } from "naive-ui";
import { defineComponent } from "vue";
import { rendererProps, type RendererProps, useJsonFormsControl } from "@jsonforms/vue";
import { useVanillaControl } from "../util";
import FieldWrapper from "./FieldWrapper.vue";
import { fetchOptions } from "@/composables/useWpFetch";
import { useFetch } from "@vueuse/core";

export default defineComponent({
  name: "ActionControlRenderer",
  components: {
    FieldWrapper,
    NButton,
  },
  props: {
    ...rendererProps<ControlElement>(),
  },
  setup(props: RendererProps<ControlElement>) {
    return useVanillaControl(useJsonFormsControl(props), (target) => target || undefined);
  },
  methods: {
    callback() {
      const callbackUrl = this.control.schema.presentation.callback;

      useFetch(callbackUrl, {
        beforeFetch: ({ options }) => {
          options.headers = {
            ...options.headers,
            ...fetchOptions.headers,
          };

          return {
            options,
          };
        },
      })
        .post()
        .json();
    },
  },
});
</script>
