<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array<int, string>
//     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//        'user_role',
//    ];
//
//    /**
//     * The attributes that should be hidden for serialization.
//     *
//     * @var array<int, string>
//     */
//    protected $hidden = [
//        'password',
//        'remember_token',
//    ];
//
//    /**
//     * The attributes that should be cast.
//     *
//     * @var array<string, string>
//     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];

    use HasFactory, SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'user_role',
        'status',
        'no_hp',
    ];

    public function role(){
        return $this->belongsTo(Role::class, 'user_role');
    }
    public function langganan(){
        return $this->hasMany(Langganan::class);
    }
    public function langinv(){
        return $this->hasMany(Langinv::class);
    }
    public function invoice(){
        return $this->hasMany(Invoice::class);
    }
}
