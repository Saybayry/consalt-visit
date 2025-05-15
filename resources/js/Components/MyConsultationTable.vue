<script setup>
import { ref , computed} from 'vue';
import StudentTable from '@/Components/StudentTable.vue';
import ConsultationsStudentList from './ConsultationsStudentList.vue';
import { usePage } from '@inertiajs/vue3';
// Управление состоянием
const activeIndex = ref(null); // Индекс активного элемента
const searchQuery = ref(''); // строка фильтрации

const filterTeacher = ref('');
const filterDiscipline = ref('');
const filterDate = ref(''); // формат строки "YYYY-MM-DD"
const page = usePage();
// Метод для переключения
const toggleItem = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};


const props = defineProps({
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
const filteredConsultations = computed(() => {
  return props.consultations.filter(c => {
    const matchesTeacher = filterTeacher.value
      ? (c.teacher.fname + ' ' + c.teacher.mname + ' ' + c.teacher.lname)
          .toLowerCase()
          .includes(filterTeacher.value.toLowerCase())
      : true;

    const matchesDiscipline = filterDiscipline.value
      ? c.discipline.name.toLowerCase().includes(filterDiscipline.value.toLowerCase())
      : true;

    const matchesDate = filterDate.value
      ? c.class_date === filterDate.value
      : true;

    return matchesTeacher && matchesDiscipline && matchesDate;
  });
});

</script>

<template>
  <div class="container mx-auto lg:px-4 sm:px-0 py-0 ">

    <div class="shadow-md  border-gray-200">
          <!-- Поле поиска -->
  <div class="py-8" v-if="page.props.auth.user.is_admin||page.props.auth.user.is_teacher"  >

<!-- {{ page.props.auth.user }} -->
  </div>
<div class="mb-4 flex flex-col gap-2 sm:flex-row sm:gap-2">
  <input
    type="text"
    v-model="filterTeacher"
    placeholder="Фильтр по преподавателю"
    class="border rounded px-2 py-1"
  />
  <input
    type="text"
    v-model="filterDiscipline"
    placeholder="Фильтр по предмету"
    class="border rounded px-2 py-1"
  />
  <input
    type="date"
    v-model="filterDate"
    placeholder="Фильтр по дате"
    class="border rounded px-2 py-1"
  />
</div>

    
      <!-- Аккордеон, начинаем итерацию -->
      <div v-for="(consultation, index) in filteredConsultations" :key="index" class="border-b last:border-b-0">
        <!-- Заголовок аккордеона -->
        <button
        @click="toggleItem(consultation)"
        class="w-full grid grid-cols-7 lg:gap-4 sm:gap-0 items-start lg:px-6 lg:py-4 sm:px-0
         bg-gray-100 text-left text-gray-700 hover:bg-gray-200 focus:outline-none
         dark:text-gray-400  dark:bg-gray-700 dark:hover:bg-gray-800 dark:focus:outline-none
   
         "
      >
        <span 
          class="
          font-medium break-words lg:px-4 sm:px-0 
          col-span-4 ">
          {{ consultation.discipline.name }}
        </span>

        <span class="font-medium break-words lg:px-4 sm:px-0 flex-1 col-span-2" col-span-1>
          {{ consultation.teacher.lname }}</br> {{ consultation.teacher.fname }}</br> {{ consultation.teacher.mname }}
        </span>
        <span class="font-medium break-words lg:px-4 sm:px-0 col-span-1" col-span-1>{{ consultation.class_date }} </br> {{ Class_times[consultation.class_number] }}</span> 
        <span class="font-medium flex justify-between items-center break-words lg:px-4 sm:px-0 sm:py-0 col-span-1">
          <!-- <span>{{ Class_times[consultation.class_number] }}</span> -->
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
          class="lg:px-6 lg:py-4 md:px-0 md:py-0 bg-white text-gray-700   dark:text-gray-400  dark:bg-gray-700"
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