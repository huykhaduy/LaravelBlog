<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\LocaleJsonCast;

class Tag extends Model
{
    use HasFactory;

    protected $casts = [
        'name' => LocaleJsonCast::class,
    ];
}
