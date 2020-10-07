<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->task_id_public,
            'title' => $this->title,
            'description' => $this->description,
            'user_id'=> $this->user->user_id_public
        ];
    }
}
