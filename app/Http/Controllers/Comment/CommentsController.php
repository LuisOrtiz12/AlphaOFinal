<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComentariosResource;
use App\Models\Comentarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {
        $comments=Comentarios::all();
        return $this->sendResponse(message: 'Lista de comentarios de usuarios satisfacotriamente', result: [
            'comments' => ComentariosResource::collection($comments),
        ]);
    }else{
        echo $response->message();
    }
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexpublico()
    {
        //
        $comments=Comentarios::all();
        return $this->sendResponse(message: 'Lista de comentarios de usuarios satisfacotriamente', result: [
            'comments' => ComentariosResource::collection($comments),
        ]);
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
        $comments= $request -> validate([
            'comentario' => ['required', 'string', 'min:3', 'max:455'],
            'calificacion' => ['required', 'numeric'],
            
        ]);
        $user=Auth::user();
        $comments= new Comentarios($request->all());
        $user->comentario()->save($comments);
         
         return $this->sendResponse('Comentario creado satisfactoriamente',204);
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
    public function destroy(Comentarios $user)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {
        $user->delete();
        return $this->sendResponse('Comentario eliminado satisfactoriamente',204);
    }else{
        echo $response->message();
    }
    }
}
