<script setup>
import { ref, watch, computed } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const filterTeacher = ref('');
const filterDiscipline = ref('');
const filterDate = ref(''); // формат строки "YYYY-MM-DD"

const props = defineProps({
  consultations: {
    type: Array,
    required: true,
  },
  refresh: Function,
});

const showModal = ref(false);
const selectedConsultation = ref(null);
const isEditing = ref(false);
const mode = ref('view');
// Для редактируемых полей
const editedConsultation = ref({
  class_date: '',
  class_number: 1,
  discipline_id: null, // новый параметр
});



const Enroll = async (consultation) => {
  try {
      await axios.post(`/api/visiting`, {
        consultation_id: consultation.id,
        is_present: false,
      });

      await props.refresh(); // обновление таблицы
      console.log('refresh called');

    } catch (error) {
      console.error('Ошибка при обновлении консультации:', error);
    }
};

const Unenroll = async (consultation) =>{
  try {
      await axios.delete(`/api/visiting/${consultation.registration.id}`, {
        consultation_id: consultation.id,
        is_present: false,
      });

      await props.refresh(); // обновление таблицы
      console.log('refresh called');

    } catch (error) {
      console.error('Ошибка при обновлении консультации:', error);
    }
}



const openModal = (consultation) => {
  selectedConsultation.value = consultation;

  editedConsultation.value = {
    class_date: consultation.class_date,
    class_number: consultation.class_number,
    discipline_id: consultation.discipline.id,
  };
  showModal.value = true;
  isEditing.value = false;
  mode.value = 'view';
};

const teacherList = ref([]);

const loadTeachers = async () => {
  try {
    const response = await axios.get('/api/teachers');
    teacherList.value = response.data;
  } catch (error) {
    console.error('Ошибка при загрузке списка преподавателей:', error);
  }
};


const selectTeacher = (teacherId) => {

  const selectedTeacher = teacherList.value.find(teacher => teacher.id === teacherId);
  if (selectedTeacher) {

    // Заменяем весь объект преподавателя
    // selectedConsultation.value.teacher = selectedTeacher;
    Object.assign(selectedConsultation.value.teacher, selectedTeacher);
    editedConsultation.value.teacher_id = selectedTeacher.id;
    // Очищаем дисциплину в случае изменения преподавателя
    editedConsultation.value.discipline_id = null;

    // Если у нового преподавателя есть дисциплины, выбираем первую, иначе сбрасываем дисциплину
    if (selectedTeacher.disciplines.length > 0) {
      editedConsultation.value.discipline_id = selectedTeacher.disciplines[0]?.id || null;
    } else {
      editedConsultation.value.discipline_id = null; // Если у преподавателя нет дисциплин
    }
  }
};




const openCreateModal = async () =>  {
  // Очищаем выбранную консультацию — это новая
  if  (page.props.auth.user.is_admin){

    await loadTeachers(); // Загрузка списка преподавателей
    selectedConsultation.value = {
    teacher: null,  // Инициализация пустым значением
    discipline_id: null,
  };
    // запрасить список учителей и вывести его в 
    selectedConsultation.value = {
    teacher: {
      id :0,
      fname:  '',
      mname:  '' ,
      lname:  '',
      disciplines: [],
    },
    groups: [],
    };

  // Подготовка новой "пустой" консультации
  editedConsultation.value = {
    class_date: "",
    class_number: 1, // лучше сразу число от 1 до 8
    discipline_id: null,
    group_ids: [], // если ты используешь выбор групп
    teacher_id:selectedConsultation.value.teacher.id,
  };
  }
  else if (page.props.auth.user.is_teacher) {
  selectedConsultation.value = {
    teacher: {
      id:page.props.auth.user.teacher.id,
      fname: page.props.auth.user.teacher.fname,
      mname: page.props.auth.user.teacher.mname,
      lname: page.props.auth.user.teacher.lname,
      disciplines: page.props.auth.user.teacher.disciplines,
    },
    groups: [],

    };
      // Подготовка новой "пустой" консультации
  editedConsultation.value = {
    class_date: "",
    class_number: 1, // лучше сразу число от 1 до 8
    discipline_id: null,
    group_ids: [], // если ты используешь выбор групп
    teacher_id:page.props.auth.user.teacher.id,
  };
  }
  else{

  }

  mode.value = 'create';
  showModal.value = true;
  isEditing.value = true;
  
};

const createConsultation = async () => {
  try {
    // Создание новой консультации
    await axios.post('/api/consultations', {
      teacher_id :editedConsultation.value.teacher_id,
      class_date: editedConsultation.value.class_date,
      class_number: editedConsultation.value.class_number,
      discipline_id: editedConsultation.value.discipline_id,
      group_ids: [1,2],
    });

    await props.refresh(); // обновление таблицы
    // console.log('refresh called');

    closeModal(); // закрытие модального окна
  } catch (error) {
    console.error('Ошибка при создании консультации:', error);
  }
};



const closeModal = () => {
  console.log("Функция closeModal вызвана"); 
  showModal.value = false;
  selectedConsultation.value = null;
  isEditing.value = false;
  mode.value = 'view';
};

const startEditing = () => {
    console.log("Функция startEditing вызвана"); 
  isEditing.value = true;
  mode.value = 'edit';

};

const saveChanges = async () => {
  try {
    await axios.put(`/api/consultations/${selectedConsultation.value.id}`, {
      class_date: editedConsultation.value.class_date,
      class_number: editedConsultation.value.class_number,
      discipline_id: editedConsultation.value.discipline_id,
      group_ids: editedConsultation.value.group_ids, 
    });

    await props.refresh(); // обновление таблицы
    console.log('refresh called');

    closeModal(); // закрытие модального окна
  } catch (error) {
    console.error('Ошибка при обновлении консультации:', error);
  }
};

const deleteConsultation = async () => {
  if (confirm('Удалить консультацию?')) {
    try {
      await axios.delete(`/api/consultations/${selectedConsultation.value.id}`);
      await props.refresh();
      console.log('refresh called');

      closeModal();
    } catch (error) {
      console.error('Ошибка при удалении консультации:', error);
    }
  }
};



const Class_times = [
  "08:00",
  "09:40",
  "11:20",
  "13:20",
  "15:00",
  "16:40",
  "18:20",
  "20:00"
];


// фильтрация
const filteredConsultations = computed(() => {
  return props.consultations.filter(c => {
    const matchesTeacher = filterTeacher.value
      ? (c.teacher.fname + ' ' + c.teacher.mname + ' ' + c.teacher.lname)
          .toLowerCase()
          .includes(filterTeacher.value.toLowerCase())
      : true;

    const matchesDiscipline = filterDiscipline.value
      ? c.discipline.name.toLowerCase().includes(filterDiscipline.value.toLowerCase())
      : true;

    const matchesDate = filterDate.value
      ? c.class_date === filterDate.value
      : true;

    return matchesTeacher && matchesDiscipline && matchesDate;
  });
});
</script>


<template>
  <div>
  <div class="py-8" v-if="page.props.auth.user.is_admin||page.props.auth.user.is_teacher"  >
    <button
    @click="openCreateModal()"
    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
  >
    Создать
  </button>
<!-- {{ page.props.auth.user }} -->
  </div>
<div class="mb-4 flex flex-col gap-2 sm:flex-row sm:gap-2">
  <input
    type="text"
    v-model="filterTeacher"
    placeholder="Фильтр по преподавателю"
    class="border rounded px-2 py-1"
  />
  <input
    type="text"
    v-model="filterDiscipline"
    placeholder="Фильтр по предмету"
    class="border rounded px-2 py-1"
  />
  <input
    type="date"
    v-model="filterDate"
    placeholder="Фильтр по дате"
    class="border rounded px-2 py-1"
  />
</div>


  <table class="w-full text-xs sm:text-sm text-left sm:px-0 sm:py-0 text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase sm:px-0 sm:py-0 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">Преподаватель</th>
          <th class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">Предмет</th>
          <th class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">Дата/Время</th>

          <th class="px-2 py-2 sm:px-6 sm:py-4"></th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(consultation, index) in filteredConsultations"
          :key="index"
          class=" dark:border-gray-700"
          :class="index % 2 === 0 ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800'"
        >
          <th class="px-2 py-2 sm:px-6 sm:py-4 font-medium text-gray-900 dark:text-white ">
            {{ consultation.teacher.fname }} {{ consultation.teacher.mname }} {{ consultation.teacher.lname }}
          </th>
          <td class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">{{ consultation.discipline.name }}</td>
          <td class="lg:px-2 lg:py-2 sm:px-0 sm:py-0">{{ consultation.class_date }} </br> {{ Class_times[consultation.class_number - 1] }}</td>

          <td 
          v-if="page.props.auth.user.is_admin||page.props.auth.user.is_teacher" 
          class="lg:px-6 lg:py-4  sm:py-0  sm:px-0 align-middle">
            <button
              @click="openModal(consultation)"
              class="bg-blue-500 hover:bg-blue-600 text-white lg:px-6 py-4 rounded"
            >
              Подробнее
            </button>
          </td>
          <td 
          v-if="!page.props.auth.user.is_admin && !page.props.auth.user.is_teacher" 
          class="lg:px-6 lg:py-4  sm:py-0  sm:px-0 align-middle">
            <button v-if="!consultation.registration"
              @click="Enroll(consultation)"
              class="bg-blue-500 hover:bg-blue-600 text-white lg:px-6 py-4 rounded"
            >
              Записатся
            </button>
            <button v-if="consultation.registration"
            @click="Unenroll(consultation)"
            class="bg-red-500 hover:bg-red-600 text-white lg:px-6 py-4 rounded"
          >
            отписатся
          </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Модальное окно -->
    <div
      v-if="showModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div class="bg-white dark:bg-gray-900 p-6 rounded shadow-xl w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4 dark:text-white">Детали консультации</h2>

        <div class="space-y-3">
          <!-- -----для учителя--------- -->
          <div     v-if="page.props.auth.user.is_teacher && !page.props.auth.user.is_admin" class="text-gray-800 dark:text-gray-300">
            <strong>Преподаватель:</strong>
            {{ selectedConsultation.teacher.fname }} {{ selectedConsultation.teacher.mname }} {{ selectedConsultation.teacher.lname }}
          </div>
          <!-- для админа  -->
          <div v-if="page.props.auth.user.is_admin" class="text-gray-800 dark:text-gray-300">
            <label class="text-gray-800 dark:text-gray-300"><strong>Преподаватель:</strong></label><br />

            <select v-model="selectedConsultation.teacher.id " 
            @change="selectTeacher(selectedConsultation.teacher.id)"
            :disabled="!isEditing"
             class="mt-1 w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white"
             >
              <option v-for="teacher in teacherList" :key="teacher.id" :value="teacher.id">
                {{ teacher.fname }} {{ teacher.mname }} {{ teacher.lname }} 
              </option>
            </select>
          </div>

          
          <!-- -------------------------------- -->
          <div>
            <label class="text-gray-800 dark:text-gray-300"><strong>Предмет:</strong></label><br />
     
            <select
              v-model="editedConsultation.discipline_id"
              :disabled="!isEditing"
              class="mt-1 w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white"
            >
              <option
                v-for="(d, i) in selectedConsultation.teacher.disciplines"
                :key="i"
                :value="d.id"
              >
                {{ d.name }}
              </option>
            </select>
          </div>

          <div>
            <label class="text-gray-800 dark:text-gray-300"><strong>Дата:</strong></label><br />
            <input
              v-model="editedConsultation.class_date"
              :disabled="!isEditing"
              type="date"
              class="mt-1 w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white"
            />
          </div>

          <div>
            <label class="text-gray-800 dark:text-gray-300"><strong>Номер пары:</strong></label><br />
            <select
              v-model="editedConsultation.class_number"
              :disabled="!isEditing"
              class="mt-1 w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white"
            >
              <option v-for="(time, index) in Class_times" :key="index" :value="index + 1">
                {{ index + 1 }} пара — {{ time }}
              </option>
            </select>
          </div>

          <div class="text-gray-800 dark:text-gray-300">
            <strong>Группы:</strong>
            <span
              v-for="(group, i) in selectedConsultation.groups"
              :key="i"
              class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm mx-1"
            >
              {{ group.name }}
            </span>
          </div>
        </div>

        <div class="flex justify-end mt-6 space-x-2">
         <!-- Панель просмотра -->
        <div v-if="mode === 'view'" class="flex justify-end mt-6 space-x-2">
          <button
            @click="startEditing"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded"
          >
            Редактировать
          </button>

          <button
            @click="deleteConsultation"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
          >
            Удалить
          </button>

          <button
            @click="closeModal"
            class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded"
          >
            Закрыть
          </button>
        </div>

      <!-- Панель редактирования -->
      <div v-if="mode === 'edit'" class="flex justify-end mt-6 space-x-2">
        <button
          @click="saveChanges"
          class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
        >
          Сохранить изменения
        </button>

        <button
          @click="deleteConsultation"
          class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
        >
          Удалить
        </button>

        <button
          @click="closeModal"
          class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded"
        >
          Закрыть
        </button>
      </div>

      <!-- Панель создания -->
      <div v-if="mode === 'create'" class="flex justify-end mt-6 space-x-2">
        <button
          @click="createConsultation"
          class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
        >
          Создать
        </button>

        <button
          @click="closeModal"
          class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded"
        >
          Закрыть
        </button>
      </div>
        </div>
      </div>
    </div>
  </div>
</template>
