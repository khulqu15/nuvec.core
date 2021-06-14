<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoDocumentation extends Model
{
    use HasFactory;

    protected $table = 'video_documentations';

    protected $fillable = ['name', 'video'];
}
