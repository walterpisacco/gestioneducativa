<?php

namespace App\Repositories;

use App\Models\Exam;
use App\Models\Semester;
use App\Models\SchoolClass;
use App\Models\AssignedTeacher;
use App\Interfaces\ExamInterface;
use App\Models\ExamRule;

class ExamRepository implements ExamInterface {
    public function create($request) {
        try {
            Exam::create($request);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear el examen. '.$e->getMessage());
        }
    }

    public function delete($id) {
        try {
            Exam::destroy($id);
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar eliminar el examen. '.$e->getMessage());
        }
    }

    public function getAll($session_id, $semester_id, $class_id, $section_id)
    {
        if($semester_id == 0 || $class_id == 0) {
            $semester_id = Semester::where('session_id', $session_id)->first()->id;
            $class_id = SchoolClass::where('session_id', $session_id)->first()->id;
        }
        
        return Exam::with('course')
                    ->where('session_id', $session_id)
                    ->where('semester_id', $semester_id)
                    ->where('class_id', $class_id)
                    ->where('section_id', $section_id)
                    ->get();
    }

    public function getAllByCourse($session_id, $teacher_id)
    {
        $cursos = AssignedTeacher::
            where('teacher_id',$teacher_id)
            ->groupBy('course_id')
            ->pluck('course_id');

        return Exam::with('course')
                    ->where('session_id', $session_id)
                    ->whereIn('course_id',$cursos)
                    ->get();
    }    

    public function getExmanesparaCalificar($session_id, $semester_id, $course,$section)
    {
        return Exam::with('course')
                    ->where('session_id', $session_id)
                    ->where('course_id', $course)
                    ->where('section_id', $section)
                    ->get();
    }    
}