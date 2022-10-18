<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\SchoolSessionInterface;
use App\Http\Requests\SchoolSessionStoreRequest;
use App\Http\Requests\SchoolSessionBrowseRequest;

class SchoolSessionController extends Controller
{
    protected $schoolSessionRepository;

    /**
    * Create a new Controller instance
    * 
    * @param SchoolSessionInterface $schoolSessionRepository
    * @return void
    */
    public function __construct(SchoolSessionInterface $schoolSessionRepository) {
        $this->schoolSessionRepository = $schoolSessionRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SchoolSessionStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolSessionStoreRequest $request)
    {
        try {

        $values   = $request->validated();
        $values['school_id'] = auth()->user()->school_id;

        $this->schoolSessionRepository->create($values);

            return back()->with('status', 'Sesión creada con éxito!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
        
    }

    /**
     * Save the selected school session as current session for
     * browsing.
     *
     * @param  SchoolSessionBrowseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function browse(SchoolSessionBrowseRequest $request)
    {
        try {
            $this->schoolSessionRepository->browse($request->validated());

            return back()->with('status', 'Sesión para navegar seleccionada con éxito!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
        
    }
}
