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
     * The field's value.
     *
     * @var string|array
     */
    protected string|array $value;

    /**
     * Create a new field instance.
     *
     * @param  array|string  $value
     * @param  Model  $model
     */
    public function __construct(array|string $value, Model $model)
    {
        $this->model = $model;
        $this->value = $this->parseValue($value);
    }

    /**
     * Parse attributes with key/value pairs.
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
     * Parse attributes.
     *
     * @param  array|string  $attributes
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
