<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'featured_image' => $this->featured_image,
            'additional_images' => $this->additional_images,
            'type' => $this->type,
            'preparation_time' => $this->preparation_time,
            'preparation_level' => $this->preparation_level,
            'ingredients' => $this->ingredients,
            'User' => new UserResource($this->whenLoaded('User')),
            'average_rating' => isset($this->average_rating) ? $this->average_rating : '',
            'approved' => $this->approved,
            'Comments' => CommentResource::collection($this->whenLoaded('Comments', function() {
                return $this->Comments->where('approved', Recipe::DB_TRUE);
            })),
            'Reviews' => ReviewResource::collection($this->whenLoaded('Reviews', function () {
                return $this->Reviews->where('approved', Recipe::DB_TRUE);
            }))
        ];
    }
}
