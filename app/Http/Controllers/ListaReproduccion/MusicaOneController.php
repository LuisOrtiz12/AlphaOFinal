<?php

namespace App\Http\Controllers\ListaReproduccion;

use App\Http\Controllers\Controller;
use App\Http\Resources\MusicaOneResource;
use App\Models\MusicaOne;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class MusicaOneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $banner=MusicaOne::all();
        return $this->sendResponse(message: 'Lista de Musica Uno desplegada', result: [
            'musics' => MusicaOneResource::collection($banner),
       
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
                'tema' => ['required', 'string', 'min:3', 'max:45'],
                'genero' => ['required', 'string', 'min:3', 'max:200'],
                'descripcion' => ['required', 'string', 'min:3', 'max:500'],
                'duracion' => ['required', 'numeric'],
            ]);

            
            $list1= $request -> validate([
                'audio' => ['required','file','mimes:mp3','max:200000'],
            ]);
            $list2=$request->validate([
                'imagen'=>['required','image','mimes:jpg,png,jpeg', 'max:10000'],
            ]);
            $file = $list1['audio'];
            $file2=$list2['imagen'];
            $uploadedFileUrl = Cloudinary::uploadFile($file->getRealPath(),['folder'=>'listOne']);
            $url = $uploadedFileUrl->getSecurePath();
            $uploadedFileUrl1=Cloudinary::upload($file2->getRealPath(),['folder'=>'AudiosOne']);
            $url1=$uploadedFileUrl1->getSecurePath();
            MusicaOne::create(
                [
                    "tema"=>$request->tema,
                    "genero"=>$request->genero,
                    "descripcion"=>$request->descripcion,
                    "duracion"=>$request->duracion,
                    "imagen"=>$url1,
                    "audio"=>$url,
                ]
            );
            return $this->sendResponse('Musica Uno agregada',204);
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
    public function show(MusicaOne $musicone)
    {
        //
        return $this->sendResponse(message: 'Musica Detalles', result: [
            'musicsOne' => new MusicaOneResource($musicone)
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
    public function update(Request $request, MusicaOne $musicone)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $request->validate([
            'tema' => ['required', 'string', 'min:3', 'max:45'],
            'genero' => ['required', 'string', 'min:3', 'max:200'],
            'descripcion' => ['required', 'string', 'min:3', 'max:500'],
            'duracion' => ['required', 'numeric'],
        ]);

        $list1= $request -> validate([
            'audio' => ['nullable','file','mimes:mp3','max:200000'],
        ]);
        $list2=$request->validate([
            'imagen'=>['nullable','image','mimes:jpg,png,jpeg', 'max:10000'],
        ]);
       
        
        if($request->has('audio')){
        $file = $list1['audio'];
        $uploadedFileUrl = Cloudinary::uploadFile($file->getRealPath(),['folder'=>'listOne']);
        $url = $uploadedFileUrl->getSecurePath();
        $musicone->update([
            "audio"=>$url,
        ]);
        }
        if($request->has('imagen')){
        $file2=$list2['imagen'];
        $uploadedFileUrl1=Cloudinary::upload($file2->getRealPath(),['folder'=>'AudiosOne']);
        $url1=$uploadedFileUrl1->getSecurePath();
        $musicone->update([
            "imagen"=>$url1,
        ]);
        }
        $musicone->update([
            "tema"=>$request->tema,
                "genero"=>$request->genero,
                "descripcion"=>$request->descripcion,
                "duracion"=>$request->duracion,
             
        ]);
        return $this->sendResponse("Musica Uno actualizada", 200);
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
    public function destroy(MusicaOne $musicone)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $musicone->delete();
        return $this->sendResponse("Musica Uno eliminada ", 200);
    }else{
        echo $response->message();
    }
    }
}
