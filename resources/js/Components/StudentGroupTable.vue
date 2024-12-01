<script setup>
import { ref } from 'vue';
import StudentTable from '@/Components/StudentTable.vue';
// Управление состоянием
const activeIndex = ref(null); // Индекс активного элемента
const items = ref([
  {
    title: '205s11-5',
    content: 'Details for Invoice 1: Amount $20,000, Issued on Sept 28, 2019, Due in 3 days.',
  },
  {
    title: '205s11-4',
    content: 'Details for Invoice 2: Amount $214,000, Issued on Sept 25, 2019, Due in 6 days.',
  },
  {
    title: '205s11-3',
    content: 'Details for Invoice 3: Amount $10,000, Issued on Oct 5, 2019, Due in 2 weeks.',
  },
]);

// Метод для переключения
const toggleItem = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8 py-8">
    <h2 class="text-2xl font-semibold leading-tight mb-4">Accordion</h2>

    <div class="shadow-md rounded-lg border border-gray-200">
      <!-- Аккордеон, начинаем итерацию -->
      <div v-for="(item, index) in items" :key="index" class="border-b last:border-b-0">
        <!-- Заголовок аккордеона -->
        <button
          @click="toggleItem(index)"
          class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 text-left text-gray-700 hover:bg-gray-200 focus:outline-none"
        >
          <span class="font-medium">{{ item.title }}</span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 transition-transform duration-300"
            :class="{ 'rotate-180': activeIndex === index }"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Контент аккордеона -->
        <div
          v-if="activeIndex === index"
          class="px-6 py-4 bg-white text-gray-700"
        >
          <StudentTable></StudentTable>


        </div>
      </div>
    </div>
  </div>
</template>