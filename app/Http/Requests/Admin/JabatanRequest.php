<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
        // Aturan validasi untuk membuat (CREATE)
        $createRules = [
            'nama' => 'required',
            'tunjangan_jabatan' => 'required|integer|max:2147483647',
        ];
    
        // Aturan validasi untuk memperbarui (UPDATE)
        $updateRules = [
            'nama' => 'required',
            'tunjangan_jabatan' => 'required|integer|max:2147483647',
        ];
    
        // Gabungkan aturan validasi berdasarkan metode HTTP
        switch ($this->method()) {
            case 'POST': {
                    return $createRules;
                }
            case 'PUT':
            case 'PATCH': {
                    return $updateRules;
                }
        }
    }
    
    public function messages(): array
    {
        return [
            'tunjangan_jabatan.max' => 'Nilai Tunjangan Jabatan melebihi batas max.',
        ];
    }
    }
