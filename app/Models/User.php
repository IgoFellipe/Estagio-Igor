<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Grupo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'matricula',
        'tipo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'tipo' => 'string',
    ];

    protected $enums = [
        'tipo' => ['aluno', 'professor'],
    ];

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_user', 'user_id', 'grupo_id')
            ->withTimestamps();
    }

    public function gruposLiderados()
    {
        return $this->hasMany(Grupo::class, 'lider_id')
            ->with('membros', 'hackathon');
    }
}
