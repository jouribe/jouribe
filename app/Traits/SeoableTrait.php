<?php

namespace App\Traits;

use App\Models\Seo;
use App\Protocols\Meta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait SeoableTrait
{
    /**
     * Boot the seoable trait for a model.
     *
     * @return void
     */
    public static function bootSeoableTrait()
    {
        static::deleting(static function ($item) {
            $item->seoData()->delete();
        });
    }

    /**
     * Relation to the seo data.
     *
     * @return MorphOne
     */
    public function seoData(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable')->withDefault();
    }

    /**
     * Get the meta data.
     *
     * @return array
     */
    public function getSeoData(): array
    {
        return $this->seoData()->exists() ? $this->seoData->getSeoData() : [];
    }

    /**
     * Seo.
     *
     * @return Meta
     */
    protected function seo(): Meta
    {
        return new Meta($this);
    }
}
