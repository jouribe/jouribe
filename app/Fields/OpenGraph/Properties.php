<?php

namespace App\Fields\OpenGraph;

use App\Fields\Field;

class Properties extends Field
{
    /**
     * Parse the field's value.
     *
     * @param  array|string  $value
     * @return string|array
     */
    protected function parseValue(array|string $value): string|array
    {
        foreach ($value as &$item) {
            if (is_array($item['value'])) {
                foreach ($item['value'] as &$property_value) {
                    $property_value = $this->model->getAttribute($property_value);
                }
            } else {
                $item['value'] = $this->model->getAttribute($item['value']);
            }
        }

        return $value;
    }
}
