<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Interfaces\UserInterface;
use App\Http\Requests\AdministrativeStoreRequest;
use App\Interfaces\SchoolSessionInterface;
use App\Models\User;
use App\Models\TypeNationality;
use App\Http\Requests\PadreStoreRequest;
use Illuminate\Support\Facades\Validator;

class AdministrativeController extends Controller
{
    use SchoolSession;
    protected $userRepository;
    protected $schoolSessionRepository;
    protected $schoolClassRepository;
    protected $schoolSectionRepository;

    public function __construct(UserInterface $userRepository, SchoolSessionInterface $schoolSessionRepository)
    {
        $this->middleware(['can:view users']);

        $this->userRepository = $userRepository;
        $this->schoolSessionRepository = $schoolSessionRepository;
    }

    public function createAdministrative() {
        $nacionalidades = TypeNationality::All();

        $data = [
            'nacionalidades'            => $nacionalidades,
        ];

        return view('administratives.add', $data);
    }

    public function storeAdministrative(AdministrativeStoreRequest $request){
        try {
            $this->userRepository->createAdministrative($request->validated());

            return back()->with('status', 'Administrativo creado con éxito!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function showAdministrativeProfile($id) {
        $administrative = $this->userRepository->findAdministrative($id);
        $data = [
            'administrative'   => $administrative,
        ];
        return view('administratives.profile', $data);
    }

    public function editAdministrative($id) {
        $administrative = $this->userRepository->findAdministrative($id);
        $nacionalidades = TypeNationality::All();

        $data = [
            'administrative'   => $administrative,
            'nacionalidades'=> $nacionalidades,
        ];

        return view('administratives.edit', $data);
    }

    public function updateAdministrative(Request $request) {
        try {
            //dd($request);
            //exit;
            $this->userRepository->updateAdministrative($request->toArray());

            return back()->with('status', 'Administrativo actualizado con éxito!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function getAdministrativeList(){

        $administrative = $this->userRepository->getAllAdministratives();

        $data = [
            'administratives' => $administrative,
        ];

        return view('administratives.list', $data);
    }  

    public function deleteAdministrative(Request $request) {
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
