<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\SchoolSession;
use App\Models\Attendance;
use App\Interfaces\AttendanceInterface;
use Illuminate\Support\Facades\DB;

class AttendanceRepository implements AttendanceInterface {

    public function saveAttendance($request) {
        try {
            $input = $this->prepareInput($request);

         //   dd($input);
            Attendance::insert($input);
        } catch (\Exception $e) {
            throw new \Exception('Failed to save attendance. '.$e->getMessage());
        }
    }

    public function prepareInput($request) {
        $school_session = SchoolSession::
          where('school_id','=',auth()->user()->school_id)
        ->latest()
        ->first();
        
        $input = [];
        $now = Carbon::now()->toDateTimeString();
        for($i=0; $i < sizeof($request['student_ids']); $i++) {
            $student_id = $request['student_ids'][$i];

          //  dd($request['status']);

            $input[] = array(
                'fecha'         => $request['fecha'],
                'status'        => (isset($request['status'][$student_id]))?$request['status'][$student_id]:'off',
                'class_id'      => $request['class_id'],
                'student_id'    => $student_id,
                'section_id'    => $request['section_id'],
                'course_id'     => $request['course_id'],
                'session_id'    => $school_session->id,
                'created_at'    => $now,
                'updated_at'    => $now,
            );
        }
        return $input;
    }

    public function getSectionAttendance($class_id, $section_id, $session_id, $day) {
        try {
            return Attendance::with('student')
                            ->where('class_id', $class_id)
                            ->where('section_id', $section_id)
                            ->where('session_id', $session_id)
                            ->whereDate('fecha', '=', $day)
                            ->get();
        } catch (\Exception $e) {
            throw new \Exception('Failed to get attendances. '.$e->getMessage());
        }
    }

    public function getCourseAttendance($class_id, $course_id, $session_id) {
        try {
            return Attendance::with('student')
                            ->where('class_id', $class_id)
                            ->where('course_id', $course_id)
                            ->where('session_id', $session_id)
                            ->whereDate('fecha', '=', Carbon::today())
                            ->get();
        } catch (\Exception $e) {
            throw new \Exception('Failed to get attendances. '.$e->getMessage());
        }
    }

    public function getStudentAttendance($session_id, $student_id) {
        try {
            return Attendance::with(['section','course'])
                            ->where('student_id', $student_id)
                            ->where('session_id', $session_id)
                            ->orderBy('fecha')
                            ->get();

        } catch (\Exception $e) {
            throw new \Exception('Failed to get attendances. '.$e->getMessage());
        }
    }


    public function getAllAttendanceByDay($session_id, $day) {
        try {
           // dd($day->format('Y-m-d'));
            return Attendance::select('status',DB::raw('count(id) as cantidad'))
                            ->where(DB::raw("(SUBSTRING(fecha,1,10))"), $day)
                            ->where('session_id', $session_id)
                            ->groupBy('status')
                            ->get();
        } catch (\Exception $e) {
            throw new \Exception('Failed to get attendances. '.$e->getMessage());
        }
    }
}