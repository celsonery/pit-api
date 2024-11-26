<?php

namespace App\Services;

use App\Http\Requests\StoreSegmentRequest;
use App\Http\Requests\UpdateSegmentRequest;
use App\Models\Segment;

class SegmentService
{
    public function list()
    {
        return Segment::select(['id', 'name'])
            ->paginate();
    }

    public function store(StoreSegmentRequest $segment)
    {
        return Segment::create($segment->validated());
    }

    public function update(UpdateSegmentRequest $request, Segment $segment)
    {
        $segment->update($request->validated());

        return $segment;
    }

    public function destroy(Segment $segment)
    {
        return $segment->delete();
    }
}
