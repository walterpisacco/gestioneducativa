<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\Base64ToFile;
use App\Interfaces\UserInterface;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\PromotionRepository;
use App\Repositories\StudentParentInfoRepository;
use App\Repositories\StudentAcademicInfoRepository;
use App\Models\Sons;

class UserRepository implements UserInterface {
    use Base64ToFile;

    public function createAdmin($request) {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'school_id'     => $request['school_id'],
                    'document'      => rand(1,99999999),
                    'first_name'    => 'Usuario',
                    'last_name'     => 'Admin',
                    'email'         => $request['email'],
                    'gender'        => 'Hombre',
                    'nationality'   => 1,
                    'role'          => 'admin',
                    'password'      => Hash::make($request['password']),
                ]);
                    $user->givePermissionTo(
                        'view users',
                        'view syllabi',
                        'view stadistic',
                        'view sections',
                        'view routines',
                        'view menu promocion',
                        'view menu planes',
                        'view menu niveles',
                        'view menu horarios',
                        'view menu eventos',
                        'view menu estudiantes',
                        'view menu docentes',
                        'view menu dashboard',
                        'view menu configuracion',
                        'view menu avisos',
                        'view menu administrativos',
                        'view marks',
                        'view grading systems rule',
                        'view grading systems',
                        'view exams rule',
                        'view exams',
                        'view events',
                        'view courses',
                        'view classes',
                        'view attendances',
                        'view assignments',
                        'view academic settings',
                        'view menu legajos',
                        'update marks submission window',
                        'update browse by session',
                        'update attendances type',
                        'take attendances',
                        'promote students',
                        'edit users',
                        'edit syllabi',
                        'edit semesters',
                        'edit sections',
                        'edit routines',
                        'edit notices',
                        'edit grading systems rule',
                        'edit grading systems',
                        'edit exams rule',
                        'edit events',
                        'edit courses',
                        'edit classes',
                        'delete users',
                        'delete syllabi',
                        'delete routines',
                        'delete notices',
                        'delete grading systems rule',
                        'delete grading systems',
                        'delete exams rule',
                        'delete events',
                        'create users',
                        'create syllabi',
                        'create semesters',
                        'create sections',
                        'create school sessions',
                        'create routines',
                        'create notices',
                        'create grading systems rule',
                        'create grading systems',
                        'create exams rule',
                        'create exams',
                        'create events',
                        'create courses',
                        'create classes',
                        'assign teachers',
                        'import users',
                       
                    );

                    return $user->id;
            });


        } catch (\Exception $e) {
            throw new \Exception('Failed to create Admin. '.$e->getMessage());
        }
    }

    public function createTeacher($request) {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'school_id'     => auth()->user()->school_id,
                    'document'      => $request['document'],
                    'first_name'    => $request['first_name'],
                    'last_name'     => $request['last_name'],
                    'email'         => $request['email'],
                    'gender'        => $request['gender'],
                    'nationality'   => $request['nationality'],
                    'phone'         => $request['phone'],
                    'address'       => $request['address'],
                    'address2'      => $request['address2'],
                    'city'          => $request['city'],
                    'zip'           => $request['zip'],
                    'photo'         => (!empty($request['photo']))?$this->convert($request['photo']):null,
                    'role'          => 'teacher',
                    'password'      => Hash::make($request['password']),
                ]);
                $user->givePermissionTo(
                    'create exams',
                    'delete exams',
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
                    'view courses',
                    'view menu dashboard',
                    'view menu examenes',
                    'view menu miscursos'  
                );
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to create Teacher. '.$e->getMessage());
        }
    }

    public function updateTeacher($request) {
        try {
            DB::transaction(function () use ($request) {
                User::where('id', $request['teacher_id'])->update([
                    'document'      => $request['document'],
                    'first_name'    => $request['first_name'],
                    'last_name'     => $request['last_name'],
                    'email'         => $request['email'],
                    'gender'        => $request['gender'],
                    'nationality'   => $request['nationality'],
                    'phone'         => $request['phone'],
                    'address'       => $request['address'],
                    'address2'      => $request['address2'],
                    'city'          => $request['city'],
                    'zip'           => $request['zip'],
                ]);
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to update Teacher. '.$e->getMessage());
        }
    }

    public function getAllTeachers() {
        try {
            return User::
                  where('role', 'teacher')
                ->where('school_id','=',auth()->user()->school_id)
                ->get();

        } catch (\Exception $e) {
            throw new \Exception('Failed to get all Teachers. '.$e->getMessage());
        }
    }

    public function getAllDirectivos() {
        try {
            return User::
                  where('role', 'directivo')
                ->where('school_id','=',auth()->user()->school_id)
                ->get();

        } catch (\Exception $e) {
            throw new \Exception('Failed to get all Directivos. '.$e->getMessage());
        }
    }

    public function getAllPreceptores() {
        try {
            return User::
                  where('role', 'preceptor')
                ->where('school_id','=',auth()->user()->school_id)
                ->get();

        } catch (\Exception $e) {
            throw new \Exception('Failed to get all Preceptores. '.$e->getMessage());
        }
    } 

    public function getAllAdministrativos() {
        try {
            return User::
                  where('role', 'administrativo')
                ->where('school_id','=',auth()->user()->school_id)
                ->get();

        } catch (\Exception $e) {
            throw new \Exception('Failed to get all administrativos. '.$e->getMessage());
        }
    } 

    public function getAllAdministratives() {
        try {
            return User::
                where('school_id','=',auth()->user()->school_id)
                ->whereIn('role',['directivo','preceptor','administrativo'])
                ->get();

        } catch (\Exception $e) {
            throw new \Exception('Error al intentar obtener los administrativos. '.$e->getMessage());
        }
    }  

    public function getAllStudents($session_id, $class_id, $section_id) {
        if($class_id == 0 || $section_id == 0) {
            $schoolClass = SchoolClass::where('session_id', $session_id)->first();
            $section = Section::where('session_id', $session_id)->first();

            if($schoolClass == null || $section == null){
                throw new \Exception('There is no class and section');
            } else {
                $class_id = $schoolClass->id;
                $section_id = $section->id;
            }
            
        }
        try {
            $promotionRepository = new PromotionRepository();
            return $promotionRepository->getAll($session_id, $class_id, $section_id);
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar recuperar los estudiantes. '.$e->getMessage());
        }
    }

    public function createAdministrative($request) {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'school_id'     => auth()->user()->school_id,
                    'document'      => $request['document'],
                    'first_name'    => $request['first_name'],
                    'last_name'     => $request['last_name'],
                    'email'         => $request['email'],
                    'gender'        => $request['gender'],
                    'nationality'   => $request['nationality'],
                    'phone'         => $request['phone'],
                    'address'       => $request['address'],
                    'address2'      => $request['address2'],
                    'city'          => $request['city'],
                    'zip'           => $request['zip'],
                    'photo'         => (!empty($request['photo']))?$this->convert($request['photo']):null,
                    'role'          => $request['rol'],
                    'password'      => Hash::make($request['password']),
                ]);
                    $user->givePermissionTo(
                        'view users',
                        'view courses',
                        'view classes',
                        'view sections',
                        'view exams',
                        'view routines',
                        'view marks',
                        'view academic settings',
                        'view users',
                        'view grading systems',
                        'view grading systems rule',
                        'view events',
                        'view syllabi',
                        'view assignments',
                        'view menu dashboard',
                        'view menu niveles',
                        'view menu estudiantes',
                        'view menu legajos',                        
                    );

                switch ($request['rol']) {
                  case "directivo":
                        $user->givePermissionTo(
                            'create notices',
                            'edit notices',
                            'delete notices',
                            'create events',
                            'view events',
                            'edit events',
                            'delete events',
                            'view stadistic',
                            'view menu avisos',
                            'view menu eventos',
                            'view menu administrativos',
                            'view menu docentes',
                        );
                    break;
                  case "administrativo":
                        $user->givePermissionTo(
                            'view notices',                            
                            'create semesters',
                            'edit semesters',
                            'assign teachers',
                            'create courses',
                            'edit courses',
                            'create classes',
                            'edit classes',
                            'create sections',
                            'edit sections',
                            'create exams',
                            'create exams rule',
                            'edit exams rule',
                            'delete exams rule',
                            'create routines',
                            'edit routines',
                            'delete routines',
                            'update marks submission window',
                            //'create users',
                            'edit users',
                            'promote students',
                            'view attendances',
                            'update attendances type',
                            'edit attendances',
                            'create grading systems',
                            'edit grading systems',
                            'delete grading systems',
                            'create grading systems rule',
                            'edit grading systems rule',
                            'delete grading systems rule',
                            'create notices',
                            'edit notices',
                            'delete notices',
                            'create events',
                            'view events',
                            'edit events',
                            'delete events',
                            'create syllabi',
                            'edit syllabi',
                            'delete syllabi',
                            'view menu horarios',
                            'view menu asistencia',
                            'view menu eventos',
                            'view menu planes',
                            'view menu administrativos',
                            'view menu docentes',                                                        
                        );
                    break;
                  case "preceptor":
                        $user->givePermissionTo(
                            'view notices',                            
                            'create routines',
                            'edit routines',
                            'delete routines',
                            'take attendances',
                            'view attendances',
                            'create events',
                            'view events',
                            'edit events',
                            'delete events',
                            'view menu asistencia',
                            'view classes'                           
                        );
                    break;
                }

            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to create Teacher. '.$e->getMessage());
        }
    }

    public function updateAdministrative($request) {
        try {
            DB::transaction(function () use ($request) {
                User::where('id', $request['administrative_id'])->update([
                    'document'      => $request['document'],
                    'role'          => $request['role'],
                    'first_name'    => $request['first_name'],
                    'last_name'     => $request['last_name'],
                    'email'         => $request['email'],
                    'gender'        => $request['gender'],
                    'nationality'   => $request['nationality'],
                    'phone'         => $request['phone'],
                    'address'       => $request['address'],
                    'address2'      => $request['address2'],
                    'city'          => $request['city'],
                    'zip'           => $request['zip'],
                ]);
            });
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar actualizar. '.$e->getMessage());
        }
    }

    public function createStudent($request) {
        try {
            //$idPadre = User::select("id")->where('document','=',$request['father_document'])->first();
            //id = $idPadre->id;

            //dd($request['religion']);
            DB::transaction(function () use ($request) {
                $student = User::create([
                    'school_id'         => auth()->user()->school_id,
                    'document'          => $request['document'],
                    'first_name'        => $request['first_name'],
                    'last_name'         => $request['last_name'],
                    'email'             => $request['email'],
                    'gender'            => $request['gender'],
                    'nationality'       => $request['nationality'],
                    'phone'             => $request['phone'],
                    'address'           => $request['address'],
                    'address2'          => $request['address2'],
                    'city'              => $request['city'],
                    'zip'               => $request['zip'],
                    'photo'             => (!empty($request['photo']))?$this->convert($request['photo']):null,
                    'birthday'          => $request['birthday'],
                    'religion'          => $request['religion'],
                    'blood_type'        => $request['blood_type'],
                    'role'              => 'student',
                    'father_document'   => $request['father_document'],
                    'password'          => Hash::make($request['password']),
                ]);

                // Store Parents' information
                $studentParentInfoRepository = new StudentParentInfoRepository();
                $studentParentInfoRepository->store($request, $student->id);

                // Store Academic information
                $studentAcademicInfoRepository = new StudentAcademicInfoRepository();
                $studentAcademicInfoRepository->store($request, $student->id);

                // Assign student to a Class and a Section
                $promotionRepository = new PromotionRepository();
                $promotionRepository->assignClassSection($request, $student->id);

                $student->givePermissionTo(
                    'view menu dashboard',
                    'view attendances',
                    'view marks',
                    'view routines',
                    'view syllabi',
                    'view events',
                    'view notices',
                    'view menu examenes',
                    'view menu misasignaturas',
                    'view menu miasistencia',
                    'view menu mishorarios',
                    'view menu miboletin'
                );
            });
        } catch (\Exception $e) {
            throw new \Exception('Error al crear estudiante. '.$e->getMessage());
        }
    }

    public function createPadre($request) {
        try {
            DB::transaction(function () use ($request) {
                $padre = User::create([
                    'school_id'     => auth()->user()->school_id,
                    'document'      => $request['father_document'],
                    'first_name'    => $request['father_name'],
                    'last_name'     => $request['father_last_name'],
                    'email'         => $request['father_email'],
                    'gender'        => 'Hombre',
                    'nationality'   => $request['father_nationality'],
                    'phone'         => $request['father_phone'],
                    'role'          => 'padre',
                    'father_id'     =>  0,
                    'password'      => Hash::make($request['password']),
                ]);

                $padre->givePermissionTo(
                    'view menu dashboard',
                    'view exams',
                    'view marks',
                    'view users',
                    'view routines',
                    'view syllabi',
                    'view events',
                    'view notices',
                    'view menu examenes',
                    'view menu misasignaturas',
                    'view menu miasistencia',
                    'view menu mishorarios',
                    'view menu miboletin'
                );
            });
            //return $padre->id;
            
        } catch (\Exception $e) {
            throw new \Exception('Error al crear el padre.'.$e->getMessage());
        }
    }    

    public function updateStudent($request) {
        try {
            DB::transaction(function () use ($request) {
                User::where('id', $request['student_id'])->update([
                    'document'          => $request['document'],
                    'father_document'   => $request['father_document'],
                    'first_name'        => $request['first_name'],
                    'last_name'         => $request['last_name'],
                    'email'             => $request['email'],
                    'gender'            => $request['gender'],
                    'nationality'       => $request['nationality'],
                    'phone'             => $request['phone'],
                    'address'           => $request['address'],
                    'address2'          => $request['address2'],
                    'city'              => $request['city'],
                    'zip'               => $request['zip'],
                    'birthday'          => $request['birthday'],
                    'religion'          => $request['religion'],
                    'blood_type'        => $request['blood_type'],
                ]);

                // Update Parents' information
                $studentParentInfoRepository = new StudentParentInfoRepository();
                $studentParentInfoRepository->update($request, $request['student_id']);

                // Update Student's ID card number
                $promotionRepository = new PromotionRepository();
                $promotionRepository->update($request, $request['student_id']);
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to update Student. '.$e->getMessage());
        }
    }


    public function updatePadre($request) {
        try {
            DB::transaction(function () use ($request) {
                User::where('id', $request['father_id'])->update([
                    'document'      => $request['father_document'],
                    'first_name'    => $request['father_name'],
                    'last_name'     => $request['father_last_name'],
                    'email'         => $request['father_email'],
                    'phone'         => $request['father_phone'],
                ]);

                // Update Parents' information
                $studentParentInfoRepository = new StudentParentInfoRepository();
                $studentParentInfoRepository->update($request, $request['student_id']);

                // Update Student's ID card number
                $promotionRepository = new PromotionRepository();
                $promotionRepository->update($request, $request['student_id']);
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to update Student. '.$e->getMessage());
        }
    }

    public function getAllSons($session_id, $class_id, $section_id,$user_id) {
        try {
            //return Sons::where('padre_id',$user_id);
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar recuperar los estudiantes. '.$e->getMessage());
        }
    }    

    public function getAllStudentsBySession($session_id) {
        $promotionRepository = new PromotionRepository();
        return $promotionRepository->getAllStudentsBySession($session_id);
    }

    public function getAllStudentsBySessionCount($session_id) {
        $promotionRepository = new PromotionRepository();
        return $promotionRepository->getAllStudentsBySessionCount($session_id);
    }

    public function getAllStudentsByClassCount($session_id) {
        $promotionRepository = new PromotionRepository();
        return $promotionRepository->getAllStudentsByClassCount($session_id);
    }    

    public function findStudent($id) {
        try {
            return User::with('parent_info', 'academic_info')->where('id', $id)->first();
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar recuperar el estudiante. '.$e->getMessage());
        }
    }

    public function findPadre($document) {
        try {
            return User::where('document', $document)->first();
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar recuperar el padre. '.$e->getMessage());
        }
    }

    public function findTeacher($id) {
        try {
            return User::where('id', $id)->where('role', 'teacher')->first();
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar recuperar el usuario. '.$e->getMessage());
        }
    }

    public function findAdministrative($id) {
        try {
            return User::where('id', $id)->first();
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar recuperar el usuario. '.$e->getMessage());
        }
    }

    public function changePassword($new_password) {
        try {
            return User::where('id', auth()->user()->id)->update([
                'password'  => Hash::make($new_password)
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar cambiar la contraseña. '.$e->getMessage());
        }
    }
  
}