<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Carbon\Carbon;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, SoftDeletes, HasSEO, InteractsWithMedia, Translatable, HasSlug;

    protected static $postType = 'post';
    public $translatedAttributes = ['title', 'content', 'slug'];

    public function postCollection(): BelongsTo
    {
        return $this->belongsTo(PostCollection::class, 'post_collection_id', 'id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    protected static function booted()
    {
        parent::boot();

        static::saving(function ($post) {
            $post->post_type = self::$postType;

            if ($post->is_active) {
                $post->posted_at = now();
            } else {
                $post->posted_at = null;
            }
        });
    }

    public function newQuery()
    {
        return parent::newQuery()->where('post_type', self::$postType);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->useDisk('posts')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/svg+xml',
                'image/webp',
                'image/gif',
                'image/svg',
            ]);
    }

    public function getDynamicSEOData(): SEOData
    {
        // Override only the properties you want:
        return new SEOData(
            title: $this->title,
            description: $this->content,
            author: $this->author->name,
            image: $this->getFirstMediaUrl(),
            published_time: Carbon::parse($this->posted_at),
            modified_time: Carbon::parse($this->updated_at),
            tags: $this->tags?->pluck('name')->toArray(),
        );
    }

    // public function registerMediaConversions(?Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')
    //         ->width(65)
    //         ->height(65)
    //         ->sharpen(10)
    //         ->keepOriginalImageFormat()
    //         ->nonQueued();
    // }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
