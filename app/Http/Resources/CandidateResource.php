<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'education' => $this->education,
            'birthday' => $this->birthday,
            'experience' => $this->experience,
            'last_position' => $this->last_position,
            'applied_position' => $this->applied_position,
            'skills' => $this->skills,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
