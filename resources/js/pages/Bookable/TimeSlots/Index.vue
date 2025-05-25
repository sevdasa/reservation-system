<script setup lang="ts">
import type { Bookable, PaginatedBookable } from '@/types/Bookable';
import { PaginatedTimeSlot, TimeSlot } from '@/types/TimeSlot';
import type { User } from '@/types/User';

interface TimeSlotProps {
  bookables: Bookable[];
  user: User;
  timeSlots: PaginatedTimeSlot[];
}
const props = defineProps<TimeSlotProps>();
</script>
<template>
    <div class="p-4 space-y-4">
      <h1 class="text-xl font-bold">انتخاب دکتر</h1>
  
      <div v-for="bookable in bookables" :key="bookable.id" class="p-4 border rounded shadow">
        <p class="font-semibold">👨‍⚕️ {{ bookable.name }}</p>
        <p class="text-sm text-gray-500">{{ bookable?.user?.email?? '' }}</p>
  
        <div class="mt-2">
          <h2 class="font-medium">⏰ تایم‌ اسلات‌ها:</h2>
          <ul class="list-disc list-inside">
            <li v-for="slot in bookable?.time_slots || []" :key="slot.id">
              {{ slot.date }} | {{ slot.start_time }} - {{ slot.end_time }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </template>
  

  