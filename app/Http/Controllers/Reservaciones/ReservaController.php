<?php

namespace App\Http\Controllers\Reservaciones;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventoResource;
use App\Http\Resources\ReservaResource;
use App\Models\Evento;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
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
        return $this->sendResponse(message: 'Lista de Eventos desplegadas satisfactoriamente', result: [
            'eventos' => EventoResource::collection($evento),
            
        ]);
    }


    public function indexuser()
    {
        //
        $user=Auth::user();
        $reservas=Reserva::where('user_id',$user->id)->get();
        if(!$reservas->first()){
            return $this->sendResponse(message: 'El Cliente no tiene una reservacion');
        }

        return $this->sendResponse(message: 'Lista de reservaciones desplegadas', result: [
            'reservas' => ReservaResource::collection($reservas),
            
            
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
    public function store(Request $request, Evento $evento)
    {
        //
        $user=Auth::user();
        $reservas=Reserva::where('user_id',$user->id)->get();
        foreach ($reservas as $clave){
            if($clave->eventos_id==$evento->id){
                return $this->sendResponse(message: 'Tu ya tienes una reserva en este evento. Puedes elejir otro evento disponible'); 
               break;
            }
        }
        
        if($evento->cupos==0){
            return $this->sendResponse(message: 'No existe reserva para este evento'); 
        }
       
        $reservacion=new Reserva();
        $num=$evento->cupos;
        $evento->cupos=$evento->cupos-1;
        $reservacion->numero=$num;
        $evento->save();
        $reservacion->eventos_id=$evento->id;
        $user->reserva()->save($reservacion);
        
        return $this->sendResponse(message: 'Reserva generada satisfactoriamente '); 
       
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
        return $this->sendResponse(message: 'Reserva y Evento en Detalle', result: [
            'eventos' => new EventoResource($evento),
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserva $reserva)
    {
        //
        $evento=Evento::where('id',$reserva->eventos_id)->first();
        if($evento->cupos==0){
            return $this->sendResponse(message: 'No existe reservaciones para este evento'); 
        }
        
        $user=Auth::user();
        if(!$user->reserva->first()){
            return $this->sendResponse(message: 'Este usuario no tiene reservas'); 
        }
        
        if($reserva->user_id!=$user->id){
            return $this->sendResponse(message: 'Etsa reserva no es tuya'); 

        }
        $evento->cupos=$evento->cupos+1;
        $evento->save();
        $reserva->delete();
        return $this->sendResponse("Reserva cancelada/eliminada", 200);

    }
    
}
