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
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <input
                          type="date"
                          v-model="startDate"
                          placeholder="Дата с"
                          class="border rounded px-2 py-1"
                        />
                        <input
                          type="date"
                          v-model="endDate"
                          placeholder="Дата по"
                          class="border rounded px-2 py-1"
                        />
                        <button
                        @click="getExel"
                        class="bg-blue-500 hover:bg-blue-800 px-4 py-2 rounded"
                      >
                        Сформировать отчет
                      </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
