<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VercomentarioResource extends JsonResource
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
            "id"=>$this->id,
            "state"=>$this->state,
            "numero"=>$this->numero,
            "dsfs"=>$this->eventos_id,
            'creadoby' => new ProfileResource($this->user),
            //'evento'=>new EventoResource($this->eventos),

        ];
    }
}
