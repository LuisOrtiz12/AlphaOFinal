<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\ReferenciaBannerResource;
use App\Models\Banner;
use App\Models\Evento;
use App\Models\Publicidad;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $banner=Banner::all();
        return $this->sendResponse(message: 'Lista de banners deplegados satisfactoriamente', result: [
            'banners' => BannerResource::collection($banner),
        ]);
    }



    public function indexnuevo()
    {
        $publicidad=Publicidad::all();
        $evento=Evento::all();
        $bannertotal=$publicidad->concat($evento);

        return $this->sendResponse(message: 'Lista de banners deplegados satisfactoriamente', result: [
            'banners' => ReferenciaBannerResource::collection($bannertotal),
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
          // Validación de los datos de entrada
         // Crear un array asociativo de clave y valor
         $response = Gate::inspect('gestion-alphao-admin');

         if($response->allowed())
         {   
        $request ->validate((['nombrebanner'=>['required','string','min:5', 'max:50']]));
        $img=$request -> validate([
            //'nombre' => ['required', 'string', 'min:5', 'max:50'],
            'fotografias' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:10000']
            // https://laravel.com/docs/9.x/validation#rule-alpha-dash
        
           
        ]);
        $file = $img['fotografias'];
        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(),['folder'=>'fotografias']);
        $url = $uploadedFileUrl->getSecurePath();
    
        Banner::create(
            [ 
                "fotografias"=>$url,
                "nombrebanner"=>$request->nombrebanner,
             ]
         );
        // https://laravel.com/docs/9.x/eloquent#inserts
       
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Banner agregado satisfactoriamente');
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
    public function show($id)
    {
        //
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
    public function destroy(Banner $banner)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        $banner->delete();

        return $this->sendResponse(message: 'Banner eliminado satisfactoriamente');
    }else{
        echo $response->message();
    }
    }
}
