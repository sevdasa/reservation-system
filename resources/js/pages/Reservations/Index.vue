<script setup lang="ts">
import { ref, watch ,reactive,toRefs} from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import type { PaginatedReservation ,Reservation} from '@/types/Reservation'; 
import type { Bookable } from '@/types/Bookable'; 
import { Inertia } from '@inertiajs/inertia';
import { echo } from '@/plugins/echo';
import { Pagination } from '@/types/Pagination';
import { configureEcho } from '@laravel/echo-vue';

if (typeof window !== 'undefined') {
  configureEcho({
    broadcaster: 'reverb',
  });
}
interface showData {
  reservations: PaginatedReservation;
  bookables: Bookable[];
  bookable_id?: string;
  filters: {
    bookable_id?: string;
    date_from?: string;
    date_to?: string;
  };
}

const props = defineProps<showData>();

// const filters = toRefs(reactive({
//   bookable_id: props.bookable_id || props.filters.bookable_id || '',
//   date_from: props.filters.date_from || '',
//   date_to: props.filters.date_to || '',
// }));


// // استفاده از toRefs
// // const { bookable_id, date_from, date_to } = toRefs(filters);

// watch(() => filters.bookable_id, (newVal) => {
//   console.log('bookable_id changed:', newVal);
// });
// // وقتی فیلترها تغییر کرد، با debounce یا مستقیم درخواست جدید بفرست
// function goToPage(page: number) {
//   console.log('goToPage called with page:', `/reservation?page=${page}&id=${props.bookable_id}`);
  
//   Inertia.get(`/reservation?page=${page}&id=${filters.bookable_id}`, { preserveState: true, replace: true });
// }

// // console.log(localStorage);

// const messages = ref<string[]>([]);
// // console.log('props.bookable_id', props.bookable_id);
// if (typeof window !== 'undefined' && props.bookable_id) {
//   echo.private(`Reservation.bookable.${props.bookable_id}`)
//     .listen('ReservationCreated', (event: { reservation: { reservation_id: number } }) => {
//       messages.value.push(`رزرو جدید با شناسه ${event.reservation.reservation_id} ثبت شد.`);
//       console.log(`رزرو جدید با شناسه ${event.reservation.reservation_id} ثبت شد.`);
//     });
// }
</script>

<template>
  <div class="max-w-4xl mx-auto p-6">

    <h1 class="text-3xl font-semibold mb-6 text-gray-800 dark:text-gray-100">رزروها</h1>

    <!-- فرم فیلتر -->
    <form @submit.prevent>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <!-- فیلتر دکتر -->
        <select
          v-model="filters.bookable_id"
          class="border rounded px-3 py-2 w-full"
        >
          <option value="">همه دکترها</option>
          <option
            v-for="doctor in props.bookables"
            :key="doctor.id"
            :value="doctor.id"
          >
            {{ doctor.name }}
          </option>
        </select>

        <!-- فیلتر تاریخ از -->
        <input
          type="date"
          v-model="filters.date_from"
          class="border rounded px-3 py-2 w-full"
          placeholder="از تاریخ"
        />

        <!-- فیلتر تاریخ تا -->
        <input
          type="date"
          v-model="filters.date_to"
          class="border rounded px-3 py-2 w-full"
          placeholder="تا تاریخ"
        />
      </div>
    </form>
    <!-- لیست رزروها -->
    <ul class="mb-8 space-y-3">
      <li
        v-for="reservation in props.reservations.data"
        :key="reservation?.id"
        class="p-4 bg-white dark:bg-gray-700 rounded shadow flex justify-between items-center"
      >
        <span class="text-gray-700 dark:text-gray-200 font-medium">
          کاربر: {{ reservation?.user_id ?? 'ناشناخته' }}
        </span>
        <span class="text-gray-500 dark:text-gray-400">
          شناسه: {{ reservation.id }}
        </span>
      </li>
    </ul>

    <!-- paginatio///ns
   <nav
  v-if="props.reservations.last_page > 1"
  class="flex justify-center space-x-2"
  aria-label="Pagination"
>
  <button
    :disabled="props.reservations?.current_page === 1"
    @click="goToPage((props.reservations?.current_page ?? 1) - 1)"
    class="px-3 py-1 border rounded disabled:opacity-50"
  >
    قبلی
  </button>

  <button
    v-for="page in props.reservations?.last_page || 1"
    :key="page"
    :class="{
      'bg-green-500 text-white': page === props.reservations?.current_page,
      'bg-white text-gray-700': page !== props.reservations?.current_page,
    }"
    @click="goToPage(page)"
    class="px-3 py-1 border rounded"
  >
    {{ page }}
  </button>

  <button
    :disabled="props.reservations?.current_page === props.reservations?.last_page"
    @click="goToPage((props.reservations?.current_page ?? 1) + 1)"
    class="px-3 py-1 border rounded disabled:opacity-50"
  >
    بعدی
  </button>
</nav> -->


    <!-- پیام‌های اطلاع‌رسانی -->
    <!-- <div v-if="messages.length" class="space-y-3 mt-6">
      <h2 class="text-xl font-semibold mb-3 text-green-700 dark:text-green-400">پیام‌ها:</h2>
      <ul>
        <li
          v-for="(message, index) in messages"
          :key="index"
          class="bg-green-100 text-green-800 px-4 py-3 rounded-md shadow-md mb-2 max-w-full break-words"
          role="alert"
        >
          {{ message }}
        </li>
      </ul>
    </div>

    <p v-else class="text-gray-500 dark:text-gray-400 text-center mt-6">
      هنوز رزروی ثبت نشده است.
    </p> -->
  </div>
</template>
