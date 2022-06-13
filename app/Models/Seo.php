<?php

namespace App\Models;

use App\Contracts\SeoContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Seo extends Model implements SeoContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'meta',
        'open_graph',
        'twitter',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'meta' => 'array',
        'open_graph' => 'array',
        'twitter' => 'array'
    ];

    /**
     * Seo belongs to many models.
     *
     * @return MorphTo
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the metadata for the SEO.
     *
     * @return array<int, string>
     */
    public function getSeoData(): array
    {
        $meta = $this->meta;
        $openGraph = $this->open_graph;
        $twitter = $this->twitter;

        $meta += ['open_graph' => !empty($openGraph) ? $openGraph : []];
        $meta += ['twitter_card' => !empty($twitter) ? $twitter : []];

        return $meta;
    }

    /**
     * Get the model for the SEO.
     *
     * @return string
     */
    public function getSeoableModel(): string
    {
        return $this->seoable_type;
    }

    /**
     * Update the model in the database.
     *
     * @param  array  $attributes
     * @param  array  $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        return $this->fill($attributes)->save($options);
    }
}
