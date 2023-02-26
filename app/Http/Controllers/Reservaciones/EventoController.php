<?php

namespace App\Http\Controllers\Reservaciones;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventoResource;
use App\Http\Resources\VercomentarioResource;
use App\Models\Evento;
use App\Models\Reserva;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $evento=Evento::all();
        return $this->sendResponse(message: 'Lista de Eventos desplegado', result: [
            'eventos' => EventoResource::collection($evento),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $mytime=Carbon::now();
        
        $request->validate([
            'titulo' => ['required', 'string', 'min:3', 'max:45'],
            'descripcion' => ['required', 'string', 'min:3', 'max:600'],
            'evento' => ['required', 'date'],
            'contacto' => ['required', 'numeric', 'digits:10'],
            'cupos' => ['required', 'numeric'],
        ]);
        $evento= $request -> validate([
            'imagen' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
              
        ]);
        $time=$request->evento;
        $file = $evento['imagen'];
        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(),['folder'=>'evento']);
        $url = $uploadedFileUrl->getSecurePath(); 

        if($time<$mytime){
            return $this->sendResponse(message: 'El Evento debe ser de la fecha actual en adelante'); 
        }

         Evento::create([
            "titulo"=>$request->titulo,
            "imagen"=>$url,
            "descripcion"=>$request->descripcion,
            "evento"=>$request->evento,
            "contacto"=>$request->contacto,
            "cupos"=>$request->cupos

         ]);
         return $this->sendResponse('Evento creado satisfactoriamente',204);
        }else{
            echo $response->message();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //
        $reserva=Reserva::where('eventos_id',$evento->id)->get();
        return $this->sendResponse(message: 'Evento y Reservacion en Detalle', result: [
            'eventos' => new EventoResource($evento),
            'reservaciones'=> VercomentarioResource::collection($reserva)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $eventoup)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   

        $request->validate([
            'titulo' => ['required', 'string', 'min:3', 'max:45'],
            'descripcion' => ['required', 'string', 'min:3', 'max:600'],
            'evento' => ['required', 'date'],
            'contacto' => ['required', 'numeric', 'digits:10'],
            'cupos' => ['required', 'numeric'],
        ]);
        $evento= $request -> validate([
            'imagen' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
              
        ]);
        if($request->has('imagen')){
        $file = $evento['imagen'];
        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(),['folder'=>'evento']);
        $url = $uploadedFileUrl->getSecurePath(); 
        $eventoup->update([
            "imagen"=>$url,
        ]);
    }
         $eventoup->update([
            "titulo"=>$request->titulo,
            "descripcion"=>$request->descripcion,
            "evento"=>$request->evento,
            "contacto"=>$request->contacto,
            "cupos"=>$request->cupos

         ]);
         return $this->sendResponse('Evento Actualizado',204);
        }else{
            echo $response->message();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $evento->delete();
        return $this->sendResponse("Evento Eliminado", 200);
    }else{
        echo $response->message();
    }
    }
    
}
