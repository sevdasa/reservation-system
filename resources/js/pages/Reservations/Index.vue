<!-- <script setup lang="ts">
import { ref } from 'vue';
import { useEcho } from '@laravel/echo-vue';
import type { Reservation } from '@/types/Reservation';

interface showData {
  reservations: Reservation[];
  bookable_id: string;
}

const props = defineProps<showData>();
const messages = ref<string[]>([]);

// useEcho را مستقیماً در بدنه اجرا کن، نه در onMounted
// useEcho(
//   `Reservation.bookable.${props.bookable_id}`,
//   'ReservationCreated',
//   (event: { reservation_id: number }) => {
//     console.log('رزرو جدید دریافت شد:', event);
//     messages.value.push(`رزرو جدید با شناسه ${event.reservation_id} ثبت شد.`);
//   }
// );
const echo = useEcho();

echo.private(`Reservation.bookable.${props.bookable_id}`)
  .listen('ReservationCreated', (event: { reservation_id: number }) => {
    console.log('رزرو جدید دریافت شد:', event);
    messages.value.push(`رزرو جدید با شناسه ${event.reservation_id} ثبت شد.`);
  });


</script> -->
<script setup lang="ts">
import { ref } from 'vue';
import { echo } from '@/plugins/echo';  // adjust path as needed
import type { Reservation } from '@/types/Reservation';
interface showData {
  reservations: Reservation[];
  bookable_id: string;
}

const props = defineProps<showData>();
const messages = ref<string[]>([]);

echo.private(`Reservation.bookable.${props.bookable_id}`)
  .listen('ReservationCreated', (event: { reservation: { reservation_id: number } }) => {
    console.log('ReservationCreated event received:', event);
    messages.value.push(`رزرو جدید با شناسه ${event.reservation.reservation_id} ثبت شد.`);
  });
</script>

<template>
  <div>
    <h1>رزروها</h1>
   
    <ul class="p-3">
      <li v-for="reservation in props.reservations" :key="reservation.id">
        {{ reservation?.user_id }} - {{ reservation.id }}
      </li>
    </ul>
    {{ messages.length }}
    <div v-if="messages.length">
      <h2>پیام‌ها:</h2>
      <ul>
        <li v-for="(message, index) in messages" :key="index">{{"messae:"+ message }}</li>
      </ul>
    </div>
  </div>
</template>