<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const startDate = ref('');
const endDate = ref('');

const getExel = async () => {
  try {
    const response = await axios.get('/api/export', {
      params: {
        start_date: startDate.value,
        end_date: endDate.value,
      },
      responseType: 'blob', // очень важно для бинарных данных
    });

    // Создаем ссылку для скачивания файла
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'consultation_report.xlsx'); // имя скачиваемого файла
    document.body.appendChild(link);
    link.click();

    // Очистка
    link.remove();
    window.URL.revokeObjectURL(url);
  } catch (error) {
    console.error('Ошибка при выгрузке отчета:', error);
  }
};

</script>

<template>
    <Head title="Consalt" />
    <AuthenticatedLayout>
      
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
            Отчет
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col md:flex-row justify-end">
                      <input
                        type="date"
                        v-model="startDate"
                        placeholder="Дата с"
                        class="m-3 full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full md:w-auto ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                      />
                      <input
                        type="date"
                        v-model="endDate"
                        placeholder="Дата по"
                        class="m-3 full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full md:w-auto ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                      />
                      <button
                        @click="getExel"
                        class="m-3 md:w-auto sm:full  w-full md:w-auto ps-10 p-2.5  text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center"


                        >
                        Сформировать отчет
                      </button>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
