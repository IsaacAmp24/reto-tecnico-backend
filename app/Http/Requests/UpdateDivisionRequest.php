<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDivisionRequest extends FormRequest
{
    public function rules(): array
    {
        $divisionId = $this->route('division')->id;

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:45',
                Rule::unique('divisions', 'name')->ignore($divisionId)
            ],

            'parent_id' => [
                'nullable',
                'exists:divisions,id',
                'integer',
                function ($attribute, $value, $fail) use ($divisionId) {
                    if ($value == $divisionId) {
                        $fail('El parent_id no puede ser igual al id de la división que se está actualizando.');
                    }
                },
            ],

            'ambassadors' => [
                'nullable',
                'string',
                'max:120',
            ]
        ];
    }
}
