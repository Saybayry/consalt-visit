<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
const consultations_with_registrations = ref(null);
const error = ref(null);



const { consultation } = defineProps({
  consultation: {
    type: Object,
    required: true,
  },
});

const getStudent = async () => {
  try {
    const response = await axios.get(`/api/visitings/${consultation.id}`);
    consultations_with_registrations.value = response.data;
    console.log(consultations_with_registrations.value);
  } catch (error) {
    console.error('Ошибка при получении данных:', error);
  }
};

const refreshData = () => {
  getStudent(); // повторно вызываем getStudent для обновления данных
};


const notice = async (visiting) => {
  try {
    // Отправляем только is_present, так как другие поля не требуются
    await axios.put(`/api/visiting/${visiting.id}`, {
      is_present: true, // или !visiting.is_present, если нужно переключать состояние
    });

    await refreshData(); // Обновляем данные после успешного запроса
    console.log('Статус посещения обновлен');

  } catch (error) {
    console.error('Ошибка при обновлении:', error);
    // Можно добавить уведомление пользователю (например, через toast)
  }
};

const Unnotice = async (visiting) => {
  try {
    // Отправляем только is_present, так как другие поля не требуются
    await axios.put(`/api/visiting/${visiting.id}`, {
      is_present: false, // или !visiting.is_present, если нужно переключать состояние
    });

    await refreshData(); // Обновляем данные после успешного запроса
    console.log('Статус посещения обновлен');

  } catch (error) {
    console.error('Ошибка при обновлении:', error);
    // Можно добавить уведомление пользователю (например, через toast)
  }
};


onMounted(() => {
  getStudent();
});
</script>

<template>      

  <div  class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
      <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
        <div
          class="inline-block min-w-full shadow-md rounded-lg overflow-hidden"
        >
          <table class="min-w-full leading-normal">
            <thead>
              <tr>
                <th
                  class="px-2 py-2 sm:px-5 sm:py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Фамилия
                </th>
                <th
                  class="px-2 py-2 sm:px-5 sm:py-3  border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Имя
                </th>
                <th
                  class="px-2 py-2 sm:px-5 sm:py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                >
                  Отчество
                </th>
                <th
                class="px-2 py-2 sm:px-5 sm:py-3  border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
              >
                группа
              </th>
              <th
              class="px-2 py-2 sm:px-5 sm:py-3  border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
            >
              посещение
            </th>
              </tr>
            </thead>
            <tbody  v-if="consultations_with_registrations?.registrations">

<!-- {{ consultations_with_registrations }} -->

              <tr v-for="(consreg, index) in consultations_with_registrations.registrations" :key="index" >
                <!-- {{ consreg.student.lname}} -->
                <td class="px-2 py-2 sm:px-5 sm:py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">{{consreg.student.lname }}</p>
                </td>
                <td class="px-2 py-2 sm:px-5 sm:py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">{{consreg.student.fname }}</p>
                </td>
                <td class="px-2 py-2 sm:px-5 sm:py-5 border-b border-gray-200 bg-white text-sm">
                  <p 
                    class="text-gray-900 whitespace-no-wrap">
                    {{consreg.student.mname }}
                  </p>
                </td>
                <td class="ppx-2 py-2 sm:px-5 sm:py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">{{consreg.student.group.name }}</p>
                </td>
                <td>
                  <button v-if="consreg.is_present"
                  @click="Unnotice(consreg)"
                  class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                >
                пришел
                </button>
                <button v-if="!consreg.is_present"
                @click="notice(consreg)"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
              >
              не пришел
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