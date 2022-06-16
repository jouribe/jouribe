<?php

namespace App\Contracts;

interface Seoable
{
    /**
     * Seoable interface
     *
     * @return mixed
     */
    public function seoable(): mixed;

    /**
     * Get the SEOable's SEO.
     *
     * @return mixed
     */
    public function getSeoData(): mixed;
}
