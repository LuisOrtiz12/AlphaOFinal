<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Notifications\ClienteUso;
use App\Notifications\ClienteUsoActivate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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
        //
        $role = Role::where('slug', 'client')->first();
        // Obtener los usuarios en base a la relación
        $users = $role->users;
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Lista de Usuarios Clientes', result: [
            'users' => UserResource::collection($users),
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
    public function destroy(User $user ,Request $request)
    {
        //
        $response = Gate::inspect('gestion-alphao-admin');

        if($response->allowed())
        {   
        // Obtiene el estado del usuario
        $user_state = $user->state;
        // Crear un mensaje en base al estado del usuario
        $message = $user_state ? 'inactivated' : 'activated';
        // Cambiar el estado
        $user->state = !$user_state;
        // Guardar en la BDD
        $user->save();
        // Validamos si existen solicitudes para este tecnico
        if ($user->state == 0) {
            // Validacion de datos de entrada
            $request->validate([
                'observacion' => ['required', 'string', 'min:5', 'max:500']
            ]);
            $userad = Auth::user();
            // Llamamos la notificacion
           
            $this->DesactivateUser($user,$request->observacion, $userad->email, $userad->personal_phone);
        }

        if ($user->state == 1) {
            // Validacion de datos de entrada
            $request->validate([
                'observacion' => ['required', 'string', 'min:5', 'max:500']
            ]);
            $userad = Auth::user();
            // Llamamos la notificacion
           
            $this->ActivateUser($user,$request->observacion, $userad->email, $userad->personal_phone);
        }
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: "Usuario $message satisfactoriamente");
    }else{
        echo $response->message();
    }
    }

     // Función para notificar el tecnico que ha sido
     private function DesactivateUser(User $user,string $observacion, string $email_admin, int $number_admin)
     {
         $user->notify(
             new ClienteUso(
                 user_name: $user->getFullName(),
                 role_name:$user->role->name,
                 observacion:$observacion,
                 email_admin: $email_admin,
                 number_admin: $number_admin
             )
         );
     }
 
     private function ActivateUser(User $user,string $observacion, string $email_admin, int $number_admin)
     {
         $user->notify(
             new ClienteUsoActivate(
                 user_name: $user->getFullName(),
                 role_name:$user->role->name,
                 observacion:$observacion,
                 email_admin: $email_admin,
                 number_admin: $number_admin
             )
         );
     }
     
}
