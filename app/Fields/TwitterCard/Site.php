<?php

namespace App\Fields\TwitterCard;

use App\Fields\Field;

class Site extends Field
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
