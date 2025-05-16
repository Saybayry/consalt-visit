<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

import MyConsultationTable from '@/Components/visiting//MyConsultationTable.vue';
import StudentsConsultations from '@/Components/visiting/StudentsConsultations.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
// import ConsultationsStudentList from '@/Components/ConsultationsStudentList.vue';
// import MyConsultationTable from '@/'
const consultations = ref([]); // Лучше инициализировать как пустой массив вместо null
const error = ref(null);

// Метод для запроса консультаций
const getConsultations = async () => {
  try {
    const response = await axios.get('/api/consultationswithregistration');
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
                Мои Консультации
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="lg:py-6 sm:py-0 text-gray-900 dark:text-gray-100">
                        <MyConsultationTable
                        v-if="page.props.auth.user.is_admin||page.props.auth.user.is_teacher" 
                        :consultations="consultations" 
                        :refresh="getConsultations" >
                        </MyConsultationTable>
                        
                        <StudentsConsultations  
                        v-else 
                        :consultations="consultations" 
                        :refresh="getConsultations"
                        >

                        </StudentsConsultations>
                        <!-- Передаем функцию обновления в компонент -->
                        <!-- <TableConsaltStudent 
                            :consultations="consultations" 
                            :refresh="getConsultations" 
                        /> -->
                        <!-- <div v-for="(consultation, index) in consultations"
                        :key="index">
                        <ConsultationsStudentList
                        :consultation="consultation" 
                        :refresh="getConsultations" 
                         >
                        </ConsultationsStudentList>

                        </div> -->

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