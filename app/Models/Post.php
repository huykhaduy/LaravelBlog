<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;

class Post extends Model implements HasMedia
{
    use HasFactory, HasSEO, InteractsWithMedia, Translatable;

    public $translatedAttributes = ['title', 'content'];
}
