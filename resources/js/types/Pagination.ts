export type Link = {
    active: boolean
    label: string
    url: string|null
}

export type Pagination = {
    current_page: number
    first_page_url: string | null
    from: number
    last_page: number
    last_page_url: string|null
    next_page_url: string | null
    path: string
    per_page: number
    prev_page_url: number | null
    to: number
    total: number
    links: Array<Link>
}