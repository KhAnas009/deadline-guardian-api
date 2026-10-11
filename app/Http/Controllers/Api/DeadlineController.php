<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deadline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $deadlines = $request->user()->deadlines()->get();

        return response()->json($deadlines,200);
    }

     public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'due_date' => ['required', 'date_format:Y-m-d'],
            'priority' => ['sometimes', 'in:low,medium,high'],
            'status' => ['sometimes', 'in:pending,completed'],
        ]);

        $deadline = $request->user()
            ->deadlines()
            ->create($validated);

        return response()->json($deadline, 201);
    }

      public function update(Request $request, int $id): JsonResponse
    {
        $deadline = $request->user()
            ->deadlines()
            ->findOrFail($id);

        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'category' => ['sometimes', 'required', 'string', 'max:100'],
            'due_date' => ['sometimes', 'required', 'date_format:Y-m-d'],
            'priority' => ['sometimes', 'in:low,medium,high'],
            'status' => ['sometimes', 'in:pending,completed'],
        ]);

        $deadline->update($validated);

        return response()->json($deadline);
    }

    // Supprimer une deadline appartenant à l'utilisateur connecté
    public function destroy(Request $request, int $id): JsonResponse
    {
        $deadline = $request->user()
            ->deadlines()
            ->findOrFail($id);

        $deadline->delete();

        return response()->json([
            'message' => 'Deadline deleted successfully',
        ]);
    }
}