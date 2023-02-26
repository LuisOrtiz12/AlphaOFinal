<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request -> validate([
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        // Se obtiene el usario que esta haciendo el Request
        $user = $request->user();
       
        $file = $request['image'];
        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(),['folder'=>'avatars']);
        $url = $uploadedFileUrl->getSecurePath();
        
        $user->attachImage($url,$url);
        // Uso de la función padre
        return $this->sendResponse('Avatar actualizado satisfactoriamente');

    }
}
