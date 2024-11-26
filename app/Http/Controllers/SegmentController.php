<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSegmentRequest;
use App\Http\Requests\UpdateSegmentRequest;
use App\Models\Segment;
use App\Services\SegmentService;
use Illuminate\Http\JsonResponse;

class SegmentController extends Controller
{
    public function __construct(protected SegmentService $segmentService) {}

    public function index(): JsonResponse
    {
        $segment = $this->segmentService->list();

        return response()->json($segment);
    }

    public function store(StoreSegmentRequest $request): JsonResponse
    {
        $segment = $this->segmentService->store($request);

        return response()->json($segment);
    }

    public function show(Segment $segment): JsonResponse
    {
        return response()->json($segment);
    }

    public function update(UpdateSegmentRequest $request, Segment $segment): JsonResponse
    {
        $segment = $this->segmentService->update($request, $segment);

        return response()->json($segment);
    }

    public function destroy(Segment $segment): JsonResponse
    {
        $this->segmentService->destroy($segment);

        return response()->json(['message' => 'Segment deleted']);
    }
}
