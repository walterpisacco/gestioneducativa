<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class TeacherImport implements ToCollection
{

    public $session_id;
        
    public function __construct($session_id)
    {
        $this->session_id = $session_id;
    }

     public function collection(Collection $rows)
    {

         Validator::make($rows->toArray(), [
             '*.1' => 'required',
         ])->validate();

            foreach ($rows as $row) {
                if($row[0]=='Docente'){
                    if($row[5]=='F'){$sexo = 'Hombre';}else{$sexo = 'Mujer';}

                    $user= User::create([
                            'school_id'         =>  auth()->user()->school_id,
                            'document'          =>  $row[1],
                            'first_name'        =>  $row[2],
                            'last_name'         =>  $row[3],
                            'email'             =>  $row[4],
                            'role'              =>  'teacher',
                            'gender'            =>  $sexo,
                            'nationality'       =>  1,
                            'photo'             =>  '/photos/profile.png',
                            'phone'             =>  $row[6],
                            'password'          =>  Hash::make($row[1])
                        ]);
                    $lastInsertedId= $user->id;

                    $user->givePermissionTo(
                        'create exams',
                        'view exams',
                        'create exams rule',
                        'view exams rule',
                        'edit exams rule',
                        'delete exams rule',
                        'take attendances',
                        'view attendances',
                        'create assignments',
                        'view assignments',
                        'save marks',
                        'view users',
                        'view routines',
                        'view syllabi',
                        'view events',
                        'view notices',
                        'view menu dashboard',
                        'view menu examenes',
                        'view menu miscursos'  
                    );
            }
        }
    }

}
