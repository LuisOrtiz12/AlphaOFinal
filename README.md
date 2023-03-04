# Desarrollo de una API de la aplicacion AlphaO.
![image](https://user-images.githubusercontent.com/126093125/222187799-98288f84-6f81-4114-a3d7-88807cd74ee1.png)

Este documento define los pasos mas importantes que se ha desarrollado para la aplicacion AlphaO de la Escuela de Biodanza SRT-Puembo
## Comandos necesarios con el framework Laravel
* php artisan serve
* php artisan migrate
* php artisan make:model Model -mfs
* php artisan make:controller -r NombreController  
## Creacion de Login
### Esta funcion ayuda con la autorizacion de las credencialesde un usuario donde se requerira dos parametros: email y password. Debemos saber que un esta funciones dependen de las cuaidades de las tablas que tenemos nuestra base de datos. Vamos a decir que se obtenga al usuario cuando corresponda al primer email de la base de datos donde si ese usuario no existe o no tenga un estado o no ha sido comprobado su contraseña que envie el mensaje de credenciales no existentes. Esto es fundamental cuando un administrador quiere inhabilitar una cuenta cliente.
```
 public function login(Request $request)
    {
        $request -> validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request['email'])->first();

      
        if (!$user || !$user->state || in_array($user->role->slug, $this->discarded_role_names) ||
            !Hash::check($request['password'], $user->password))
            {
                return $this->sendResponse(message: 'Credenciales obtenidas incorrectas.', code: 404);
            }
      
        if (!$user->tokens->isEmpty())
        {
            $user->tokens()->delete();
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->sendResponse(message: 'Bienvenido usuario.', result: [
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
```
NO LO OLVIDES: Toda funcion o endpoint de un modelo es siempre trabajar con las propiedades de  nuestra tabla de datos.
## Creacion de Cerrar Sesion
### Esta funcion ayudara a que al momento de salir de nuestra sesion el token Bearer sea eliimnado. Esto es fundamental para que no se mantenga la sesion abierta o perdida en nuestra aplicacion.
```
  public function logout(Request $request)
    {
        
        $request->user()->tokens()->delete();

        return $this->sendResponse(message: 'Sesion Finalizada.');
    }


```
## Creacion de Crear Eventos
### Esta funcion nos ayuda para crear los eventos. Vamos a entenderlo. Esta funcion tendra un a restriccion porque un usuario tendra dos roles "administrador y cliente" entonces verificara que esta funcion debe ser usado solo para administradores. Gate es son puertas de autorizcion donde permite si este usuario esta autorizado a ejecutarlo. La libreria carbon es muy util porque nos ayuda a la obtencion de fechas en tiempo real. Utilizaremos el Request para poder capturar elementos que el usuario digitara y con validate vamos es a validar a que sea el formato que debe umplir en la escritura. CLouridnary nos ayudara con la modalida de alamcernar los archivos tipo imagen con upload y podremos obtener su url hhttps para poder alamcenarlo en nuestra base de datos. Evento::create ayudara a usar todos los parametros que se digitaran "request" y se enviara a que columan de nuestar base de datos se alamcenara su contenido. Facil cierto. Ahora ya entendemos como crear un evento.
```
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
```
## Creacion de Reservas
### Esta funcion nos ayudara a crear una reservacion de un usuario donde Auth nos ayuda con los accesos de la persoan que esta en autenticacion. Se utiliza el modelo de Reservas para obtener toda la informacion que contiene ese usuario en la reservaciones que ha realizado. Utilizaremos un foreach para recorrer toda la informacion de sus reservas y si el evento que va a reservar es igual al que ya tiene. Pues ya sabemos lo negara porque ya tiene esa reservacion hecha. tambien podmeos ver una condicional si los cupos estan agotados. Si todo marcha bien pues vamos a crear una nueva Reserva donde al momento de realizarlos los cupos seran disminuido y la relacion de esa reservacion con el usuario sera registrado en la base de datos.
```
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
```
## Creacion de Gestion de Usuarios Clientes
### Esta funcion destroy es muy especial porque nos ayudara a cambiar el estado del usuario para poder inhabilitar o habilitarlo. Ademas nos ayuda tambien a enviar una notificacion por la cual razon fue habilitado deshabilitado. Si nos acordamos la funcion login tiene una condicional acerca de su estado donde si es cambiado mandara un mensaje de "Credenciales no identificadas" es porque deshabilitamos al usuario del sistema. Como si no existiera". Igualmente se usa un Gate porque esta funcion solo es para administradores. Asi que ya sabemos como dehabilitar o habilitar. 
```
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
```
## Funcion de enviar notificacion de Habilitacion o Deshabilitacion

### Estas dos fucniones Desactivateuser y ActivateUser ayudara a enviar unanotiicacion al ususario que vamos a habilitar o deshabilitar su cuenta. Tener en cuneta que se debe usar funciones de email de Laravel para poder crear un texto que llegara como correo a nuestro usuario. ClientUso es una funcion donde pasamos nuestras variables y la observacion sera el justificativo de la accion. Ahora ya sabes como enviar la notificacion de Habilitar y Deshabilitar.
 ```
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
     
 ```
## Estos son los puntos mas importantes que se puede visualizar en esta API. Ya tienes una idea sobre estas funciones.  pero para poder ver su funcionalidad puesdes descargarlo correrlo y puedes explorar con toda la confianza este desarrollo de codigo. Si algo no lo entendistes, no te desanimes asi todos comenzamos para poder lograr nuestro objetivos. PAra que te guste mas mi repositorio te muestro esto.
### Para correr mi proyecto solo pon estos comandos y listo ya puedes jugar con mi API o poner mas cosas de tu imaginacion
```
composer install
php artisan serve -> Te ayudara a visualizar en un desarrolllo local
php artisan migrate --seed -> para migrar datos quemados para jugar con mi codigo

```
## Ten en cuenta esto amigos. Ten instalado XAMP con PHP 8.0.25 porque trabajo con esta version y debes crear una base de datos en MYSQL donde debe sintroducir eso en el archivo .env.
## Ademas cunado lo corras te mandara un error. No tengas miedo solo requeria que le agregues una KEY que se te asignara automaticamente en la web.
## Eso es todo chicos y chicas. Usen con sabiduria mi proyecto hecho con mucho cariño
