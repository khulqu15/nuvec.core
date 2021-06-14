<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacStatus extends Model
{
    use HasFactory;

    protected $table = 'vaccination_status';

    protected $fillable = ['status'];

    public function Peserta()
    {
        return $this->belongsToMany(Peserta::class, 'peserta_vaccination_status', 'vaccination_status_id');
    }
}
