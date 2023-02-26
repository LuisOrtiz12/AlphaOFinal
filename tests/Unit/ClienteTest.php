<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\User;
use Tests\TestCase;

class ClientTest extends TestCase{
    
    public function test_ver_contactanos()
    {
        $user = User::where('id', 7)->first();
        $test_request = $this->actingAs($user)->get('/api/alpha/contactos/');
        $test_request->assertStatus(200);
    }

    public function test_ver_banner()
{
    $user = User::where('id', 7)->first();
    $test_request = $this->actingAs($user)->get('/api/alpha/banner/fotos');
    $test_request->assertStatus(200);
}


public function test_ver_emocion()
{
    $user = User::where('id', 7)->first();
    $test_request = $this->actingAs($user)->get('/api/alpha/ansiedad/');
    $test_request->assertStatus(200);
}

public function test_ver_listaReproduccion()
{
    $user = User::where('id', 7)->first();
    $test_request = $this->actingAs($user)->get('/api/alpha/musicFive/lista');
    $test_request->assertStatus(200);
}

public function test_ver_publicidad()
{
    $user = User::where('id', 7)->first();
    $test_request = $this->actingAs($user)->get('/api/alpha/publicidad/publ');
    $test_request->assertStatus(200);
}

public function test_ver_comentario()
{
    $user = User::where('id', 7)->first();
    $test_request = $this->actingAs($user)->get('/api/alpha/comments/vercomment');
    $test_request->assertStatus(200);
}

public function test_ver_evento()
{
    $user = User::where('id', 7)->first();
    $test_request = $this->actingAs($user)->get('/api/alpha/events/eventlist');
    $test_request->assertStatus(200);
}

public function test_ver_reserva()
{
    $user = User::where('id', 7)->first();
    $test_request = $this->actingAs($user)->get('/api/alpha/reservas/misreservs');
    $test_request->assertStatus(200);
}

}