<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DivisiRequest extends FormRequest
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
                    'nama' => 'required|unique:divisis,nama,NULL,id,entitas_id,' . auth()->user()->entitas_id,
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'nama' => [
                        'required',
                        'unique:divisis,nama,' . $this->route()->divisi->id . ',id,entitas_id,' . auth()->user()->entitas_id,
                    ],
                ];
            }
        }
    }
    
    public function messages(): array
    {
        return [
            'nama.unique' => 'Nama Divisi sudah ada di entitas Anda.',
        ];
    }
    }
