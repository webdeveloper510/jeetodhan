import type { SelectGroupOption, SelectOption } from "naive-ui";
import type {
  AutomationConfig,
  AutomationConfigElement,
} from "@/types/automationConfig";
import { useSorter } from "@/composables/useSorter";
import type { Filters } from "@/composables/useFilter";
import { useFilter } from "@/composables/useFilter";
import { useWpFetch } from "@/composables/useWpFetch";
import { type Ref, unref } from "vue";

export function elementsAsOptions(
  elements: AutomationConfigElement[] | undefined
): Array<SelectOption | SelectGroupOption> {
  if (typeof elements === "undefined") return [];

  if (!isGroupable(elements)) return elements;

  const groups: Map<string, SelectGroupOption> = new Map();
  elements?.forEach((element) => {
    if (typeof element.group === "undefined") return;
    if (!groups.has(element.group)) {
      groups.set(element.group, {
        type: "group",
        label: element.group,
        key: element.group,
        children: [],
      });
    }

    const group = groups.get(element.group) as SelectGroupOption;
    group.children?.push(element);
  });
  return [...groups.values()];
}

const isGroupable = (
  config: AutomationConfig[]
): config is AutomationConfigElement[] =>
  config.every((i) => typeof i.group !== "undefined");

type MaybeRef<T> = Ref<T> | T;

type ApiProblem = {
  type: string;
  title: string;
  status: number;
  detail: string;
};

export async function get<Data = unknown>(
  url: MaybeRef<string>
): Promise<Data> {
  const { data, error } = await useWpFetch<Data | ApiProblem>(url).json();
  if (error.value) {
    throw new Error(data);
  }
  return unref(data);
}
type SortOrder = false | "ascend" | "descend";

export type SortQuery = {
  [q: string]: SortOrder;
};

export type Query = Partial<{
  page: number;
  pageSize: number;
  filters: Filters | null;
  order: SortQuery | null;
}>;

type UnknownObject = {
  [p: string]: unknown;
};

export function query<T extends UnknownObject>(
  rawData: Iterable<T>,
  { page = 1, pageSize = 20, filters, order }: Query
): T[] {
  const sortedResult = order
    ? [...rawData].sort(useSorter(order))
    : [...rawData];
  const filteredResult =
    filters && Object.keys(filters).length
      ? sortedResult.filter(useFilter(filters))
      : sortedResult;
  return filteredResult.slice((page - 1) * pageSize, page * pageSize);
}

type KeyedItem = {
  id: number;
} & UnknownObject;

export function toMap<TObject extends KeyedItem>(
  array: TObject[]
): Map<TObject["id"], TObject> {
  return new Map(array.map((a) => [a.id, { ...a }]));
}
