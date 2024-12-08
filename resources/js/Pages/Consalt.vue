<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TableConsalt from '@/Components/TableConsalt.vue';

import { onMounted, ref } from 'vue';
import axios from 'axios';
// Стейт для хранения групп
const consultations = ref(null);
const error = ref(null);

// Метод для запроса групп
const getconsultations = async () => {
  try {
    const response = await axios.get('/api/consultations');
    consultations.value = response.data; // Записываем полученный факт о кошке
  } catch (error) {
    console.error('Ошибка при получении данных:', error);
  }
};
// Запускаем запрос при загрузке страницы
onMounted(() => {
    getconsultations();
});


</script>

<template>
    <Head title="Consalt" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
            Консультации
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <TableConsalt :consultations="consultations"  />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
