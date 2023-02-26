<?php

use App\Http\Controllers\Account\AvatarController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Administrador\AdminController;
use App\Http\Controllers\Banner\BannerController;
use App\Http\Controllers\Comment\CommentsController;
use App\Http\Controllers\Contactanos\ContactanosController;
use App\Http\Controllers\Emotions\AnsiedadController;
use App\Http\Controllers\Emotions\DepresionController;
use App\Http\Controllers\Emotions\IraController;
use App\Http\Controllers\Emotions\MiedoController;
use App\Http\Controllers\Emotions\SoledadController;
use App\Http\Controllers\ListaReproduccion\MusicaFiveController;
use App\Http\Controllers\ListaReproduccion\MusicaFourController;
use App\Http\Controllers\ListaReproduccion\MusicaOneController;
use App\Http\Controllers\ListaReproduccion\MusicaThreeController;
use App\Http\Controllers\ListaReproduccion\MusicaTwoController;
use App\Http\Controllers\Publicidad\PublicidadController;
use App\Http\Controllers\Reservaciones\EventoController;
use App\Http\Controllers\Reservaciones\ReservaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('alpha')->group(function ()
{
    require __DIR__ . '/auth.php';
    Route::middleware(['auth:sanctum'])->group(function ()
    {
        // Se hace uso de grupo de rutas
        Route::prefix('profile')->group(function ()
        {
            Route::controller(ProfileController::class)->group(function ()
            {
                Route::get('/', 'show')->name('profile');
                Route::post('/', 'store')->name('profile.store');
            });
            Route::controller(AvatarController::class)->group(function()
            {
                Route::post('/avatar','store')->name('profile.avatar');
            });
        });

        
        Route::prefix("banner")->group(function ()
        {
            Route::controller(BannerController::class)->group(function () {
                Route::get('/fotos', 'index');
                Route::get('/total', 'indexnuevo');
                Route::post('/create', 'store');
                Route::get('/{banner}/destroy', 'destroy');
            });
        });
        Route::prefix("contactos")->group(function ()
        {
            Route::controller(ContactanosController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{contactanos}', 'show');
                Route::post('/{contactanos}/update', 'update');
                Route::get('/{contactanos}/destroy', 'destroy');
            });
        });

        Route::prefix("ira")->group(function ()
        {
            Route::controller(IraController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{ira}', 'show');
                Route::post('/{emotion}/update', 'update');
                Route::get('/{ira}/destroy', 'destroy');
            });
        });

        Route::prefix("ansiedad")->group(function ()
        {
            Route::controller(AnsiedadController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{ansiedad}', 'show');
                Route::post('/{ansiedad}/update', 'update');
                Route::get('/{ansiedad}/destroy', 'destroy');
            });
        });

        Route::prefix("soledad")->group(function ()
        {
            Route::controller(SoledadController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{soledad}', 'show');
                Route::post('/{soledad}/update', 'update');
                Route::get('/{soledad}/destroy', 'destroy');
            });
        });

        Route::prefix("miedo")->group(function ()
        {
            Route::controller(MiedoController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{miedo}', 'show');
                Route::post('/{miedo}/update', 'update');
                Route::get('/{miedo}/destroy', 'destroy');
            });
        });

        Route::prefix("depresion")->group(function ()
        {
            Route::controller(DepresionController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{depresion}', 'show');
                Route::post('/{depresion}/update', 'update');
                Route::get('/{depresion}/destroy', 'destroy');
            });
        });

        Route::prefix("musicOne")->group(function ()
        {
            Route::controller(MusicaOneController::class)->group(function () {
                Route::get('/lista', 'index');
                Route::post('/create', 'store');
                Route::get('/{musicone}', 'show');
                Route::post('/{musicone}/update', 'update');
                Route::get('/{musicone}/destroy', 'destroy');
            });
        });

        Route::prefix("musicTwo")->group(function ()
        {
            Route::controller(MusicaTwoController::class)->group(function () {
                Route::get('/lista', 'index');
                Route::post('/create', 'store');
                Route::get('/{musictwo}', 'show');
                Route::post('/{musictwo}/update', 'update');
                Route::get('/{musictwo}/destroy', 'destroy');
            });
        });

        Route::prefix("musicThree")->group(function ()
        {
            Route::controller(MusicaThreeController::class)->group(function () {
                Route::get('/lista', 'index');
                Route::post('/create', 'store');
                Route::get('/{musicthree}', 'show');
                Route::post('/{musicthree}/update', 'update');
                Route::get('/{musicthree}/destroy', 'destroy');
            });
        });

        Route::prefix("musicFour")->group(function ()
        {
            Route::controller(MusicaFourController::class)->group(function () {
                Route::get('/lista', 'index');
                Route::post('/create', 'store');
                Route::get('/{musicfour}', 'show');
                Route::post('/{musicfour}/update', 'update');
                Route::get('/{musicfour}/destroy', 'destroy');
            });
        });

        Route::prefix("musicFive")->group(function ()
        {
            Route::controller(MusicaFiveController::class)->group(function () {
                Route::get('/lista', 'index');
                Route::post('/create', 'store');
                Route::get('/{musicfive}', 'show');
                Route::post('/{musicfive}/update', 'update');
                Route::get('/{musicfive}/destroy', 'destroy');
            });
        });

        Route::prefix("publicidad")->group(function ()
        {
            Route::controller(PublicidadController::class)->group(function () {
                Route::get('/publ', 'index');
                Route::post('/create', 'store');
                Route::get('/{publicidad}', 'show');
                Route::post('/{publicidad}/update', 'update');
                Route::get('/{publicidad}/destroy', 'destroy');
            });
        });

        Route::prefix("clientes-admin")->group(function ()
        {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/users', 'index');
                Route::post('/{user}/destroy', 'destroy');
            });
        });

        Route::prefix("comments")->group(function ()
        {
            Route::controller(CommentsController::class)->group(function () {
                Route::get('/vercomment', 'index');
                Route::post('/comment-create','store');
                Route::get('/{user}/destroy', 'destroy');
            });
        });

        Route::prefix("events")->group(function ()
        {
            Route::controller(EventoController::class)->group(function () {
                Route::get('/eventlist', 'index');
                Route::post('/event-create','store');
                Route::post('/eventupdate/{eventoup}','update');
                Route::get('/evento-get/{evento}', 'show');
                Route::get('/eventodestroy/{evento}/destroy','destroy');
            });
        });
         

        Route::prefix("reservas")->group(function ()
        {
            Route::controller(ReservaController::class)->group(function () {
                Route::get('/reservalist', 'index');
                Route::post('/reserva-create/{evento}','store');
                Route::get('reservaget/{evento}','show');
                Route::get('/{reserva}/destroy', 'destroy');
                Route::get('/misreservs', 'indexuser');
                
            });
        });

    });

});