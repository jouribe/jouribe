<?php

namespace App\Fields;

use Illuminate\Database\Eloquent\Model;

abstract class Field
{
    /**
     * The field's model.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * The field's name.
     *
     * @var string|array
     */
    protected array|string $value;

    /**
     * Create a new field instance.
     *
     * @param  Model  $model
     * @param  array|string  $value
     */
    public function __construct(Model $model, array|string $value)
    {
        $this->model = $model;
        $this->value = $this->parseValue($value);
    }

    /**
     * Parse the attributes with keys.
     *
     * @param  array|string  $attributes
     * @return array
     */
    protected function parseAttributesWithKeys(array|string $attributes): array
    {
         $result = [];
        if (is_array($attributes)) {
            foreach ($attributes as $key => $field) {
                $value = $this->model->getAttribute($field);
                if (is_numeric($key)) {
                    $result[$field] = $value;
                } else {
                    $result[$key] = $value;
                }
            }
        } else {
            $result[$attributes] = $this->model->getAttribute($attributes);
        }

        return $result;
    }

    /**
     * Parse the attributes.
     *
     * @param array|string $attributes
     * @return array
     */
     protected function parseAttributes(array|string $attributes): array
    {
        $result = [];

        if (is_array($attributes)) {
            foreach ($attributes as $key => $field) {
                $result[] = $this->model->getAttribute($field);
            }
        } else {
            return $this->model->getAttribute($attributes);
        }

        return $result;
    }

    /**
     * Get the field's value.
     *
     * @return array|string
     */
    public function getValue(): array|string
    {
        return $this->value;
    }

    /**
     * Parse the field's value.
     *
     * @param  array|string  $value
     * @return mixed
     */
    abstract protected function parseValue(array|string $value): mixed;
}
