<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Student;


class GroupController extends Controller
{
    // Получить все группы
    public function index()
    {
        $groups = Group::all(); // Получаем все группы
        return response()->json($groups);
    }

    public function show($id)
    {
        // Загрузить группу с её студентами
        $group = Group::with('students')->find($id);

        if ($group) {
            return response()->json($group);
        }

        return response()->json(['message' => 'Group not found'], 404);
    }
    // Создать новую группу
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // другие правила валидации
        ]);

        $group = Group::create([
            'name' => $request->input('name'),
            // другие поля
        ]);

        return response()->json($group, 201);
    }

    // Обновить группу
    public function update(Request $request, $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $group->update([
            'name' => $request->input('name'),
            // другие поля
        ]);

        return response()->json($group);
    }

    // Удалить группу
    public function destroy($id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $group->delete();

        return response()->json(['message' => 'Group deleted successfully']);
    }
    
}
