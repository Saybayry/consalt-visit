<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import StudentGroupTable from '@/Components/StudentGroupTable.vue';
// Правильный способ - один default export в модуле
// Переменная для хранения групп
import { onMounted, ref } from 'vue';
import axios from 'axios';
// Стейт для хранения групп
const groups = ref(null);
const error = ref(null);

// Метод для запроса факта о кошке
const getGroup = async () => {
  try {
    const response = await axios.get('/api/groups');
    groups.value = response.data; // Записываем полученный факт о кошке
    console.log(groups.value);
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
            Группы

            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <StudentGroupTable :groups="groups"  />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
