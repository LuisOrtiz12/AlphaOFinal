<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasImage as TraitsHasImage;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TraitsHasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'address',
        'personal_phone',
        'home_phone',
        'birthdate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }
    public function getFullName()
    {
        return "$this->first_name $this->last_name";
    }

    // Crear un avatar por default
    public function getDefaultAvatarPath()
    {
        return "https://cdn-icons-png.flaticon.com/512/711/711769.png";
    }


    // Obtener la imagen de la BDD
    public function getAvatarPath()
    {
        // se verifica no si existe una iamgen
        if (!$this->image)
        {
            // asignarle el path de una imagen por defecto
            return $this->getDefaultAvatarPath();
        }
        // retornar el path de la imagen registrada en la BDD
        return $this->image->path;
    }

    // Función para saber si el rol que tiene asignado el usuario
    // es el mismo que se le esta pasando a la función
    // https://laravel.com/docs/9.x/eloquent-relationships#one-to-many
    public function hasRole(string $role_slug)
    {
        return $this->role->slug === $role_slug;
    }

    public function comentario() {
        return $this->hasMany(Comentarios::class);
      }

      public function reserva()
      {
          return $this->hasMany(Reserva::class);
      }
}
