import SWRVCache from "./cache";
import useSWRV, { mutate } from "./use-swrv";

export type { IConfig } from "./types";
export { mutate, SWRVCache };
export default useSWRV;
