import { Pagination } from "./Pagination"
import { TimeSlot } from "./TimeSlot"
import { Type } from "./Type"
import { User } from "./User"

export type Bookable = {
    id: number
    name: string
    description: string
    type_id: number
    type: Type
    user: User
    time_slots: TimeSlot[]
    created_at: string
    updated_at: string
}

export type PaginatedBookable = Pagination & { data: Array<Bookable> }