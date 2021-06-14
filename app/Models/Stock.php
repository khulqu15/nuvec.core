<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $fillable = ['vaccines_id', 'vac_center_id', 'stock'];

    public function Vaccines()
    {
        return $this->belongsTo(Vaccines::class);
    }

    public function VacCenter()
    {
        return $this->belongsTo(VacCenter::class);
    }
}
