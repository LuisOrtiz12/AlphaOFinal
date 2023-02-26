<?php

namespace App\Http\Controllers\Publicidad;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublicidadResource;
use App\Models\Publicidad;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class PublicidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $publicidad=Publicidad::all();
        return $this->sendResponse(message: 'Publish list generated successfully', result: [
            'publ' => PublicidadResource::collection($publicidad),
       
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
            
        ]);

        $publicidad= $request -> validate([
            'imagen' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
              
        ]);
        $time=$request->evento;
        $file = $publicidad['imagen'];
        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(),['folder'=>'publicidad']);
        $url = $uploadedFileUrl->getSecurePath(); 
        if($time<$mytime){
            return $this->sendResponse(message: 'La publicidad debe ser de la fecha actual en adelante'); 
        }
         Publicidad::create([
            "titulo"=>$request->titulo,
            "imagen"=>$url,
            "descripcion"=>$request->descripcion,
            "evento"=>$request->evento

         ]);
       
         return $this->sendResponse('Publicidad creado satisfactoriamente',204);
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
    public function show(Publicidad $publicidad)
    {
        //
        return $this->sendResponse(message: 'Publish details', result: [
            'publ' => new PublicidadResource($publicidad)
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
    public function update(Request $request, Publicidad $publicidad)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $request->validate([
            'titulo' => ['required', 'string', 'min:3', 'max:45'],
            'descripcion' => ['required', 'string', 'min:3', 'max:600'],
            'evento' => ['required', 'date'],
            
        ]);

        $publi= $request -> validate([
            'imagen' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
              
        ]);
        if($request->has('imagen')){
        $file = $publi['imagen'];
        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(),['folder'=>'publicidad']);
        $url = $uploadedFileUrl->getSecurePath();
        $publicidad->update([
            "imagen"=>$url,
        ]);    
    } 

         $publicidad->update([
            "titulo"=>$request->titulo,
            "descripcion"=>$request->descripcion,
            "evento"=>$request->evento

         ]);
         return $this->sendResponse('Publicidad actualizado satisfactoriamente',204);
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
    public function destroy(Publicidad $publicidad)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $publicidad->delete();
        return $this->sendResponse("Publicidad eliminada satisfactoriamentes", 200);
    }else{
        echo $response->message();
    }
    }
}
