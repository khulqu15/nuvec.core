<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Peserta extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'peserta';

    protected $fillable = ['nik', 'password', 'first_name', 'password', 'api_token', 'last_name', 'dob', 'address', 'contact', 'age', 'vac_center_id'];

    protected $hidden = ['password', 'remember_token'];

    public function VacCenter()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function Vaccines()
    {
        return $this->belongsToMany(Vaccines::class);
    }

    public function VacStatus()
    {
        return $this->belongsToMany(VacStatus::class, 'peserta_vaccination_status', 'peserta_id', 'vaccination_status_id');
    }
}
