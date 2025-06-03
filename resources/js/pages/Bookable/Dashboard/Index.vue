<script setup lang="ts">
import { TimeSlot } from '@/types/TimeSlot';
import { User } from '@/types/User';

interface TimeSlotProps {
    slots: TimeSlot[];
    user: User;

}
defineProps<TimeSlotProps>();
</script>
<template>
    <div class="p-4">
        <h1 class="text-xl font-bold">داشبورد دکتر</h1>

        <div v-for="slot in slots" :key="slot.id" class="mt-4 p-4 border rounded">
            <p><strong>تاریخ:</strong> {{ slot.date }}</p>
            <p><strong>زمان:</strong> {{ slot.start_time }} - {{ slot.end_time }}</p>
            <p><strong>رزروها:</strong></p>
            <ul v-if="slot.reservation" class="list-disc ml-6">
                <!-- <li v-for="res in slot.reservation" :key="res.id"> -->
                    <li>{{ slot.reservation.user.name }} 
                </li>
            </ul>
        </div>
    </div>
</template>