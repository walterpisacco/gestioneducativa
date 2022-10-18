<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AssignedTeacherRepository;

trait AssignedTeacherCheck {
    /**
     * @param  \Illuminate\Http\Request $request
     * @param int $current_school_session_id
     * @return string
    */
    public function checkIfLoggedInUserIsAssignedTeacher(Request $request, $current_school_session_id) {
        $assignedTeacherRepository = new AssignedTeacherRepository();

        $teacher_id = Auth::user()->id;

        $assignedTeacher = $assignedTeacherRepository->getAssignedTeacher($current_school_session_id, 0, $request->class_id, $request->section_id, $request->course_id, $teacher_id);

        if($assignedTeacher === null || $assignedTeacher->teacher_id !== Auth::user()->id) {
            abort(404);
        }
    }
}