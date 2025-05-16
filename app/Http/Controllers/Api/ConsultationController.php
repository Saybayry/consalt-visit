<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->is_admin || $user->is_teacher) {
        $consultations = Consultation::with('teacher.disciplines', 'discipline', 'groups')
            ->orderBy('class_date')
            ->orderBy('class_number')
            ->get();
        }else{
            $student = $user->student;
            if (!$student) {
                return response()->json(['error' => 'Студент не найден для пользователя.'], 403);
            }
            $consultations = Consultation::with('teacher.disciplines', 'discipline', 'groups')
            ->orderBy('class_date')
            ->orderBy('class_number')
            ->get();

            // Добавляем к каждой консультации запись студента (если есть)
            $consultations = $consultations->map(function ($consultation) use ($student) {
                $consultation->registration = $consultation
                    ->registrationForStudent($student->id)
                    ->first();

            return $consultation;
        });

        }
        return response()->json($consultations);
    }

    public function show($id)
    {
        $consultation = Consultation::with([
            'teacher.disciplines',  // Загрузка дисциплин учителя
            'groups',
            'students' => function ($query) {
                $query->withPivot('is_present'); // Подгрузить поле is_present из таблицы visiting
            }
        ])->find($id);

        if ($consultation) {
            return response()->json($consultation);
        }

        return response()->json(['message' => 'Consultation not found'], 404);
    }
    public function update(Request $request, $id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }

        $validated = $request->validate([
            'class_date' => 'required|date',
            'class_number' => 'required|integer',
            'discipline_id' => 'required|exists:disciplines,id',
            'group_ids' => 'array',
            'group_ids.*' => 'exists:groups,id',
        ]);

        $consultation->update([
            'class_date' => $validated['class_date'],
            'class_number' => $validated['class_number'],
            'discipline_id' => $validated['discipline_id'],
        ]);

        if (isset($validated['group_ids'])) {
            $consultation->groups()->sync($validated['group_ids']);
        }

        return response()->json(['message' => 'Consultation updated successfully']);
    }
    public function destroy($id)
    {
        $consultation = Consultation::find($id);
    
        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }
    
        // Отвязываем связанные группы (pivot таблица)
        $consultation->groups()->detach();
    
        // Можно также удалить посещения, если есть связь
        $consultation->students()->detach();
    
        // Удаляем саму консультацию
        $consultation->delete();
    
        return response()->json(['message' => 'Consultation deleted successfully']);
    }
    

    public function store (Request $request)
    {
        // Валидация данных, переданных в запросе
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'discipline_id' => 'required|exists:disciplines,id',
            'class_date' => 'required|date',
            'class_number' => 'required|integer',
            'group_ids' => 'array',
            'group_ids.*' => 'exists:groups,id',
        ]);
    
        // // Создание новой консультации
        $consultation = Consultation::create([
            'teacher_id' => $validated['teacher_id'],
            'discipline_id' => $validated['discipline_id'],
            'class_date' => $validated['class_date'],
            'class_number' => $validated['class_number'],
        ]);
 
        // Если есть группы, привязываем их
        if (isset($validated['group_ids'])) {
            $consultation->groups()->sync($validated['group_ids']);
        }
    
        // Возвращаем успешный ответ
        return response()->json(['message' => 'Consultation created successfully', 'consultation' => $consultation], 201);
    }
    public function showWithRegistrations(Request $request)
    {
        $user = $request->user();
        if ($user->is_admin || $user->is_teacher) {
        $consultation = Consultation::with([
            'teacher.disciplines',
            'discipline',
            'groups',
            'registrations.student.group',
        ])->get();
        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }
        return response()->json($consultation);}
        else {
        // Получаем объект студента текущего пользователя
        $student = $user->student;

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Получаем регистрации студента с вложенными консультациями
        $registrations = $student->consultationRegistrations()
            ->with('consultation.teacher', 'consultation.discipline', 'consultation.groups','consultation.discipline',)
            ->get();

        return response()->json($registrations);
    }

    }
    

}
