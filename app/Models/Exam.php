<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Semester;
use App\Models\ExamRule;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $fillable = [
        'exam_name',
        'start_date',
        'end_date',
        'semester_id',
        'class_id',
        'course_id',
        'section_id',
        'session_id'
    ];


    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }


    public function schoolClass() {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }


    public function section() {
        return $this->belongsTo(Section::class, 'section_id');
    }



    public function semester() {
        return $this->belongsTo(Semester::class, 'semester_id');
    }


    public function rule() {
        return $this->hasOne(ExamRule::class, 'exam_id', 'id');
    }    
}
