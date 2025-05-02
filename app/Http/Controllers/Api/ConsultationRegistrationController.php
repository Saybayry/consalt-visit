<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultationRegistration;
use App\Models\Consultation;
class ConsultationRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ConsultationRegistration::all();
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
            ]);
    
            $data['student_id'] = $student->id;
        }
    
        $registration = ConsultationRegistration::create($data);
    
        return response()->json($registration, 201);

    }
    

    /**
     * Display the specified resource.
     */public function show($id)
    {
        $registration = ConsultationRegistration::with(['student.group'])->findOrFail($id);
        return response()->json($registration);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $registration = ConsultationRegistration::findOrFail($id);

        $data = $request->validate([
            'is_present' => 'boolean',
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
    
}
