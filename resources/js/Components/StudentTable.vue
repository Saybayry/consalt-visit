<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
const students = ref(null);
const error = ref(null);



const { group } = defineProps({
  group: {
    type: Object,
    required: true,
  },
});

const getStudent = async () => {
  try {
    const response = await axios.get(`/api/groups/${group.id}`);
    students.value = response.data.students;
    console.log(students.value);
  } catch (error) {
    console.error('Ошибка при получении данных:', error);
  }
};
const account = ref({
  address: '5GrwvaEF5zXb26Fz9rcQpDWS57CtERHpNehXCPcNoHGKutQY', // Пример адреса Polkadot
  publicKey: 'your-public-key',
});

onMounted(() => {
  getStudent();
});
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
      <div>
        <h2 class="text-2xl font-semibold leading-tight">Invoices</h2>
      </div>
      <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
        <div
          class="inline-block min-w-full shadow-md rounded-lg overflow-hidden"
        >
          <table class="min-w-full leading-normal">
            <thead>
              <tr>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Студент
                </th>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Фамилия
                </th>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Имя
                </th>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Отчество
                </th>
                <th
                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"
                ></th>
              </tr>
            </thead>
            <tbody>


              <tr v-for="(student, index) in students" :key="index" >
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex">
                    <div class="flex-shrink-0 w-10 h-10">

                      <img
                        class="w-full h-full rounded-full"
                        src="https://static.tildacdn.com/tild6563-6633-4239-a535-313432396266/student.png"
                        alt=""
                      />
                      
                    </div>
                    <div class="ml-3">
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">{{student.lname }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">{{student.fname }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">{{student.mname }}</p>
                </td>
                <td
                  class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right"
                >


                
                  <button
                    type="button"
                    class="inline-block text-gray-500 hover:text-gray-700"
                  >
                    <svg
                      class="inline-block h-6 w-6 fill-current"
                      viewBox="0 0 24 24"
                    >
                      <path
                        d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-2 6a2 2 0 104 0 2 2 0 00-4 0z"
                      />
                    </svg>
                  </button>



                </td>
              </tr>



            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</template>