<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hackathon extends Model
{
    protected $fillable = [
    'nome',
    'descricao',
    'data_inicio',
    'data_fim',
    'banner'
];

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }

    /**
     * Registros de presença do hackathon
     */
    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
