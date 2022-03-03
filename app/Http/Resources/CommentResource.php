<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'content' => $this->content,
            'User' => new UserResource($this->User),
            'Recipe' => new RecipeResource($this->Recipe),
            'Replies' => CommentResource::collection($this->Replies->where('approved', Comment::DB_TRUE)),
            'created_at' => $this->created_at->format('jS M H:i'),
        ];
    }
}
