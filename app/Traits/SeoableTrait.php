<?php

namespace App\Traits;


use App\Models\SeoData;
use App\Protocols\Meta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait SeoableTrait
{
    /**
     * Boot the seoable trait for a model.
     *
     * @return void
     * @noinspection PhpUnused
     */
    public static function bootSeoableTrait(): void
    {
        static::deleting(static function ($item) {
            $item->seoData()->delete();
        });
    }

    /**
     * Get the seo data for the model.
     *
     * @return MorphOne
     */
    public function seoData(): MorphOne
    {
        return $this->morphOne(SeoData::class, 'seoable')->withDefault();
    }

    /**
     * Get seo data from the table.
     *
     * @return mixed
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getSeoData(): mixed
    {
        return $this->seoData()->exists() ? $this->seoData->getSeoData() : [];
    }

    /**
     * Seo data setter.
     *
     * @return Meta
     */
    protected function seo(): Meta
    {
        return new Meta($this);
    }
}
