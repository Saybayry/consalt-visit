<script setup>
import { ref } from 'vue';
import StudentTable from '@/Components/group_students/StudentTable.vue';
// Управление состоянием
const activeIndex = ref(null); // Индекс активного элемента

// Метод для переключения
const toggleItem = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};


defineProps({
  groups: {
    type: Array,
    required: true,
  },
});



</script>

<template>
  <div class="container mx-auto lg:px-4 sm:px-8 lg:py-8">
    <h2 class="text-2xl font-semibold leading-tight mb-4">Accordion</h2>

    <div class="shadow-md rounded-lg border border-gray-200">
      <!-- Аккордеон, начинаем итерацию -->
      <div v-for="(group, index) in groups" :key="index" 
      class="border-b last:border-b-0"
      >
        <!-- Заголовок аккордеона -->
        <button
          @click="toggleItem(group)"
          class="w-full flex justify-between items-center px-6 py-4 focus:outline-none"
           :class="index % 2 === 0 ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800'"
        >
          <span class="font-medium">{{ group.name }}</span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 transition-transform duration-300"
            :class="{ 'rotate-180': activeIndex === group }"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Контент аккордеона -->
        <div
          v-if="activeIndex === group"
          class="lg:px-6 sm:px-0 py-4 bg-white text-gray-700"
        >
          <StudentTable v-bind:group="group"/>

        </div>
      </div>
    </div>
  </div>
</template>