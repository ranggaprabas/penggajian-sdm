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
                        'gaji_pokok' => 'required|integer|max:2147483647',
                        'transportasi' => 'required|integer|max:2147483647',
                        'uang_makan' => 'required|integer|max:2147483647'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'nama' => ['required', 'unique:jabatan,nama,' . $this->route()->jabatan->id],
                        'gaji_pokok' => 'required|integer|max:2147483647',
                        'transportasi' => 'required|integer|max:2147483647',
                        'uang_makan' => 'required|integer|max:2147483647'
                    ];
                }
        }
    }

    public function messages(): array
    {
        return [
            'gaji_pokok.max' => 'Nilai Gaji Pokok tidak boleh melebihi 2,147,483,647.',
            'transportasi.max' => 'Nilai Transportasi tidak boleh melebihi 2,147,483,647.',
            'uang_makan.max' => 'Nilai Uang Makan tidak boleh melebihi 2,147,483,647.',
        ];
    }
}
