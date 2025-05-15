<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Exports\ConsultationRegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;
class ConsultationRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'consultation_id',
        'is_present',
        "noute",
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

        public function exportExcel()
    {
        return Excel::download(new ConsultationRegistrationsExport, 'consultation_registrations.xlsx');
    }
}