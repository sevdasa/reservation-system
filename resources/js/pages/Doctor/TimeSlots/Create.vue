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
  <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-2xl shadow">
    <h1 class="text-xl font-bold mb-4">ثبت تایم‌ جدید</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div class="transition-opacity duration-300">
        <InputLabel for="date" value="مورد نظر" />
        <DatePickerRoot id="date-field" :v-model="form.date" :locale="locale"
          class="mt-6 rounded-xl bg-white p-4 shadow-md" fixed-weeks
          @update:modelValue="value => form.date = value?.toString() || ''">

          <DatePickerField v-slot="{ segments }"
            class="flex select-none bg-white items-center justify-between rounded-lg text-center text-green10 border border-transparent p-1 w-40 data-[invalid]:border-red-500">
            <div class="flex items-center">
              <template v-for="item in segments" :key="item.part">
                <DatePickerInput v-if="item.part === 'literal'" :part="item.part">
                  {{ item.value }}
                </DatePickerInput>
                <DatePickerInput v-else :part="item.part"
                  class="rounded-md p-0.5 focus:outline-none focus:shadow-[0_0_0_2px] focus:shadow-black data-[placeholder]:text-green9 ">
                  {{ item.value }}
                </DatePickerInput>
              </template>
            </div>

            <DatePickerTrigger class="focus:shadow-[0_0_0_2px] rounded-md text-xl p-1 focus:shadow-black">
              <Icon icon="radix-icons:calendar" />
            </DatePickerTrigger>
          </DatePickerField>

          <DatePickerContent :side-offset="4"
            class="rounded-xl bg-white shadow-[0_10px_38px_-10px_hsla(206,22%,7%,.35),0_10px_20px_-15px_hsla(206,22%,7%,.2)] focus:shadow-[0_10px_38px_-10px_hsla(206,22%,7%,.35),0_10px_20px_-15px_hsla(206,22%,7%,.2),0_0_0_2px_theme(colors.green7)] will-change-[transform,opacity] data-[state=open]:data-[side=top]:animate-slideDownAndFade data-[state=open]:data-[side=right]:animate-slideLeftAndFade data-[state=open]:data-[side=bottom]:animate-slideUpAndFade data-[state=open]:data-[side=left]:animate-slideRightAndFade">
            <DatePickerArrow class="fill-white" />
            <DatePickerCalendar v-slot="{ weekDays, grid }" class="p-4">
              <DatePickerHeader class="flex items-center justify-between">
                <DatePickerPrev
                  class="inline-flex items-center cursor-pointer text-black justify-center rounded-[9px] bg-transparent w-8 h-8 hover:bg-black hover:text-white active:scale-98 active:transition-all focus:shadow-[0_0_0_2px] focus:shadow-black">
                  <Icon icon="radix-icons:chevron-left" class="w-6 h-6" />

                </DatePickerPrev>

                <DatePickerHeading class="text-black font-medium" />
                <DatePickerNext
                  class="inline-flex items-center cursor-pointer text-black justify-center rounded-[9px] bg-transparent w-8 h-8 hover:bg-black hover:text-white active:scale-98 active:transition-all focus:shadow-[0_0_0_2px] focus:shadow-black">
                  <Icon icon="radix-icons:chevron-right" class="w-6 h-6" />
                </DatePickerNext>
              </DatePickerHeader>
              <div class="flex flex-col space-y-4 pt-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                <DatePickerGrid v-for="month in grid" :key="month.value.toString()"
                  class="w-full border-collapse select-none space-y-1">
                  <DatePickerGridHead>
                    <DatePickerGridRow class="mb-1 flex w-full justify-between">
                      <DatePickerHeadCell v-for="day in weekDays" :key="day" class="w-8 rounded-md text-xs text-green8">
                        {{ day }}
                      </DatePickerHeadCell>
                    </DatePickerGridRow>
                  </DatePickerGridHead>
                  <DatePickerGridBody>
                    <DatePickerGridRow v-for="(weekDates, index) in month.rows" :key="`weekDate-${index}`"
                      class="flex w-full">
                      <DatePickerCell v-for="weekDate in weekDates" :key="weekDate.toString()" :date="weekDate">
                        <DatePickerCellTrigger :day="weekDate" :month="month.value"
                          class="relative flex items-center justify-center whitespace-nowrap rounded-[9px] border border-transparent bg-transparent text-sm font-normal text-black w-8 h-8 outline-none focus:shadow-[0_0_0_2px] focus:shadow-black hover:border-black data-[selected]:bg-black data-[selected]:font-medium data-[outside-view]:text-black/30 data-[selected]:text-white data-[unavailable]:pointer-events-none data-[unavailable]:text-black/30 data-[unavailable]:line-through before:absolute before:top-[5px] before:hidden before:rounded-full before:w-1 before:h-1 before:bg-white data-[today]:before:block data-[today]:before:bg-green9 data-[selected]:before:bg-white" />
                      </DatePickerCell>
                    </DatePickerGridRow>
                  </DatePickerGridBody>
                </DatePickerGrid>
              </div>
            </DatePickerCalendar>
          </DatePickerContent>
        </DatePickerRoot>
      </div>
      <!-- <div>
        <label class="block text-sm font-medium">تاریخ</label>
        <input type="date" v-model="form.date" class="mt-1 w-full rounded border-gray-300" />
        <div class="text-red-500 text-sm mt-1" v-if="form.errors.date">{{ form.errors.date }}</div>
      </div> -->

      <div>
        <label class="block text-sm font-medium">ساعت شروع</label>
        <input type="time" v-model="form.start_time" class="mt-1 w-full rounded border-gray-300" />
        <div class="text-red-500 text-sm mt-1" v-if="form.errors.start_time">{{ form.errors.start_time }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium">ساعت پایان</label>
        <input type="time" v-model="form.end_time" class="mt-1 w-full rounded border-gray-300" />
        <div class="text-red-500 text-sm mt-1" v-if="form.errors.end_time">{{ form.errors.end_time }}</div>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        ذخیره تایم‌اسلات
      </button>
    </form>
  </div>
</template>
