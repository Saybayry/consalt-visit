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


const updateNote = async (visiting) => {
  try {
    await axios.put(`/api/visiting/${visiting.id}`, {
      noute: visiting.noute,
      is_present: visiting.is_present, // можно оставить текущее значение
    });
    console.log('Заметка обновлена');
  } catch (error) {
    console.error('Ошибка при обновлении заметки:', error);
  }
};


const notice = async (visiting) => {
  try {
    // Отправляем только is_present, так как другие поля не требуются
    await axios.put(`/api/visiting/${visiting.id}`, {
      is_present: true, // или !visiting.is_present, если нужно переключать состояние
      noute: visiting.noute,
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
      noute: visiting.noute,
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

  <div  class="container mx-auto px-4 sm:px-0">
    <div class="lg:py-8 md:py-0">
      <div class="-mx-0 sm:-mx-0 lg:px-4 sm:px-0 py-0 overflow-x-auto">
        <div
          class="inline-block min-w-full shadow-md rounded-lg overflow-hidden"
        >
          <table class="min-w-full leading-normal">
            <thead>
              <tr>
                <th
                  class="lg:px-2 py-2 sm:px-0 sm:py-0 border-b-2
                   border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider
                    dark:text-gray-400  dark:bg-gray-700 
                   "
                >
                  Фамилия
                  Имя
                  Отчество
                </th>

                <th
                class="px-2 py-2 sm:px-0 sm:py-3  border-b-2
                 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider
                  dark:text-gray-400  dark:bg-gray-700 "
              >
                группа
              </th>
              <th
              class="px-2 py-2 sm:px-0 sm:py-3  border-b-2
               border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider
                dark:text-gray-400  dark:bg-gray-700 "
            >
              посещение
            </th>
              </tr>
            </thead>
            <tbody  v-if="consultations_with_registrations?.registrations">

<!-- {{ consultations_with_registrations }} -->
  <template v-for="(consreg, index) in consultations_with_registrations.registrations" :key="index">
              <tr  :class="index % 2 === 0 ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800'">
                <!-- {{ consreg.student.lname}} -->
                <td 
                class="lg:px-2 lg:py-2 sm:px-0 sm:py-0 border-balign-middle">
                  <p class="text-gray-900 whitespace-no-wrap dark:text-white">
                    {{consreg.student.lname }}
                  </br>
                  {{consreg.student.fname }}
                </br>
                  {{consreg.student.mname }}
                  </br>

                  </p>
                </td>

                <td class="lg:px-2 lg:py-2 sm:px-0 sm:py-5 border-b text-sm 
                
                 
                 align-middle">
                  <p class="text-gray-900 dark:text-white whitespace-no-wrap">{{consreg.student.group.name }}</p>
                </td>
                <td  
                class="lg:px-2 lg:py-2 sm:px-0 sm:py-5 border-b  text-sm 
                dark:text-gray-400  dark:bg-gray-700 
                align-middle">
                  <button v-if="consreg.is_present"
                  @click="Unnotice(consreg)"
                  class="w-full h-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                >
                пришел
                </button>
                <button v-if="!consreg.is_present"
                @click="notice(consreg)"
                class="w-full h-full text-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
              >
              не пришел
              </button>
                </td>
              </tr >
              <tr class="border-b-4 border-gray-300"
              :class="index % 2 === 0 ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800'">
                  <td colspan="2" class="align-middle">
                    <div class="space-y-2">
                      <textarea
                        v-model="consreg.noute"
                        class="w-full rounded-600 px-2 py-1 text-sm"
                        :class="index % 2 === 0 ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800'"
                        placeholder="Введите заметку..."
                        rows="2"
                        maxlength="300" 
                      ></textarea>
                    </div>
                  </td>
                <td  
                class="lg:px-2 lg:py-2 sm:px-0 sm:py-5 border-b text-sm align-middle">
                  <button
                    @click="updateNote(consreg)"
                      class="w-full h-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                    >
                    cохранить
                  </button>
                </td>
              </tr>
              <tr>
                <td class="space-y-2 align-middle">

                </td>
              </tr>
   </template>
   

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</template>