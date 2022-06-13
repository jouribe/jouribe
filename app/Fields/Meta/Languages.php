<?php

namespace App\Fields\Meta;

use App\Fields\Field;

class Languages extends Field
{
    /**
     * Parse the field's value.
     *
     * @param  array|string  $value
     * @return string|array
     */
    protected function parseValue(array|string $value): string|array
    {
        foreach ($value as &$language) {
            $language['url'] = $this->model->getAttribute($language['url']);
        }

        return $value;
    }
}
