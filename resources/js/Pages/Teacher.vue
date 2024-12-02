<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TeacherTable from '@/Components/TeacherTable.vue';


import { onMounted, ref } from 'vue';
import axios from 'axios';
// Стейт для хранения групп
const teachers = ref(null);
const error = ref(null);

// Метод для запроса групп
const getGroup = async () => {
  try {
    const response = await axios.get('/api/teachers');
    teachers.value = response.data; // Записываем полученный факт о кошке
  } catch (error) {
    console.error('Ошибка при получении данных:', error);
  }
};
// Запускаем запрос при загрузке страницы
onMounted(() => {
  getGroup();
});
</script>

<template>
    <Head title="Consalt" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
            Преподаватели
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <TeacherTable :teachers="teachers">
                        </TeacherTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
