<script setup lang="ts">
import { makeFarsi } from '@/lib/TimeUtils';
import { PaginatedReservation } from '@/types/Reservation';
import { User } from '@/types/User';

interface ReservationsInterface {
  reservations: PaginatedReservation,
  user: User
}

defineProps<ReservationsInterface>();
</script>
<template>
  <div class="p-4">
    <h1 class="text-xl font-bold">رزروهای {{ user.name }}</h1>

    <div v-if="reservations.data.length === 0" class="mt-4 p-4 border rounded">
      <p>هیچ رزروی وجود ندارد.</p>
    </div>
    <div v-for="res in reservations.data" :key="res?.id" class="mt-4 p-4 border rounded">
      <p v-if="res?.time_slot"><strong>دکتر:</strong> {{ res.time_slot?.bookable?.name }}</p>
      <p v-if="res?.time_slot"><strong>تاریخ:</strong> {{ makeFarsi(res.time_slot?.date) }}</p>
      <p v-if="res?.time_slot"><strong>ساعت:</strong> {{ res.time_slot?.start_time }} - {{ res.time_slot?.end_time }}
      </p>
    </div>
  </div>
</template>