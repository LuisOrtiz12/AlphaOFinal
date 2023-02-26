<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventoResource extends JsonResource
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
            "titulo"=>$this->titulo,
            "descripcion"=>$this->descripcion,
            "imagen"=>$this->imagen,
            "evento"=>$this->evento,
            "cupos"=>$this->cupos,
            "contacto"=>$this->contacto,
        ];
    }
}
