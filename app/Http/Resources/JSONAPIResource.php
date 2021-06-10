<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JSONAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'type' => $this->type(),
            'attributes' => $this->allowedAttributes(),
            'relationships' => $this->prepareRelationships(),
        ];
    }

    private function prepareRelationships(){
        $collection = collect(config("jsonapi.resources.{$this->type()}.relationships"))->flatMap(function($related){
            $relatedType = $related['type'];
            $relationship = $related['method'];
            $modelName = Str::singular($this->type());
            
            return [
                $relatedType => [
                    'links' => [
                        'self'    => route(
                            "{$this->type()}.relationships",
                            [
                                $modelName.'Uuid' => $this->id,
                                'relationship' => $relatedType
                            ]
                            
                        ),
                        'related' => route(
                            "{$this->type()}.related",
                            [
                                $modelName.'Uuid' => $this->id,
                                'relationship' => $relatedType
                            ]
                        ),
                    ],
                    'data' => $this->prepareRelationshipData($relatedType, $relationship),
                ],
            ];
        });

        return $collection->count() > 0 ? $collection : new MissingValue();
    }

    private function prepareRelationshipData($relatedType, $relationship){
        if($this->whenLoaded($relationship) instanceof MissingValue){
            return new MissingValue();
        }

        if($this->$relationship() instanceof BelongsTo){
            return new JSONAPIIdentifierResource($this->$relationship);
        }

        return JSONAPIIdentifierResource::collection($this->$relationship);
    }

    public function with($request)
    {
        $with = [];
        if ($this->included($request)->isNotEmpty()) {
            $with['included'] = $this->included($request);
        }

        return $with;
    }

    public function included($request)
    {
        return collect($this->relations())
            ->filter(function ($resource) {
                return $resource->collection !== null;
            })->flatMap->toArray($request);
    }

    private function relations()
    {
        return collect(config("jsonapi.resources.{$this->type()}.relationships"))->map(function($relation){
            $modelOrCollection = $this->whenLoaded($relation['method']);

            if($modelOrCollection instanceof Model){
                $modelOrCollection = collect([new JSONAPIResource($modelOrCollection)]);
            }

            return JSONAPIResource::collection($modelOrCollection);
        });
    }
}
