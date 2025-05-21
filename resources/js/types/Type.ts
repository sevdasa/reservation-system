import { Type } from "lucide-vue-next";
import { Pagination } from "./Pagination";

export type Type{
    id: number,
    name: string,
    description: string
}
export type PaginatedType = Pagination & { data: Array<Type> }
