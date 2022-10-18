<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PadreStoreRequest extends FormRequest
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
            'document'      => 'required|string',
            'rol'           => 'required|string',
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => 'required|string|email|max:255|unique:users',
        //    'gender'        => 'nullable|string',
            'nationality'   => 'required|string',
            'phone'         => 'required|string',
        //    'address'       => 'nullable|string',
        //    'address2'      => 'nullable|string',
        //    'city'          => 'nullable|string',
        //    'zip'           => 'nullable|string',
        //    'photo'         => 'nullable|string',
            'password'      => 'nullable|string|min:8',
        ];
    }
}
