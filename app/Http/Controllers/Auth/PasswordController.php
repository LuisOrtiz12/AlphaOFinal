<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordValidator;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resendLink(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // enviar el link de restablecimiento de contraseña al mail
        // https://laravel.com/docs/9.x/passwords#requesting-the-password-reset-link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Se invoca a la función padre
        return $status === Password::RESET_LINK_SENT
            ? $this->sendResponse(__($status))
            : $this->sendResponse(
                message: 'Link reset failure.',
                errors: ['email' =>__($status)],
                code: 422
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectReset(Request $request)
    {
        $frontend_url = env('APP_FRONTEND_URL');
        $token = $request->route('token');
        $email = $request->email;
        $url = "$frontend_url/landing/reset_password/$email/$token";
       
        return (new MailMessage)
        ->greeting('Cambia tu contraseña!')
        ->line("Puede cambiar su contraseña en nuestro sistema haciendo clic en el siguiente botón.")
        ->action("Recuperar Contraseña", $url);
    }

    // Función para la actualización del password
    public function restore(Request $request)
    {
        // Validación de los datos de entrada
        $validated = $request -> validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            // https://laravel.com/docs/9.x/validation#rule-confirmed
            'password' => [
                'required', 'string', 'confirmed',
                PasswordValidator::defaults()->mixedCase()->numbers()->symbols(),
            ],
        ]);

        // Función para cambiar el password
        $status = Password::reset($validated, function ($user , $password)
        {
            // Establece el nuevo password
            $user->password = Hash::make($password);
            // Grabar los cambios
            $user->save();
            // https://laravel.com/docs/9.x/passwords#password-reset-handling-the-form-submission
            event(new PasswordReset($user)); // Actualizar la contraseña en tiempo real
        });

        // Se invoca a la función padre
        return $status == Password::PASSWORD_RESET
            ? $this->sendResponse(__($status))
            : $this->sendResponse(
                message: 'Reseteo de contraseña fallido.',
                errors: ['email' =>__($status)],
                code: 422
            );
    }
    public function update(Request $request)
    {
        // Validación de los datos de entrada
        $validated = $request -> validate([
        'password' => ['required', 'string', 'confirmed',
                        PasswordValidator::defaults()->mixedCase()->numbers()->symbols()]]);
        $user = $request->user();
        $user->password = Hash::make($validated['password']);
        $user->save();
        return $this->sendResponse('Contraseña actualizada satisfactoriamente');
    }
}
