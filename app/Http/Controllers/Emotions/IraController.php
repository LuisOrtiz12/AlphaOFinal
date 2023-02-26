<?php

namespace App\Http\Controllers\Emotions;

use App\Http\Controllers\Controller;
use App\Http\Resources\IraResource;
use App\Http\Resources\MusicaOneResource;
use App\Models\Ira;
use App\Models\MusicaOne;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class IraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ira=Ira::all();
        return $this->sendResponse(message: 'Lista de Emocion Ira desplegada', result: [
            'emociones' => IraResource::collection($ira),
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
        $request->validate([
            'Tema' => ['required', 'string', 'min:3', 'max:45'],
            'descripcion' => ['required', 'string', 'min:3', 'max:600'],
            
        ]);

        $ira= $request ->validate([
            'video' => ['file'],
        ]);
        $file = $ira['video'];
        $uploadedFileUrl = Cloudinary::uploadVideo($file->getRealPath(),['folder'=>'emotions']);
        $url = $uploadedFileUrl->getSecurePath();
      
      
         Ira::create(
            [
                "Tema"=>$request->Tema,
                "descripcion"=>$request->descripcion,
                "video"=>$url
            ]
         );
         return $this->sendResponse('Emocion Ira agregada',204);
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
    public function show(Ira $ira)
    {
        //
        $musica=MusicaOne::all();
        return $this->sendResponse(message: 'Detalle de Emocion Ira', result: [
            'iras' => new IraResource($ira),
            'music'=> MusicaOneResource::collection( $musica),

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
    public function update(Request $request, Ira $emotion)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $request->validate([
            'Tema' => ['required', 'string', 'min:3', 'max:45'],
            'descripcion' => ['required', 'string', 'min:3', 'max:600'],
            
        ]);

        $ira= $request -> validate([
            'video' => ['nullable','file','mimes:mp4','max:200000'],
        ]);
        if($request->has('video')){
        $file = $ira['video'];
        $uploadedFileUrl = Cloudinary::uploadVideo($file->getRealPath(),['folder'=>'emotions']);
        $url = $uploadedFileUrl->getSecurePath();
        $emotion->update([
            "video"=>$url,
         ]);
        }
         $emotion->update([
            "Tema"=>$request->Tema,
            "descripcion"=>$request->descripcion,
            
         ]);
         return $this->sendResponse('Emocion Ira Actualizada',200);
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
    public function destroy(Ira $ira)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $ira->delete();
        return $this->sendResponse("Emocion Ira eliminada", 200);
    }else{
        echo $response->message();
    }
    }
    
}
