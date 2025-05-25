import { Pagination } from "./Pagination"

import { Bookable } from "./Bookable"

export type TimeSlot = {
    id: number
    end_time: string
    start_time: string
    date:string
    bookable_id: number
    bookable: Bookable
    created_at: string
    updated_at: string
}

export type PaginatedTimeSlot = Pagination & { data: Array<TimeSlot> }