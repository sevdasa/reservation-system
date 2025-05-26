import { Pagination } from "./Pagination"
import { TimeSlot } from "./TimeSlot"
import { User } from "./User"

export type Reservation = {
    id: number
    time_slot_id: number
    user_id: number
    time_slot: TimeSlot
    user: User
    status: string
    payment_status: string
    notes: string
    created_at: string
    updated_at: string
}

export type PaginatedReservation = Pagination & { data: Array<Reservation> }