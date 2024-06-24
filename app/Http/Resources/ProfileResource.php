<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $team = Team::findOrFail($this->currentTeam->id);
        return [
            //'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'credits_remaining'=> $team->credits->amount,
            'department'=> new DepartmentResource(Team::findOrFail($this->currentTeam->id)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
