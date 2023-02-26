<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\User;
use Tests\TestCase;

class GeneralTest extends TestCase
{
/*
    public function test_inicio_de_sesion()
    {
        $test_request = $this->post('/api/alpha/login', [
            "email" => "andres89@example.com",
            "password" => "secret"
        ]);
        $test_request->assertStatus(200);
    }
    public function test_actualizacion_perfil()
    {
        $user = User::factory()->make(['role_id' => 2]);
        $profile = [
            "username" => "Juanca13",
            "first_name" => "Juan",
            "last_name" => "Carol",
            "email" => "juanca13@gmail.com",
            "birthdate" => "1999-08-15",
            "home_phone" => "023637988",
            "personal_phone" => "0992896598",
            "address" => "Quito Norte"
        ];
        $test_request = $this->actingAs($user)->post('/api/alpha/profile/', $profile);
        $test_request->assertStatus(200);
    }
    public function test_registro_cliente()
    {
        $test_request = $this->post('/api/alpha/register', [
            "username" => "Julio",
            "first_name" => "Julio",
            "last_name" => "Perez",
            "personal_phone" => "0992006595",
            "address" => "Comite del Pueblo",
           
            "email" => "july900@gmail.com",
            "birthdate" => "1999-08-15",
            "home_phone" => "029637977",
            "password" => "Hola1234*",
            
        ]);
        $test_request->assertStatus(200);
    }
   
    
    public function test_visualizacion_de_perfil()
    {
        $user = User::where('id', 1)->first();
        $test_request = $this->actingAs($user)->get('/api/alpha/profile');
        $test_request->assertStatus(200);
    }
 
    public function test_crear_contactanos()
    {
        $user = User::factory()->make(['role_id' => 2]);
        $contactos = [
            "nombre" => "Luis",
            "apellido" => "Espinoza",
            "correo" => "luis1@gmail.com",
            "puesto" => "Director",
            "contactanos" => "0995102824",
            
        ];
        $test_request = $this->actingAs($user)->post('/api/alpha/contactos/create', $contactos);
        $test_request->assertStatus(200);
    }
    public function test_actualizar_modulo()
    {
        $user = User::factory()->make(['role_id' => 1]);
        $modulo = [
            "Tema" => "Ira Biodanza1",
            "descripcion" => "Prueba de Modulo1",
            
            
        ];
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/ira/%u/update',1), $modulo);
        $test_request->assertStatus(200);
    }
    
    public function test_actualizar_lista_de_reproduccion()
    {
        $user = User::factory()->make(['role_id' => 1]);
        $modulo = [
            "tema" => "Ira Biodanza- Testeo",
            "genero" => "Ralph Cornejo",
            "descripcion" => "Testeo de Lista de Reproduccion",
            "duracion" => "300",
            
            
        ];
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/musicOne/%u/update',1), $modulo);
        $test_request->assertStatus(200);
    }
    public function test_actualizar_publicidad()
    {
        $user = User::factory()->make(['role_id' => 1]);
        $publicidad = [
            "titulo" => "Publicidad Testeo",
            "descripcion" => "Testeo de Publicidad",
            "evento" => "2023-02-07 22:50",
            
            
        ];
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/publicidad/%u/update',1), $publicidad);
        $test_request->assertStatus(200);
    }
  
*/
/*
    public function test_actualizar_evento()
    {
        $user = User::factory()->make(['role_id' => 1]);
        $evento = [
            "titulo" => "Publicidad Testeo",
            "descripcion" => "Testeo de Publicidad",
            "evento" => "2023-02-07 22:50",
            "contacto" => "0995102824",
            "cupos" => "12",
            
            
        ];
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/events/eventupdate/%u',1), $evento);
        $test_request->assertStatus(200);
    }
    */
  /*
    public function test_actualizar_reservas()
    {
        $user = User::where('id', 9)->first();
       
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/reservas/reserva-create/%u',1));
        $test_request->assertStatus(200);
    }
  
    public function test_crear_comentario()
    {
        $user = User::where('id', 9)->first();
        $comentario = [
            "comentario" => "Comentario Testeo",
            "calificacion" => "5",
         
            
        ];
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/comments/comment-create'), $comentario);
        $test_request->assertStatus(200);
    }
    */

   
    public function test_crear_inactividad_actividad()
    {
        $user = User::where('id', 1)->first();
        $usuario = [
            "observacion" => "Activado o Inactivado Testeo",
       
            
        ];
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/clientes-admin/%u/destroy',6), $usuario);
        $test_request->assertStatus(200);
    }
    
    

}