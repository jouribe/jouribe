<?php

namespace App\Fields\Meta;

use App\Fields\Field;

class TitleSeparator extends Field
{
    /**
     * Parse the field's value.
     *
     * @param  array|string  $value
     * @return mixed
     */
    protected function parseValue(array|string $value): mixed
    {
        return $this->model->getAttribute($value);
    }
}
