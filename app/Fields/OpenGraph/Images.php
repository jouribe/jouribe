<?php

namespace App\Fields\OpenGraph;

use App\Fields\Field;

class Images extends Field
{
    /**
     * Parse the field's value.
     *
     * @param  array|string  $value
     * @return array
     */
    protected function parseValue(array|string $value): array
    {
        return $this->parseAttributes($value);
    }
}
