<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['disciplines', 'user'])->get();
        // Получаем все группы
        return response()->json($teachers);
    }

    public function show($id)
    {
        // Ищем учителя по ID
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        // Возвращаем найденного учителя в формате JSON
        return response()->json($teacher);
    }
    public function store(Request $request){}
    public function update(Request $request, $id){}
    public function destroy($id){}

}
