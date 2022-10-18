<?php

namespace App\Repositories;

use App\Models\Semester;
use App\Models\AssignedTeacher;
use App\Interfaces\AssignedTeacherInterface;

class AssignedTeacherRepository implements AssignedTeacherInterface {

    public function assign($request) {
        try {
            $assigned = AssignedTeacher::create($request);
            return $assigned->id;
        } catch (\Exception $e) {
            throw new \Exception('Failed to assign teacher. '.$e->getMessage());
        }
    }

    public function getAll($session_id) {
        return AssignedTeacher::
            where('session_id', $session_id)
            ->orderBy('teacher_id','ASC')
            ->orderBy('class_id','ASC')
            ->orderBy('section_id', 'ASC')
            ->orderBy('course_id', 'ASC')
            ->get();
    }

    public function getTeacherCourses($session_id, $teacher_id) {

        return AssignedTeacher::with(['course', 'schoolClass', 'section'])
                        ->where('session_id', $session_id)
                        ->where('teacher_id', $teacher_id)
                        ->get(); 
    }

    public function getAssignedTeacher($session_id, $semester_id, $class_id, $section_id, $course_id, $teacher_id) {
        $asignado =  AssignedTeacher::where('session_id', $session_id)
                        ->where('class_id', $class_id)
                        ->where('section_id', $section_id)
                        ->where('course_id', $course_id)
                        ->where('teacher_id', $teacher_id)
                        ->first(); 

      //  dd($asignado);
        return $asignado;
    }
}