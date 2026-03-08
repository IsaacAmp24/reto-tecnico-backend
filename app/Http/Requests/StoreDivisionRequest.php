<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Request para validar la creación de una nueva división
class StoreDivisionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:45|unique:divisions,name',
            'parent_id' => 'nullable|exists:divisions,id',
            'ambassadors' => 'nullable|string|max:120',
        ];
    }
}
