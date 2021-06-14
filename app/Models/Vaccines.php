<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccines extends Model
{
    use HasFactory;

    protected $table = 'vaccines';

    protected $fillable = ['brand', 'detail'];

    public function Stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function Peserta()
    {
        return $this->belongsToMany(Peserta::class, 'peserta_vaccines');
    }

}
