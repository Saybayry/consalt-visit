<script setup>
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
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Преподаватель
                </th>
                <th scope="col" class="px-6 py-3">
                    Предмет
                </th>
                <th scope="col" class="px-6 py-3">
                    Дата
                </th>
                <th scope="col" class="px-6 py-3">
                    Время
                </th>
                <th scope="col" class="px-6 py-3">
                    Группы
                </th>
                <th scope="col" class="px-6 py-3">
                    
                </th>
                
                
            </tr>
        </thead>
        <tbody>
            <tr 
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            v-for="(consultation, index) in consultations" :key="index"
            >
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ " " + consultation.teacher.fname + " "+
                         consultation.teacher.mname + " "+
                          consultation.teacher.lname }}
                </th>
                <td class="px-6 py-4">
                    {{ consultation.discipline.name }}
                </td>
                <td class="px-6 py-4">
                    {{consultation.class_date}}
                </td>
                <td class="px-6 py-4">
                    {{ Class_times[consultation.class_number-1] }}
                </td>
                <td>
                    <span
                    v-for="(group, index) in consultation.groups" :key="index"
                    class="mx-1 my-1 relative inline-block px-3 py-1 font-semibold text-blue-900 leading-tight"
                    >
                      <span
                        aria-hidden
                        class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"
                      >
                      </span>
                      <span class="relative">
                        {{group.name}}
                    </span>
                  </span>
                </td>
                <td class="px-6 py-4">
                    <button
                      type="button"
                      class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded"
                    >
                    Подробнее
                    </button>
  
  

                </td>
            </tr>
           
        </tbody>
    </table>
</template>
