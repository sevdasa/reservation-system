<script lang="ts" setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import InputLabel from "@/components/InputLabel.vue";
import { Icon } from '@iconify/vue'

import {
  DatePickerArrow,
  DatePickerCalendar,
  DatePickerCell,
  DatePickerCellTrigger,
  DatePickerContent,
  DatePickerField,
  DatePickerGrid,
  DatePickerGridBody,
  DatePickerGridHead,
  DatePickerGridRow,
  DatePickerHeadCell,
  DatePickerHeader,
  DatePickerHeading,
  DatePickerInput,
  DatePickerNext,
  DatePickerPrev,
  DatePickerRoot,
  DatePickerTrigger,
} from 'radix-vue'


const form = useForm({
  date: '',
  start_time: '',
  bookable_id: '',
  end_time: ''
})

const preferences = [
  { label: 'Farsi (Iran)', locale: 'fa-IR', territories: 'IR', ordering: 'persian gregory islamic islamic-civil islamic-tbla' },
];

const locale = ref(preferences[0].locale)

watch(() => form.date, (newValue) => {
  form.date = String(newValue);
});
function submit() {
  form.post(route('doctor.time-slots.store'))
}
</script>

<template>
  <div class="max-w-md mx-auto mt-12 bg-white p-8 rounded-3xl shadow-lg">
    <h1 class="text-2xl font-extrabold mb-6 text-gray-900">ثبت تایم‌ جدید</h1>

    <form @submit.prevent="submit" class="space-y-6">
      <div class="transition-opacity duration-300">
        <InputLabel for="date" value="تاریخ مورد نظر" />
        <DatePickerRoot
          id="date-field"
          :v-model="form.date"
          :locale="locale"
          class="mt-4 rounded-xl bg-gray-50 p-5 shadow-inner"
          fixed-weeks
          @update:modelValue="value => form.date = value?.toString() || ''"
        >
          <DatePickerField
            v-slot="{ segments }"
            class="flex select-none items-center justify-between rounded-lg border border-gray-300 bg-white px-3 py-2 text-center text-gray-700 shadow-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500"
            data-invalid="false"
          >
            <div class="flex space-x-1 rtl:space-x-reverse">
              <template v-for="item in segments" :key="item.part">
                <DatePickerInput
                  v-if="item.part === 'literal'"
                  :part="item.part"
                  class="select-text"
                >
                  {{ item.value }}
                </DatePickerInput>
                <DatePickerInput
                  v-else
                  :part="item.part"
                  class="rounded px-1 py-0.5 focus:outline-none focus:ring-1 focus:ring-blue-400 data-placeholder:text-gray-400"
                >
                  {{ item.value }}
                </DatePickerInput>
              </template>
            </div>

            <DatePickerTrigger
              class="rounded-md p-1 text-blue-600 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400"
              aria-label="Select date"
            >
              <Icon icon="radix-icons:calendar" class="w-6 h-6" />
            </DatePickerTrigger>
          </DatePickerField>

          <DatePickerContent
            :side-offset="4"
            class="rounded-xl bg-white shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 will-change-transform opacity-100 animate-fadeIn"
          >
            <DatePickerArrow class="fill-white" />
            <DatePickerCalendar v-slot="{ weekDays, grid }" class="p-5">
              <DatePickerHeader class="flex items-center justify-between mb-3">
                <DatePickerPrev
                  class="flex items-center justify-center rounded-md bg-gray-100 p-2 text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
                  <Icon icon="radix-icons:chevron-left" class="w-5 h-5" />
                </DatePickerPrev>

                <DatePickerHeading class="text-lg font-semibold text-gray-900" />

                <DatePickerNext
                  class="flex items-center justify-center rounded-md bg-gray-100 p-2 text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
                  <Icon icon="radix-icons:chevron-right" class="w-5 h-5" />
                </DatePickerNext>
              </DatePickerHeader>

              <div class="flex flex-col space-y-5 sm:flex-row sm:space-x-5 sm:space-y-0">
                <DatePickerGrid
                  v-for="month in grid"
                  :key="month.value.toString()"
                  class="w-full select-none space-y-1 border border-gray-200 rounded-lg p-3"
                >
                  <DatePickerGridHead>
                    <DatePickerGridRow class="mb-2 flex justify-between">
                      <DatePickerHeadCell
                        v-for="day in weekDays"
                        :key="day"
                        class="w-9 rounded-md text-center text-xs font-medium text-gray-500"
                      >
                        {{ day }}
                      </DatePickerHeadCell>
                    </DatePickerGridRow>
                  </DatePickerGridHead>
                  <DatePickerGridBody>
                    <DatePickerGridRow
                      v-for="(weekDates, index) in month.rows"
                      :key="`weekDate-${index}`"
                      class="flex justify-between"
                    >
                      <DatePickerCell
                        v-for="weekDate in weekDates"
                        :key="weekDate.toString()"
                        :date="weekDate"
                      >
                        <DatePickerCellTrigger
                          :day="weekDate"
                          :month="month.value"
                          class="relative flex items-center justify-center w-9 h-9 rounded-md border border-transparent text-sm font-normal text-gray-900 hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 data-selected:bg-blue-600 data-selected:text-white data-outside-view:text-gray-300 data-unavailable:pointer-events-none data-unavailable:text-gray-300 data-unavailable:line-through"
                        />
                      </DatePickerCell>
                    </DatePickerGridRow>
                  </DatePickerGridBody>
                </DatePickerGrid>
              </div>
            </DatePickerCalendar>
          </DatePickerContent>
        </DatePickerRoot>
      </div>

      <div>
        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">ساعت شروع</label>
        <input
          id="start_time"
          type="time"
          v-model="form.start_time"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400"
          placeholder="08:00"
        />
        <div v-if="form.errors.start_time" class="mt-1 text-sm text-red-600">
          {{ form.errors.start_time }}
        </div>
      </div>

      <div>
        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">ساعت پایان</label>
        <input
          id="end_time"
          type="time"
          v-model="form.end_time"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400"
          placeholder="17:00"
        />
        <div v-if="form.errors.end_time" class="mt-1 text-sm text-red-600">
          {{ form.errors.end_time }}
        </div>
      </div>

      <button
        type="submit"
        class="w-full rounded-md bg-blue-600 py-3 text-center text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
      >
        ذخیره تایم‌اسلات
      </button>
    </form>
  </div>
</template>
