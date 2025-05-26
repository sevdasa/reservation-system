import { Pagination } from "./Pagination"

import { Bookable } from "./Bookable"
import { Reservation } from "./Reservation"

export type TimeSlot = {
    id: number
    end_time: string
    start_time: string
    date:string
    bookable_id: number
    bookable: Bookable
    reservation: Reservation | null
    created_at: string
    updated_at: string
    user: Reservation['user']
}

export type PaginatedTimeSlot = Pagination & { data: Array<TimeSlot> }