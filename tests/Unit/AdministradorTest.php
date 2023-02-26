<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\User;
use Tests\TestCase;

class AdministradorTest extends TestCase

//CONTACTANOS
{
    
    public function test_crear_contactanos()
    {
        $user = User::where('id', 1)->first();
        $contactos = [
            "nombre" => "Rossy",
            "apellido" => "Gallegos",
            "correo" => "rossy@gmail.com",
            "puesto" => "Subdirectora",
            "contactanos" => "0995102824",
            
        ];
        $test_request = $this->actingAs($user)->post('/api/alpha/contactos/create', $contactos);
        $test_request->assertStatus(200);
    }

 

    
// BANNERS
public function test_crear_banner()
{
    $user = User::where('id', 1)->first();

    $banner = [
        "nombre" => "foto2",
     
    ];  
    $test_request=$this->actingAs($user)->post('/api/alpha/banner/create',$banner);
    $test_request->assertStatus(200);
}

// EMOCIONES
public function test_crear_emocion()
    {
        $user = User::where('id', 1)->first();
        $emocion = [
            "Tema" => "EmocionPrueba",
            "descripcion" => "PruebaUnitaria",  
        ];
        $test_request = $this->actingAs($user)->post('/api/alpha/ansiedad/create', $emocion);
        $test_request->assertStatus(200);
    }


//LISTA DE REPRODUCCION
public function test_crear_listaReproduccion()
    {
        $user = User::where('id', 1)->first();
        $musica = [
            "tema" => "ListaPrueba",
            "genero" => "Prueba",
            "descripcion" => "Prueba",
            "duracion" => "250",
            
            
        ];
        $test_request = $this->actingAs($user)->post('/api/alpha/musicFive/create', $musica);
        $test_request->assertStatus(200);
    }

 
//PUBLICIDADES
public function test_crear_publicidad()
    {
        $user = User::where('id', 1)->first();
        $publicidad = [
            "titulo" => "Unitaria",
            "descripcion" => "Unitaria",
            "evento" => "2023-03-17",
            
            
        ];
        $test_request = $this->actingAs($user)->post('/api/alpha/publicidad/create', $publicidad);
        $test_request->assertStatus(200);
    }

 
//COMENTARIOS
public function test_crear_comentario()
    {
        $user = User::where('id', 1)->first();
        $comentario = [
            "comentario" => "Bonito",
            "calificacion" => "4",   
        ];
        $test_request = $this->actingAs($user)->post('/api/alpha/comments/comment-create', $comentario);
        $test_request->assertStatus(200);
    }

  
//EVENTOS
public function test_crear_evento()
    {
        $user = User::where('id', 1)->first();
        $emocion = [
            "titulo" => "Test",
            "descripcion" => "Unitaria",
            "evento" => "2023-02-14",
            "contacto" => "0958845034",
            "cupos" => "10",
            
        ];
        $test_request = $this->actingAs($user)->post('/api/alpha/events/event-create', $emocion);
        $test_request->assertStatus(200);
    }

 
//RESERVAS
public function test_crear_reserva()
    {
        $user = User::where('id', 7)->first();
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/reservas/reserva-create/%u',1));
        $test_request->assertStatus(200);
    }

 
//HABILI-DESHABILI
public function test_habilitar_deshabilitar()
    {
        $user = User::where('id', 1)->first();
        $usuario = [
            "observacion" => "Activado o Inactivado Testeo",      
        ];
        $test_request = $this->actingAs($user)->post(sprintf('/api/alpha/clientes-admin/%u/destroy',10), $usuario);
        $test_request->assertStatus(200);
    }

    public function test_ver_clientes()
    {
        $user = User::where('id', 1)->first();
        $test_request = $this->actingAs($user)->get('/api/alpha/clientes-admin/users');
        $test_request->assertStatus(200);
    }

}