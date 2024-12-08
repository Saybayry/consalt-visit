<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with('teacher', 'discipline',"groups")
        ->orderBy('class_date')  
        ->orderBy('class_number') 
        ->get();

        return response()->json($consultations);
    }

    public function show($id)
    {
            // Загрузить группу с её студентами
        // Загрузить консультацию с её преподавателем, студентами и их посещениями
        $consultation = Consultation::with([
            'teacher',
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
}
