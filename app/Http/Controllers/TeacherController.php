<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Interfaces\UserInterface;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\User;
use App\Models\TypeNationality;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    use SchoolSession;
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->middleware(['can:view users']);

        $this->userRepository = $userRepository;
    }


    public function createTeacher() {
        $nacionalidades = TypeNationality::All();

        $data = [
            'nacionalidades'=> $nacionalidades,
        ];

        return view('teachers.add', $data);
    }

    public function storeTeacher(TeacherStoreRequest $request){
        try {
            $this->userRepository->createTeacher($request->validated());

            return back()->with('status', 'Docente creado con éxito!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function updateTeacher(Request $request) {
        try {
            $this->userRepository->updateTeacher($request->toArray());

            return back()->with('status', 'Docente actualizado con éxito!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function showTeacherProfile($id) {
        $teacher = $this->userRepository->findTeacher($id);
        $data = [
            'teacher'   => $teacher,
        ];
        return view('teachers.profile', $data);
    }

    public function editTeacher($teacher_id) {
        $teacher = $this->userRepository->findTeacher($teacher_id);
        $nacionalidades = TypeNationality::All();

        $data = [
            'teacher'   => $teacher,
            'nacionalidades'=> $nacionalidades,
        ];

        return view('teachers.edit', $data);
    }

    public function getTeacherList(){
        $teachers = $this->userRepository->getAllTeachers();

        $data = [
            'teachers' => $teachers,
        ];

        return view('teachers.list', $data);
    }

    public function deleteTeacher(Request $request) {
        try {
            $this->middleware(['can:delete users']);
            $id = $request->id;
            $usuario = User::find($id);

            $usuario->delete();

            $result = array();
            $result['success'] = 'true';
            $result['texto'] = 'usuario eliminado con éxito!';
            return json_encode($result);

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

 }
