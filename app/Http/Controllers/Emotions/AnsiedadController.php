<?php

namespace App\Http\Controllers\Emotions;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnsiedadResource;
use App\Http\Resources\MusicaFiveResource;
use App\Models\Ansiedad;
use App\Models\MusicaFive;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class AnsiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ansiedad=Ansiedad::all();
        return $this->sendResponse(message: 'Lista de Emociones Ansiedad desplegado', result: [
            'emociones' => AnsiedadResource::collection($ansiedad),
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

        $ansiedad= $request ->validate([
            'video' => ['file'],
        ]);
        $file = $ansiedad['video'];
        $uploadedFileUrl = Cloudinary::uploadVideo($file->getRealPath(),['folder'=>'emotions']);
        $url = $uploadedFileUrl->getSecurePath();
       
      
         Ansiedad::create(
            [
                "Tema"=>$request->Tema,
                "descripcion"=>$request->descripcion,
                "video"=>$url
            ]
         );
         return $this->sendResponse('Emocion Ansiedad agregada',204);
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
    public function show(Ansiedad $ansiedad)
    {
        //
        $banner=MusicaFive::all();
        return $this->sendResponse(message: 'Detalles de Emocion Ansiedad', result: [
            'iras' => new AnsiedadResource($ansiedad),
            'music'=> MusicaFiveResource::collection( $banner),
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
    public function update(Request $request, Ansiedad $ansiedad)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {  
        $request->validate([
            'Tema' => ['required', 'string', 'min:3', 'max:45'],
            'descripcion' => ['required', 'string', 'min:3', 'max:600'],
            
        ]);

        $ans= $request -> validate([
            'video' => ['nullable','file','mimes:mp4','max:200000'],
        ]);
        if($request->has('video')){
        $file = $ans['video'];
        $uploadedFileUrl = Cloudinary::uploadVideo($file->getRealPath(),['folder'=>'emotions']);
        $url = $uploadedFileUrl->getSecurePath();
         $ansiedad->update([
            "video"=>$url,
         ]);
        }
         $ansiedad->update([
            "Tema"=>$request->Tema,
            "descripcion"=>$request->descripcion,
            
         ]);
         return $this->sendResponse('Emocion Ansiedad actualizada',200);
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
    public function destroy(Ansiedad $ansiedad)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $ansiedad->delete();
        return $this->sendResponse("Emocion Ansiedad eliminada", 200);
    }else{
        echo $response->message();
    }
    }
    
}
