<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch($this->method()){
            case 'POST': {
                return [
                    'nama' => 'required',
                    'email' => 'required|email|unique:users',
                    'nik' => 'required|unique:users',
                    'jabatan_id' => 'required',
                    'entitas_id' => 'required',
                    'jenis_kelamin' => 'required',
                    'status' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'nama' => 'required',
                    'email' => ['required','email','unique:users,email,' . $this->route()->user->id],
                    'nik' => ['required','unique:users,nik,' . $this->route()->user->id],
                    'jabatan_id' => 'required',
                    'entitas_id' => 'required',
                    'jenis_kelamin' => 'required',
                    'status' => 'required'
                ];
            }
        }
    }
}
