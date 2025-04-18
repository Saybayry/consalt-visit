<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import axios from 'axios';
// Стейт для хранения групп
const consultation = ref(null);
const error = ref(null);

// Метод для запроса групп
const getGroup = async () => {
  try {
    const response = await axios.get('/api/consultations/1');
    consultation.value = response.data; // Записываем полученный факт о кошке
  } catch (error) {
    console.error('Ошибка при получении данных:', error);
  }
};
// Запускаем запрос при загрузке страницы
onMounted(() => {
  getGroup();
});

defineProps({
consultationId: {
    type: Array,
    required: true,
  },
});


</script>

<template>
    <Head title="Consalt" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
            Консультация
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div v-if="consultation?.teacher" class="p-6 text-gray-900 dark:text-gray-100">
                        <h1>
                            {{ " " + consultation.teacher.fname + " "+
                            consultation.teacher.mname + " "+
                             consultation.teacher.lname }}
                        </h1>

                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Студент
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Предмет
                                    </th>           
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                v-for="(student, index) in consultation.students" :key="index"
                                >
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ " " + student.fname + " "+
                                                student.mname + " "+
                                                student.lname }}
                                    </th>
                                    <td class="px-6 py-4">
                                        
                                    </td>
                                    <td class="px-6 py-4">

                                    </td>
                                    <td class="px-6 py-4">

                                    </td>
                                    <td>
    
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


                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
