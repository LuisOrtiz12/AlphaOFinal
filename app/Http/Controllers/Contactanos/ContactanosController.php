<?php

namespace App\Http\Controllers\Contactanos;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactanosResource;
use App\Models\Contactanos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContactanosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contacto=Contactanos::all();
        return $this->sendResponse(message: 'Lista de Contactos agregado satisfacotiramente', result: [
            'contactanos' => ContactanosResource::collection($contacto),
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
       $contactos= $request -> validate([
            'nombre' => ['required', 'string', 'min:3', 'max:45'],
            'apellido' => ['required', 'string', 'min:3', 'max:45'],
            'correo' => ['required', 'string', 'min:5', 'max:30', 'unique:contactanos'],
            'puesto' => ['required', 'string', 'min:5', 'max:100'],
            'contactanos' => ['required', 'numeric', 'digits:10'],
            
        ]);
         
         Contactanos::create($contactos);
         return $this->sendResponse('Contacto creado satisfactoriamente',204);
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
    public function show(Contactanos $contactanos)
    {
        //
        return $this->sendResponse(message: 'Detalles del contacto', result: [
            'contactanos' => new ContactanosResource($contactanos)
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
    public function update(Request $request, Contactanos $contactanos)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $data=$request -> validate([
            'nombre' => ['required', 'string', 'min:3', 'max:45'],
            'apellido' => ['required', 'string', 'min:3', 'max:45'],
            'correo' => ['required', 'string', 'min:5', 'max:30' ],
            'puesto' => ['required', 'string', 'min:5', 'max:100'],
            'contactanos' => ['required', 'numeric', 'digits:10'],
        ]);
        $contactanos->fill($data);
        $contactanos->save();
        return $this->sendResponse('Contacto actualizado satisfactoriamente',200);
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
    public function destroy(Contactanos $contactanos)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $contactanos->delete();
        return $this->sendResponse("Contacto eliminado satisfactoriamente", 200);
    }else{
        echo $response->message();
    }
    }
    
}
