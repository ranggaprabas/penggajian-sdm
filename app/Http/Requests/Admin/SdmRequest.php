<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SdmRequest extends FormRequest
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
                        'email' => 'required|email',
                        'nik' => 'required',
                        'jabatan_id' => 'required',
                        'entitas_id' => 'required',
                        'divisi_id' => 'required',
                        'jenis_kelamin' => 'required',
                        'status' => 'required',
                        'chat_id' => 'required'
  
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'nama' => 'required',
                        'email' => 'required|email',
                        'nik' => 'required',
                        'jabatan_id' => 'required',
                        'entitas_id' => 'required',
                        'divisi_id' => 'required',
                        'jenis_kelamin' => 'required',
                        'status' => 'required',
                        'chat_id' => 'required'
                    ];
                }
        }
    }
}
