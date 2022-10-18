<?php

namespace App\Repositories;

use App\Interfaces\SemesterInterface;
use App\Models\Semester;
use App\Models\SchoolSession;

class SemesterRepository implements SemesterInterface {
    public function create($request) {
        try {
            $semestre = Semester::create($request);
            return $semestre->id;
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar crear el semestre. '.$e->getMessage());
        }
    }

    public function getAll($session_id)
    {
        return Semester::
            where('session_id', $session_id)
            ->orderBy('start_date', 'asc')
            ->get();
    }
}