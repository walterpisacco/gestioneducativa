<?php

namespace App\Repositories;

use App\Models\StudentParentInfo;

class StudentParentInfoRepository {
    public function store($request, $student_id) {
        try {
            $father_notify = 0;
            $mother_notify = 0;

            if(isset($request['father_notify'])){
                $father_notify = 1;
            }
            
            if(isset($request['mother_notify'])){
                $mother_notify = 1;
            }

            StudentParentInfo::create([
                'student_id'        => $student_id,
                'father_name'       => $request['father_name'],
                'father_last_name'  => $request['father_last_name'],
                'father_phone'      => $request['father_phone'],
                'father_email'      => $request['father_email'],
                'father_notify'     => $father_notify,
            //    'mother_name'   => $request['mother_name'],
            //    'mother_phone'  => $request['mother_phone'],
            //    'mother_email'  => $request['mother_email'],
            //    'mother_notify' => $mother_notify,
            //    'parent_address'=> $request['parent_address'],
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar crear inofrmación de los padres. '.$e->getMessage());
        }
    }

    public function getParentInfo($student_id) {
        return StudentParentInfo::
            where('student_id', $student_id)
            ->first();
    }

    public function update($request, $student_id) {
        try {
          //  dd($request);
           // exit;

            if($request['father_notify']=='on'){$father_notify = 1;}else{$father_notify = 0;}
            if($request['mother_notify']=='on'){$mother_notify = 1;}else{$mother_notify = 0;}
            
            StudentParentInfo::where('student_id', $student_id)->update([
                'father_name'   => $request['father_name'],
                'father_phone'  => $request['father_phone'],
                'father_email'  => $request['father_email'],
                'father_notify' => $father_notify,                
               // 'mother_name'   => $request['mother_name'],
               // 'mother_phone'  => $request['mother_phone'],
               // 'mother_email'  => $request['mother_email'],
               // 'mother_notify' => $mother_notify,                
               // 'parent_address'=> $request['parent_address'],
            ]);

        } catch (\Exception $e) {
            throw new \Exception('Error al intentar crear inofrmación de los padres. '.$e->getMessage());
        }
    }
}