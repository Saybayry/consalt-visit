<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TableConsalt from '@/Components/all_consalt/TableConsalt.vue';

import { onMounted, ref } from 'vue';
import axios from 'axios';

const consultations = ref([]); // Лучше инициализировать как пустой массив вместо null
const error = ref(null);

// Метод для запроса консультаций
const getConsultations = async () => {
  try {
    const response = await axios.get('/api/consultations');
    consultations.value = response.data;
  } catch (err) {
    console.error('Ошибка при получении данных:', err);
    error.value = err.message;
  }
};

// Запускаем запрос при загрузке страницы
onMounted(() => {
  getConsultations();
});
</script>

<template>
    <Head title="Consalt" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Консультации
            </h2>
        </template>

        <div class="py-12 sm:py-0">
            <div class="mx-auto max-w-7xl sm:py-0 lg:px-0">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="lg:px-6 text-gray-900 dark:text-gray-100 sm:p-0">
                        <!-- Передаем функцию обновления в компонент -->
                        <TableConsalt 
                            :consultations="consultations" 
                            :refresh="getConsultations" 
                        />
                        
                        <!-- Показываем ошибку, если есть -->
                        <div v-if="error" class="mt-4 text-red-500">
                            Ошибка загрузки данных: {{ error }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>