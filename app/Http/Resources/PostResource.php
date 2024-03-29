<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'imgPath' => $this->imgPath,
            'createdAt' => $this->created_at,
            // user() => error
            'user' => new UserResource($this->user),
            'reactions' => ReactionResource::collection($this->reactions),
            'comments' => CommentResource::collection($this->comments)
        ];
    }
}
