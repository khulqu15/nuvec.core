<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacCenter extends Model
{
    use HasFactory;

    protected $table = 'vac_center';

    protected $fillable = ['name', 'address', 'contact'];

    public function Peserta()
    {
        return $this->hasMany(Peserta::class);
    }

    public function Schedule()
    {
        return $this->belongsToMany(Schedule::class, 'vac_center_schedule');
    }

    public function Stock()
    {
        return $this->hasMany(Stock::class);
    }
}
