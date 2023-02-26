<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MusicaOneResource extends JsonResource
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
            'id'=>$this->id,
            'tema' => $this->tema,
            'genero' => $this->genero,
            'descripcion'=>$this->descripcion,
            'duracion'=>$this->duracion,
            'imagen'=>$this->imagen,
            'audio' => $this->audio,
        ];
    }
}
