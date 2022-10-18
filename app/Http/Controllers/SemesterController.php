<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Interfaces\SemesterInterface;
use App\Http\Requests\SemesterStoreRequest;
use App\Traits\SchoolSession;
use App\Interfaces\SchoolSessionInterface;

class SemesterController extends Controller
{
    use SchoolSession;
    protected $semesterRepository;

    public function __construct(SemesterInterface $semesterRepository,SchoolSessionInterface $schoolSessionRepository) {
        $this->semesterRepository = $semesterRepository;
        $this->schoolSessionRepository = $schoolSessionRepository;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  SemesterStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SemesterStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['session_id'] =  $this->getSchoolCurrentSession();
            $id = $this->semesterRepository->create($data);

            $result = array();
            $result['success']  = 'true';
            $result['id']       =  $id;
            $result['texto']    = 'Semestre creado con éxito!';
            
            return json_encode($result);

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }
}
