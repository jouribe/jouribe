<?php

namespace App\Contracts;

interface SeoContract
{
    public function getSeoData(): array;

    public function getSeoableModel(): string;
}
