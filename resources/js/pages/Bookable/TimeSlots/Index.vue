<script setup lang="ts">
import type { Bookable, PaginatedBookable } from '@/types/Bookable';
import { PaginatedTimeSlot, TimeSlot } from '@/types/TimeSlot';
import type { User } from '@/types/User';
import { formatDate, makeFarsi } from "@/lib/TimeUtils";
import { router } from '@inertiajs/vue3'


interface TimeSlotProps {
  bookables: Bookable[];
  user: User;
  TimeSlot: PaginatedTimeSlot[];
}
const props = defineProps<TimeSlotProps>();


function goToConfirm(bookableId: number, timeSlotId: number) {
  router.get(route('reservation.confirm'), {
    bookable: bookableId,
    slot: timeSlotId,
  })
}

</script>
<template>
  <div class="p-4 space-y-4">
    <h1 class="text-xl font-bold">bookable</h1>

    <div v-for="bookable in bookables" :key="bookable.id" class="p-4 border rounded shadow">
      <p class="font-semibold">👨‍⚕️ {{ bookable.name }}</p>
      <p class="text-sm text-gray-500">{{ bookable?.user?.email ?? '' }}</p>

      <div class="mt-2">
        <h2 class="font-medium">⏰ تایم‌ اسلات‌ها:</h2>
        <ul class="list-disc list-inside">
          <li v-for="slot in bookable?.time_slots || []" :key="slot.id">
            {{ makeFarsi(slot.date) }} |
            <p> <span>{{ slot.start_time }} - {{ slot.end_time }}</span></p>
            <button class="ml-2 px-3 py-1 bg-blue-500 text-white rounded text-sm"
              @click="goToConfirm(bookable.id, slot.id)">
              رزرو
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>