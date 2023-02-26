<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferenciaBannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->cupos==null){
            $tipo='publicidad';
        }else{
            $tipo='evento';
        };

           
        return [
            'id' => $this->id,
            'imagen' => $this->imagen,
            'tipo'=>$tipo
        ]  ;
     }
    
}
