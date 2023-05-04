import type { Query } from "@/_utils";
import { isReactive, isRef, toRaw, unref } from "vue";

export function useSearchParams(query: Query) {
  function traverse(object: object, previousObject?: object): string {
    return Object.entries(object).reduce((previous, [key, value]) => {
      if (isReactive(value)) {
        value = toRaw(value);
      }
      if (isRef(value)) {
        value = unref(value);
      }
      if (value === null) return previous;

      if (typeof value === "object") {
        return previous + traverse(value, { [key]: value });
      }

      if (typeof value === "function") {
        value = value();
      }

      let keyString = `${key}`;
      if (previousObject !== undefined) {
        keyString = `${Object.keys(previousObject)[0]}[${key}]`;
      }

      return previous + "&" + `${keyString}=${value}`;
    }, "");
  }

  return traverse(toRaw(query)).slice(1);
}
