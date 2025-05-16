<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\ConsultationRegistration;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConsultationRegistrationsExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $start_date;
    protected $end_date;
    protected $mergeRanges = [];

    public function __construct($start_date = null, $end_date = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function array(): array
{
    $query = ConsultationRegistration::with(['student.group', 'consultation.teacher', 'consultation.discipline']);

    if ($this->start_date && $this->end_date) {
        $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
    } elseif ($this->start_date) {
        $query->where('created_at', '>=', $this->start_date);
    } elseif ($this->end_date) {
        $query->where('created_at', '<=', $this->end_date);
    }

    $registrations = $query->get()->groupBy('consultation_id');
    $rows = [];
    $rowIndex = 2; // первая строка — заголовки

    foreach ($registrations as $consultationGroup) {
        $first = $consultationGroup->first();

        $teacher = collect([
            $first->consultation->teacher->lname ?? '',
            $first->consultation->teacher->fname ?? '',
            $first->consultation->teacher->mname ?? '',
        ])->filter()->implode(' ');

        $date = optional($first->created_at)->format('Y-m-d');
        $pair = $first->consultation->class_number ?? '-';
        $discipline = $first->consultation->discipline->name ?? '';

        $startRow = $rowIndex;

        foreach ($consultationGroup as $reg) {
            $student = collect([
                $reg->student->lname ?? '',
                $reg->student->fname ?? '',
                $reg->student->mname ?? '',
            ])->filter()->implode(' ');

            $group = $reg->student->group->name ?? '';
            $presence = $reg->is_present ? 'Присутствовал' : 'Отсутствовал';
            $note = $reg->noute;

            $rows[] = [
                $teacher,
                $date,
                $pair,
                $discipline,
                $student,
                $group,
                $presence,
                $note,
            ];

            $rowIndex++;
        }

        $endRow = $rowIndex - 1;

        if ($endRow > $startRow) {
            // Объединяем 4 первых колонки (A-D)
            $this->mergeRanges[] = [
                'A' . $startRow . ':A' . $endRow,
                'B' . $startRow . ':B' . $endRow,
                'C' . $startRow . ':C' . $endRow,
                'D' . $startRow . ':D' . $endRow,
            ];
        }
    }

    return $rows;
}


    public function headings(): array
    {
        return [
        'ФИО преподавателя',
        'Дата консультации',
        'Пара',
        'Дисциплина',
        'Студент',
        'Группа',
        'Присутствие',
        'Заметка',
        ];
    }

public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            // Объединение ячеек A–D по записям одной консультации
            foreach ($this->mergeRanges as $rangeSet) {
                foreach ($rangeSet as $range) {
                    $event->sheet->mergeCells($range);
                    $event->sheet->getStyle($range)->getAlignment()->setVertical('top');
                    $event->sheet->getStyle($range)->getAlignment()->setWrapText(true);
                }
            }

            // Жирный шрифт заголовков
            $event->sheet->getStyle('A1:H1')->getFont()->setBold(true);
        },
    ];
}

}