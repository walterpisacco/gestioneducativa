<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class PromotionRepository {
    public function assignClassSection($request, $student_id) {
        try{
            Promotion::create([
                'student_id'    => $student_id,
                'session_id'    => $request['session_id'],
                'class_id'      => $request['class_id'],
                'section_id'    => $request['section_id'],
                'id_card_number'=> $request['id_card_number'],
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to add Student. '.$e->getMessage());
        }
    }

    public function update($request, $student_id) {
        try{
            Promotion::where('student_id', $student_id)->update([
                'id_card_number'=> $request['id_card_number'],
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to update Student. '.$e->getMessage());
        }
    }

    public function massPromotion($rows) {
        try {
                foreach($rows as $row){
                    Promotion::updateOrCreate([
                        'student_id' => $row['student_id'],
                        'session_id' => $row['session_id'],
                        'class_id' => $row['class_id'],
                        'section_id' => $row['section_id'],
                    ],[
                        'id_card_number' => $row['id_card_number'],
                    ]);
                }
        } catch (\Exception $e) {
            throw new \Exception('Failed to promote students. '.$e->getMessage());
        }
    }

    public function getAll($session_id, $class_id, $section_id) {
        return Promotion::with(['student', 'section','asistencia'])
                ->where('session_id', $session_id)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('deleted_at', NULL)
                ->get();
    }

    public function getAllStudentsBySessionCount($session_id) {
        return Promotion::where('session_id', $session_id)->where('deleted_at', NULL)->count();
    }

    public function getMaleStudentsBySessionCount($session_id) {
        $allStudents = Promotion::where('session_id', $session_id)->where('deleted_at', NULL)->pluck('student_id')->toArray();

        return User::where('gender', 'Hombre')
                ->where('role', 'student')
                ->whereIn('id', $allStudents)
                ->count();
    }

    public function getAllStudentsBySession($session_id) {
        return Promotion::with(['student', 'section'])
                ->where('session_id', $session_id)
                ->where('deleted_at', NULL)
                ->get();
    }

    public function getPromotionInfoById($session_id, $student_id) {
        return Promotion::with(['student', 'section'])
                ->where('session_id', $session_id)
                ->where('student_id', $student_id)
                ->where('deleted_at', NULL)
                ->first();
    }


    public function getAllStudentsByClassCount($session_id) {
        return Promotion::
        select('school_classes.class_name as class',DB::raw('count(promotions.class_id) as cantidad'))
        ->join('school_classes','school_classes.id','=','promotions.class_id')
        ->where('promotions.session_id', $session_id)
        ->where('promotions.deleted_at', NULL)
        ->groupBy('promotions.class_id')
        ->get();
    }

    public function getClasses($session_id) {
        return Promotion::with('schoolClass')->select('class_id')
                    ->where('session_id', $session_id)
                    ->where('deleted_at', NULL)
                    ->distinct('class_id')
                    ->get();
    }

    public function getSections($session_id, $class_id) {
        return Promotion::with('section')->select('section_id')
                    ->where('session_id', $session_id)
                    ->where('class_id', $class_id)
                    ->where('deleted_at', NULL)
                    ->distinct('section_id')
                    ->get();
    }

    public function getSectionsBySession($session_id) {
        return Promotion::with('section')->select('section_id')
                    ->where('session_id', $session_id)
                    ->where('deleted_at', NULL)
                    ->distinct('section_id')
                    ->get();
    }
}