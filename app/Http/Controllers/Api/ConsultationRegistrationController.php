<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultationRegistration;
use App\Models\Consultation;
use App\Models\Student;
use App\Exports\ConsultationRegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;
class ConsultationRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->is_admin || $user->is_teacher) {
            return ConsultationRegistration::all();
        }else {
            // Получаем объект студента текущего пользователя
            $student = $user->student;

            // Ищем регистрацию с нужным id, которая принадлежит именно этому студенту
            $registrations = ConsultationRegistration::with(['student.group'])
                ->where('student_id', $student->id)
                ->get();

            if (!$registrations) {
                // Если регистрации нет или она не принадлежит студенту — 404 или другое сообщение
                return response()->json(['message' => 'Registration not found or access denied'], 404);
            }
            return response()->json($registrations);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
    
        // Админы и преподаватели могут указать student_id явно
        if ($user->is_admin || $user->is_teacher) {
            $data = $request->validate([
                'student_id' => 'required|exists:students,id',
                'consultation_id' => 'required|exists:consultations,id',
                'is_present' => 'boolean',
            ]);
        } else {
            // Студент — связываем student_id по связанному объекту
            $student = $user->student; // допустим, у пользователя есть связь `student()`
            if (!$student) {
                return response()->json(['error' => 'Студент не найден для пользователя.'], 403);
            }
    
            $data = $request->validate([
                'consultation_id' => 'required|exists:consultations,id',
                'is_present' => 'boolean',
                'noute' => 'nullable|string',
            ]);
    
            $data['student_id'] = $student->id;
        }
    
        $registration = ConsultationRegistration::create($data);
    
        return response()->json($registration, 201);

    }
    

    /**
     * Display the specified resource.
     */public function show($id, Request $request)
    {   $user = $request->user();
         if ($user->is_admin || $user->is_teacher) {
                $registration = ConsultationRegistration::with(['student.group'])->findOrFail($id);
                return response()->json($registration);
        }else{
            $student = $user->student();
              // Ищем регистрацию с нужным id, которая принадлежит именно этому студенту
            $registration = ConsultationRegistration::with(['student.group'])
                ->where('id', $id)
                ->where('student_id', $student->id)
                ->first();

            if (!$registration) {
                // Если регистрации нет или она не принадлежит студенту — 404 или другое сообщение
                return response()->json(['message' => 'Registration not found or access denied'], 404);
            }

            return response()->json($registration);
        }
        // $registration = ConsultationRegistration::with(['student.group'])->findOrFail($id);
        // return response()->json($registration);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $registration = ConsultationRegistration::findOrFail($id);

        $data = $request->validate([
            'is_present' => 'boolean',
            'noute' => 'nullable|string',
        ]);

        $registration->update($data);

        return response()->json($registration);
    }
    // showByConsalt
    
    public function showByConsalt($id)
    {
        $registration = Consultation::with(['registrations.student.group'])->findOrFail($id);
        return response()->json($registration);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();
    
        $registration = ConsultationRegistration::findOrFail($id);
    
        // Только админ или преподаватель могут удалять любые записи
        // Студент — только свою
        if ($user->is_admin || $user->is_teacher || $registration->student_id === optional($user->student)->id) {
            $registration->delete();
            return response()->json(null, 204);
        }
    
        return response()->json(['error' => 'Доступ запрещен.'], 403);
    }



        public function exportExcel(Request $request)
    {
            $start_date = $request->query('start_date'); // или $request->input('start_date')
            $end_date = $request->query('end_date');

            return Excel::download(new ConsultationRegistrationsExport($start_date, $end_date), 'consultation_registrations.xlsx');
    }


}
