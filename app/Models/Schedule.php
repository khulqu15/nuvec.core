<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';

    protected $fillable = ['date', 'time'];

    public function VacCenter()
    {
        return $this->belongsToMany(VacCenter::class, 'vac_center_schedule');
    }
}
