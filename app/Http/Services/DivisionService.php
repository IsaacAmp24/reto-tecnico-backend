<?php

namespace App\Http\Services;

use App\Models\Division;


class DivisionService
{
    public function createDivision(array $data): Division
    {
        return Division::create([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'ambassadors' => $data['ambassadors'] ?? null,

            'level' => random_int(1, 10),
            'collaborators' => random_int(1, 80),
            ]);
    }

    public function updateDivision(Division $division, array $data): Division
    {
        // evitar que una division sea su propia superior
        if (array_key_exists('parent_id', $data) && (int)$data['parent_id'] === $division->id) {
            throw new \InvalidArgumentException('parent_id inválido');
        }

        $division->update($data);
        return $division;
    }

    public function deleteDivision(Division $division): void
    {
        $division->delete();
    }
}