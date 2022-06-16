<?php

namespace App\Contracts;

interface SeoDataContract
{
    /**
     * Get the SEO data for the given model.
     *
     * @return array
     */
    public function getSeoData(): array;

    /**
     * Get the model's SEO data.
     *
     * @return string
     */
    public function getSeoableModel(): string;
}
