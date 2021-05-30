<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class JSONAPICollection extends ResourceCollection
{
    public $collects = JSONAPIResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'included' => $this->mergeIncludedRelations($request),
        ];
    }

    private function mergeIncludedRelations(Request $request)
    {
        $includes = $this->collection->flatMap->included($request)->unique()->values();
        return $includes->isNotEmpty() ? $includes : new MissingValue();
    }
}
