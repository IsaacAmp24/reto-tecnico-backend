<?php

namespace App\Http\Queries;

use App\Models\Division;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisionIndexQuery {

    public function build(Request $request): Builder {
        $searchField = $request->query('search_field', 'name');
        $searchText = trim((string) $request->query('search_text', ''));

        $sortField = $request->query('sort_field', 'id');
        $sortOrder = $request->query('sort_order', 'asc');

        $filters = $request->query('filters', []);

        $query = Division::query()
            ->select('divisions.*')
            ->leftJoin('divisions as p', 'divisions.parent_id', '=', 'p.id')
            ->addSelect(DB::raw('p.name as parent_name'))
            ->with('parent:id,name')
            ->withCount('children');

    
            // buscar por columna
            if ($searchText !== '') {
            if ($searchField === 'parent_name') {
                $query->where('p.name', 'like', "%{$searchText}%");
            } elseif ($searchField === 'ambassadors') {
                $query->where('divisions.ambassadors', 'like', "%{$searchText}%");
            } else {
                $query->where('divisions.name', 'like', "%{$searchText}%");
            }

            //filtros por columna (checkbox)
            if (!empty($filters['name']) && is_array($filters['name'])) {
            $query->whereIn('divisions.name', $filters['name']);
            }
            if (!empty($filters['parent_name']) && is_array($filters['parent_name'])) {
                $query->whereIn('p.name', $filters['parent_name']);
            }
            if (!empty($filters['level']) && is_array($filters['level'])) {
                $query->whereIn('divisions.level', array_map('intval', $filters['level']));
            }
            if (!empty($filters['collaborators']) && is_array($filters['collaborators'])) {
                $query->whereIn('divisions.collaborators', array_map('intval', $filters['collaborators']));
            }
            if (!empty($filters['children_count']) && is_array($filters['children_count'])) {
                $query->havingIn('children_count', array_map('intval', $filters['children_count']));
            }

            // orden
            $allowedSort = ['id','name','parent_name','collaborators','level','children_count'];
            if (!in_array($sortField, $allowedSort, true)) $sortField = 'id';
            $sortOrder = $sortOrder === 'desc' ? 'desc' : 'asc';
    
            if ($sortField === 'parent_name') {
                $query->orderBy('p.name', $sortOrder);
            } elseif ($sortField === 'children_count') {
                $query->orderBy('children_count', $sortOrder);
            } else {
                $query->orderBy("divisions.$sortField", $sortOrder);
            }
    
        }

        return $query;
    }
}