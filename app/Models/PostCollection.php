<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Casts\LocaleJsonCast;

class PostCollection extends Model
{
    use HasFactory;

    protected $casts = [
        'title' => LocaleJsonCast::class,
        'content' => LocaleJsonCast::class,
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_collection_id', 'id');
    }
}
