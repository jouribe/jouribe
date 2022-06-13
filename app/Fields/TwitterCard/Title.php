<?php

namespace App\Fields\TwitterCard;

use App\Fields\TemplatableField;

class Title extends TemplatableField
{
    /**
     * Get the nesting level.
     *
     * @return string
     */
    protected function getNestingLevel(): string
    {
        return 'twitter_card';
    }
}
