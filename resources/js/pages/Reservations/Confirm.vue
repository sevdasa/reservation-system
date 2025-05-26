<script setup lang="ts">
import { Bookable } from '@/types/Bookable';
import { TimeSlot } from '@/types/TimeSlot';
import { User } from '@/types/User';
import { router } from '@inertiajs/vue3'

interface TimeSlotProps {
  bookable: Bookable;
  slot: TimeSlot;

}
const props = defineProps<TimeSlotProps>();


function submitReservation() {
  router.post(route('reservation.store'), {
    bookable_id: props.bookable.id,
    time_slot_id: props.slot.id,
  })
}
</script>
<template>
    <div class="p-4">
      <h1 class="text-xl font-bold">تأیید رزرو</h1>
      <div class="mt-4">
        <p><strong>دکتر:</strong> {{ bookable.name }}</p>
        <p><strong>تاریخ:</strong> {{ slot.date }}</p>
        <p><strong>ساعت:</strong> {{ slot.start_time }} - {{ slot.end_time }}</p>
      </div>
  
      <button
        class="mt-4 px-4 py-2 bg-green-600 text-white rounded"
        @click="submitReservation"
      >
        تایید نهایی رزرو
      </button>
    </div>
  </template>
  

  