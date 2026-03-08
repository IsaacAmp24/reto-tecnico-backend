<?php

namespace App\Http\Controllers;

use App\Http\Queries\DivisionIndexQuery;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Http\Services\DivisionService;
use App\Models\Division;

use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function __construct(  
        private readonly DivisionService $divisionService,
        private readonly DivisionIndexQuery $divisionIndexQuery,
    )
    {}

    public function index(Request $request){
        $perPage = (int) $request->query('per_page');

        $query = $this->divisionIndexQuery->build($request);
        $result = $query->paginate($perPage);

         return response()->json([
            'data' => $result->items(),
            'meta' => [
                'total' => $result->total(),
                'current_page' => $result->currentPage(),
                'per_page' => $result->perPage(),
            ],
        ]);
    }

    public function store(StoreDivisionRequest $request)
    {
        $division = $this->divisionService->createDivision($request->validated());
        return response()->json($division, 201);
    }

    public function show(Division $division)
    {
        $division->load('parent:id,name')->loadCount('children');
        return response()->json($division);
    }

    public function update(UpdateDivisionRequest $request, Division $division)
    {
        try {
            $division = $this->divisionService->updateDivision($division, $request->validated());
            return response()->json($division);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroy(Division $division)
    {
        $this->divisionService->deleteDivision($division);
        return response()->json(null, 204);
    }

    public function subdivisions(Division $division)
    {
        $children = Division::query()
            ->where('parent_id', $division->id)
            ->with('parent:id,name')
            ->withCount('children')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($children);
    }
}
