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
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'nama' => 'required',
                        'email' => 'required|email|unique:users',
                        'jenis_kelamin' => 'required',
                        'status' => 'required',
                        'entitas_id' => 'required',
                        'password' => 'required|min:3|confirmed',
  
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'nama' => 'required',
                        'email' => ['required', 'email', 'unique:users,email,' . $this->route()->user->id],
                        'jenis_kelamin' => 'required',
                        'status' => 'required',
                        'entitas_id' => 'required',
                        'password' => 'nullable|min:3|confirmed',
 
                    ];
                }
        }
    }
}
