<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JabatanRequest extends FormRequest
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
                        'nama' => 'required|unique:jabatan',
                        'tunjangan_jabatan' => 'required|integer|max:2147483647'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'nama' => ['required', 'unique:jabatan,nama,' . $this->route()->jabatan->id],
                        'tunjangan_jabatan' => 'required|integer|max:2147483647'
                    ];
                }
        }
    }

    public function messages(): array
    {
        return [
            'tunjangan_jabatan.max' => 'Nilai Gaji Pokok tidak boleh melebihi 2,147,483,647.',
        ];
    }
}
