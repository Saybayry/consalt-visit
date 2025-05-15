<script setup>

defineProps({
  teachers: {
    type: Array,
    required: true,
  },
  auth: Object,
});
</script>

<template>
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">

          <div class="-mx-4 sm:-mx-8 lg:px-4 sm:px-8 py-4 overflow-x-auto">
            <div
              class="inline-block min-w-full shadow-md rounded-lg overflow-hidden"
            >
              <table class="w-full text-xs sm:text-sm text-left sm:px-0 sm:py-0 text-gray-500 dark:text-gray-400">
                <thead>
                  <tr>
                    <th class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">ФИО,email </th>

                    <th class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">Предметы</th>
                  </tr>
                </thead>
                <tbody>


                  <tr v-for="(teacher, index) in teachers" :key="index" 
                  class="p-0"
                  :class="index % 2 === 0 ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800'">

                    <td class="px-2 py-2 sm:px-6 sm:py-4 font-medium text-gray-900 dark:text-white text-sm ">
                      <p class=" whitespace-no-wrap">
                      <span class="block ">
                        {{ teacher.fname }} {{ teacher.mname }} {{ teacher.lname }}
                      </span>
                      <span class="block0 text-xs break-all text-gray-900 dark:text-white">
                        {{ teacher.user.email }}
                      </span>
                      </p>
                    
                    </td>
                    <td class="px-2 py-2 sm:px-6 sm:py-4 font-medium text-gray-900 dark:text-white  text-sm">
                      <span
                        v-for="(discipline, index) in teacher.disciplines" :key="index"
                        class="relative inline-block px-3 py-5 font-semibold leading-tight"
                        >
                          <span
                            aria-hidden
                            class="absolute inset-0"
                            :class="index % 2 === 0 ? 'bg-blue-200  dark:bg-blue-600 ' : 'bg-green-200 dark:bg-green-600'"
                            style="opacity: 0.5; border-radius: 0.5rem; padding: 0.25rem;"
                          ></span>
                          <span class="relative">
                            {{discipline.name}}
                        </span>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    
</template>
