import type { App } from "vue";
import { __ } from "@wordpress/i18n";

export const i18n = {
  install: (app: App, options: { domain?: string }) => {
    app.config.globalProperties.__ = (text: string, domain?: string) => {
      return __(text, domain || options.domain || "default");
    };
  },
};

export { __ };

declare module "@vue/runtime-core" {
  export interface ComponentCustomProperties {
    __: (text: string, domain?: string) => string;
  }
}
