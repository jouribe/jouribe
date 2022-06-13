<?php

namespace App\Fields\OpenGraph;

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
         return 'open_graph';
    }
}
