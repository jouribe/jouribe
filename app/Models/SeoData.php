<?php

namespace App\Models;

use App\Contracts\SeoDataContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoData extends Model implements SeoDataContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'meta',
        'open_graph',
        'twitter',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string>
     */
    protected $casts = [
        'meta' => 'array',
        'open_graph' => 'array',
        'twitter' => 'array',
    ];

    /**
     * Seo belongs to a model.
     *
     * @return MorphTo
     * @noinspection PhpUnused
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the SEO data for the given model.
     *
     * @return array
     */
    public function getSeoData(): array
    {
        $meta = $this->meta;
        $open_graph = $this->open_graph;
        $twitter_card = $this->twitter_card;

        $meta += ['open_graph' => ! empty($open_graph) ? $open_graph : []];

        $meta += ['twitter_card' => ! empty($twitter_card) ? $twitter_card : []];

        return $meta;
    }

    /**
     * Get the model's SEO data.
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
