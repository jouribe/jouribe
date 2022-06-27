<?php

namespace App\Models;

use App\Contracts\Seoable;
use App\Enums\PostState;
use App\Protocols\Meta;
use App\Traits\SeoableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia, Seoable
{
    use SoftDeletes;
    use HasFactory;
    use HasSlug;
    use HasTags;
    use Searchable;
    use InteractsWithMedia;
    use SeoableTrait;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'user',
        'category',
    ];

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
        'scheduled_at',
        'featured',
        'state',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'archived_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'featured' => 'boolean',
        'state' => PostState::class,
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
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs(): string
    {
        return 'posts';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    #[ArrayShape([
        'title' => 'mixed|string',
        'content' => 'mixed|string',
        'summary' => 'mixed|string',
        'user' => 'mixed|string',
        'category' => 'mixed|string',
    ])]
    #[SearchUsingFullText(['title', 'content', 'summary'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'summary' => $this->summary,
            'user' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'category' => [
                'slug' => $this->category->slug,
                'name' => $this->category->name,
            ],
        ];
    }

    /**
     * Modify the query used to retrieve models when making all the models searchable.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with(['user', 'category']);
    }

    /**
     * Get searchable filter attributes.
     *
     * @return string[]
     * @noinspection PhpUnused
     */
    public static function getSearchFilterAttributes(): array
    {
        return [
            'user.name',
            'user.email',
            'category.name',
            'category.slug',
        ];
    }

    /**
     * Get the options for generating the slug.
     *
     * @return SlugOptions
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
        $this
            ->addMediaConversion('post')
            ->withResponsiveImages()
            ->quality(85);
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
     * Seoable interface
     *
     * @return Meta
     */
    public function seoable(): Meta
    {
        return $this->seo();
    }

    /**
     * Get posts are published.
     *
     * @param  Builder  $query
     * @return Builder
     * @noinspection PhpUnused
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at');
    }
}
