<?php

namespace App\Fields;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Model;

abstract class TemplatableField extends Field
{
    /**
     * Template key.
     *
     * @var string
     */
    protected string $templateKey;

    /**
     * Translator.
     *
     * @var Translator
     */
    protected Translator $translator;

    /**
     * Create a new field template instance.
     *
     * @param  array|string  $value
     * @param  Model  $model
     * @param  string  $templateKey
     * @throws BindingResolutionException
     */
    public function __construct(array|string $value, Model $model, string $templateKey = '')
    {
        $this->templateKey = $templateKey;
        $this->translator = Container::getInstance()->make('translator');

        parent::__construct($value, $model);
    }

    /**
     * Parse the field's value.
     *
     * @param  array|string  $value
     * @return mixed
     */
    protected function parseValue(array|string $value): string
    {
        $nesting_level = $this->templateKey ?: $this->getNestingLevel();

        $template_path = $this->getTemplatePath(
            get_class($this->model).
            ($nesting_level ? '.'.$nesting_level : '')
        );

        return $this->translator->has($template_path) ? $this->translator->get(
            $template_path,
            $this->parseAttributesWithKeys($value)
        ) : $this->model->getAttribute($value);
    }

    /**
     * Get the template path.
     *
     * @param  string  $templateKey
     * @return string
     */
    protected function getTemplatePath(string $templateKey): string
    {
        return config('seoable.templates_path').
            '.'.$templateKey.'.'.
            mb_strtolower(class_basename($this));
    }

    /**
     * Get the nesting level.
     *
     * @return string
     */
    protected function getNestingLevel(): string
    {
        return '';
    }
}
