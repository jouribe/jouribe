<?php

namespace App\Fields\OpenGraph;

use App\Fields\TemplatableField;

class Description extends TemplatableField
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
