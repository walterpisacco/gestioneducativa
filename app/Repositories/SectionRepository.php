<?php

namespace App\Repositories;

use App\Models\Section;
use App\Interfaces\SectionInterface;

class SectionRepository implements SectionInterface {
    public function create($request) {
        try {
            $section = Section::create($request);
            return $section->id;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create School Section. '.$e->getMessage());
        }
    }

    public function getAllBySession($session_id) {
        return Section::where('session_id', $session_id)->orderBy('class_id','ASC')->get();
    }

    public function getAllByClassId($class_id) {
        return Section::where('class_id', $class_id)->get();
    }

    public function findById($section_id) {
        return Section::find($section_id);
    }

    public function update($request) {
        try {
            Section::find($request->section_id)->update([
                'section_name'  => $request->section_name,
                'room_no'       => $request->room_no,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Error al intentar crear la sección. '.$e->getMessage());
        }
    }
}