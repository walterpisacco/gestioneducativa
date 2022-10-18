<?php

namespace App\Repositories;

use App\Models\School;

class SchoolRepository {

    public function create($request) {
        try {
            $school = School::create($request);
            return $school->id;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create School. '.$e->getMessage());
        }
    }

    public function getAll() {
        return School::
            where('deleted_at', null)
            ->orderBy('name','ASC')
            ->get();
    }

}