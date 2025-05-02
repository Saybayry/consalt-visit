<script setup>
import { ref } from 'vue';
import StudentTable from '@/Components/StudentTable.vue';
import ConsultationsStudentList from './ConsultationsStudentList.vue';
// Управление состоянием
const activeIndex = ref(null); // Индекс активного элемента

// Метод для переключения
const toggleItem = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};


defineProps({
  consultations: {
    type: Array,
    required: true,
  },
});

const Class_times = [
  "08:00",
  "09:40",
  "11:20",
  "13:20",
  "15:00",
  "16:40",
  "18:20",
  "20:00"
];

</script>

<template>
  <div class="container mx-auto px-4 sm:px-8 py-8">
    <h2 class="text-2xl font-semibold leading-tight mb-4">Accordion</h2>

    <div class="shadow-md rounded-lg border border-gray-200">
      <!-- Аккордеон, начинаем итерацию -->
      <div v-for="(consultation, index) in consultations" :key="index" class="border-b last:border-b-0">
        <!-- Заголовок аккордеона -->
        <button
        @click="toggleItem(consultation)"
        class="w-full grid grid-cols-4 gap-4 items-start px-6 py-4 bg-gray-100 text-left text-gray-700 hover:bg-gray-200 focus:outline-none"
      >
        <span class="font-medium break-words">{{ consultation.discipline.name }}</span>
        <span class="font-medium break-words">
          {{ consultation.teacher.lname }} {{ consultation.teacher.fname }} {{ consultation.teacher.mname }}
        </span>
        <span class="font-medium break-words">{{ consultation.class_date }}</span> 
        <span class="font-medium flex justify-between items-center break-words">
          <span>{{ Class_times[consultation.class_number] }}</span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 ml-2 transition-transform duration-300 shrink-0"
            :class="{ 'rotate-180': activeIndex === consultation }"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </span>
      </button>
      

        <!-- Контент аккордеона -->
        <div
          v-if="activeIndex === consultation"
          class="px-6 py-4 bg-white text-gray-700"
        >
        <ConsultationsStudentList
        v-bind:consultation="consultation"
        ></ConsultationsStudentList>
          <!-- <StudentTable v-bind:consultation="consultation"/> -->

        </div>
      </div>
    </div>
  </div>
</template>