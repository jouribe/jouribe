<?php

namespace App\Fields\Meta;

use App\Fields\Field;

class Keywords extends Field
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
