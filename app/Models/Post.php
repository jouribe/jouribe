<?php

namespace App\Models;

use App\Contracts\Seoable;
use App\Enums\PostState;
use App\Traits\SeoableTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia, Seoable
{
    use SoftDeletes, HasFactory, HasSlug, HasTags, Searchable, InteractsWithMedia, SeoableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'content',
        'summary',
        'category_id',
        'user_id',
        'published_at',
        'archived_at',
        'schedule_at',
        'featured',
        'state',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'archived_at' => 'datetime',
        'schedule_at' => 'datetime',
        'featured' => 'boolean',
        'state' => PostState::class
    ];

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs(): string
    {
        return 'posts_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    #[ArrayShape([
        'id' => "int|mixed",
        'title' => "mixed|string",
        'content' => "mixed|string",
        'summary' => "mixed|string",
        'user' => "mixed|string",
        'category' => "mixed|string",
    ])]
    #[SearchUsingPrefix(['id'])]
    #[SearchUsingFullText(['title', 'content', 'summary'])]
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'summary' => $this->summary,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name
            ],
        ];
    }

    /**
     * Modify the query used to retrieve models when making all the models searchable.
     *
     * @param  Builder  $query
     * @return Builder
     */
    protected function makeAllSearchableUsing($query): Builder
    {
        return $query->with('user', 'category');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Set the thumbnail.
     *
     * @param  Media|null  $media
     * @return void
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    /**
     * Set the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post_files')->singleFile();
        $this->addMediaCollection('post_images');
    }

    /**
     * Publish post.
     *
     * @return void
     */
    public function publish(): void
    {
        $this->published_at = now();
        $this->saveQuietly();
    }

    /**
     * Unpublish post.
     *
     * @return void
     */
    public function unpublish(): void
    {
        $this->published_at = null;
        $this->saveQuietly();
    }

    /**
     * Archive post.
     *
     * @return void
     */
    public function archive(): void
    {
        $this->archived_at = now();
        $this->saveQuietly();
    }

    /**
     * Unarchive post.
     *
     * @return void
     */
    public function unarchive(): void
    {
        $this->archived_at = null;
        $this->saveQuietly();
    }

    /**
     * Set the post as featured or not.
     *
     * @param  bool  $value
     * @return void
     */
    public function featured(bool $value = true): void
    {
        $this->featured = $value;

        $this->saveQuietly();
    }

    /**
     * Get the user that owns the post.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the post.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the comments that own the post.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Seoable trait.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function seoable(): void
    {
        $this->seo()
            ->setTitle($this->title)
            ->setDescription($this->summary);
    }
}
