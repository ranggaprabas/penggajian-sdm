<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EntitasRequest extends FormRequest
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
                    'nama' => 'required|unique:entitas',
                    'alamat' => 'required',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'nama' => ['required', 'unique:entitas,nama,' . $this->route()->entita->id],
                    'alamat' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ];
            }
        }
    }}
