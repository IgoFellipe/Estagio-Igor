<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = ['nome', 'hackathon_id', 'lider_id', 'codigo'];

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }

    public function lider()
    {
        return $this->belongsTo(User::class, 'lider_id');
    }

    public function membros()
    {
        return $this->belongsToMany(User::class);
    }
}
