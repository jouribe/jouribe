<?php

namespace App\Fields\OpenGraph;

use App\Fields\Field;

class SiteName extends Field
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
