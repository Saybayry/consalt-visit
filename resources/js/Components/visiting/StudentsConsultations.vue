<script setup>
import { Class_times } from '@/constants/classTimes';

    const props = defineProps({
    consultations: {
        type: Array,
        required: true,
    },
    });

</script>

<template>  
    <div class="p-0">
          <table class="w-full text-xs sm:text-sm text-left sm:px-0 sm:py-0 text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase sm:px-0 sm:py-0 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">Преподаватель</th>
          <th class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">Предмет</th>
          <th class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">Дата/Время</th>
          <th class="lg:px-2 py-2 sm:px-0 sm:py-4"></th>
          <th class="lg:px-2 py-2 sm:px-0 sm:py-4"></th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(consulreg, index) in props.consultations"
          :key="index"
          class=" dark:border-gray-700"
          :class="index % 2 === 0 ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800'"
        >
          <th class="px-2 py-2 sm:px-6 sm:py-4 font-medium text-gray-900 dark:text-white ">
            {{ consulreg.consultation.teacher.fname }} {{ consulreg.consultation.teacher.mname }} {{ consulreg.consultation.teacher.lname }}
          </th>
          <td class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">{{ consulreg.consultation.discipline.name }}</td>
          <td class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">{{ consulreg.consultation.class_date }}
             </br> {{ Class_times[consulreg.consultation.class_number - 1] }}
          </td>
          <td class="lg:px-2 lg:py-2 sm:px-0 sm:py-0 max-w-[50px] sm:max-w-none" >
             </br> {{ consulreg.noute }}
          </td>
          <td class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">
            <span v-if="consulreg.is_present">✅</span>
            <span v-else>❌</span>
          </td>
        </tr>
      </tbody>
    </table>
    </div>

</template>