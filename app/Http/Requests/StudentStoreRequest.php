<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document'          => 'required|string',
            'first_name'        => 'required|string',
            'last_name'         => 'required|string',
            'email'             => 'required|string|email|max:255|unique:users',
            'gender'            => 'required|string',
            'nationality'       => 'required|string',
            'phone'             => 'nullable|string',
            'address'           => 'required|string',
            'address2'          => 'nullable|string',
            'city'              => 'required|string',
            'zip'               => 'nullable|string',
            'photo'             => 'nullable|string',
            'birthday'          => 'required|date',
            'religion'          => 'required|string',
            'blood_type'        => 'required|string',
            'password'          => 'required|string|min:8',

            // Parents' information
            'father_document'   => 'required|string',
            'father_name'       => 'required|string',
            'father_last_name'  => 'required|string',
            'father_phone'      => 'nullable|string',
            'father_email'      => 'nullable|string',
            'father_notify'     => 'nullable|string',
            'father_nationality'=> 'nullable|string',
          //  'mother_name'       => 'nullable|string',
          //  'mother_phone'      => 'nullable|string',
          //  'mother_email'      => 'nullable|string',
          //  'mother_notify'     => 'nullable|string',            
          //  'parent_address'    => 'nullable|string',

            // Academic information
            'class_id'          => 'required',
            'section_id'        => 'required',
            'board_reg_no'      => 'nullable|string',
            'session_id'        => 'string',
            'id_card_number'    => 'nullable|string',
        ];
    }
}
