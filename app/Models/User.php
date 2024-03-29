<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Post;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
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


    public function posts(){
       return $this->hasMany(Post::class);
    }
    public function Likes(){
        return $this->hasMany(Like::class);
    }
  // almacena los seguidores de usuarios
    public function followers(){
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

      // almacena los siguiendos
      public function followings(){
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }
 // comprobamos si un suario sigue a otro
    public function siguiendo(User $user){
        return $this->followers->contains($user->id);
    }
}
