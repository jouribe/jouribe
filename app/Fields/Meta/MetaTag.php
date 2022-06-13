<?php

namespace App\Fields\Meta;

use App\Fields\Field;

class MetaTag extends Field
{
    /**
     * Parse the field's value.
     *
     * @param  array|string  $value
     * @return string|array
     */
    protected function parseValue(array|string $value): string|array
    {
        foreach ($value as &$tag) {
            $tag['value'] = $this->model->getAttribute($tag['value']);
        }

        return $value;
    }
}
