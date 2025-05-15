<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\ConsultationRegistration;
class ConsultationRegistrationsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ConsultationRegistration::with(['student.group', 'consultation'])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'student_name' => collect([
                            $item->student->lname ?? '',
                            $item->student->fname ?? '',
                            $item->student->mname ?? '',
                        ])->filter()->implode(' '),

                    'group_name' => $item->student->group->name ?? '',
                    'consultation_topic' => $item->consultation->discipline->name ?? '',
                    'teacher_name' => collect([
                        $item->consultation->teacher->lname ?? '',
                        $item->consultation->teacher->fname ?? '',
                        $item->consultation->teacher->mname ?? '',
                    ])->filter()->implode(' '),
                    'is_present' => $item->is_present ? 'Присутствовал' : 'Отсутствовал',
                    'created_at' => optional($item->created_at)->format('Y-m-d H:i') ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Студент',
            'Группа',
            'Дисциплина',
            'Преподаватель',
            'Присутствие',
            'Дата регистрации',
        ];
    }
}
