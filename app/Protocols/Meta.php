<?php

namespace App\Protocols;

use App\Fields\Meta\Canonical;
use App\Fields\Meta\Description;
use App\Fields\Meta\Keywords;
use App\Fields\Meta\Languages;
use App\Fields\Meta\MetaTag;
use App\Fields\Meta\Next;
use App\Fields\Meta\Prev;
use App\Fields\Meta\Title;
use App\Fields\Meta\TitleSeparator;
use Illuminate\Contracts\Container\BindingResolutionException;

class Meta extends Protocol
{
    /**
     * @param  array  $tags
     * @return $this
     */
    public function setData(array $tags): self
    {
        foreach ($this->parseValue($tags, MetaTag::class) as $item) {
            $this->metaService->addMeta(...array_values($item));
        }

        return $this;
    }

    /**
     * Add meta tag.
     *
     * @param  string  $meta
     * @param  string  $value
     * @param  string  $name
     * @return $this
     */
    public function addMeta(string $meta, string $value, string $name = 'name'): self
    {
        $this->metaService->addMeta(...array_values(
            $this->parseValue(
                [compact('meta', 'value', 'name')],
                MetaTag::class
            )[0]
        ));

        return $this;
    }

    /**
     * Set title.
     *
     * @param  array|string  $value
     * @param  string  $templateKey
     * @return $this
     * @throws BindingResolutionException
     */
    public function setTitle(array|string $value, string $templateKey = ''): self
    {
        $this->seoTools->setTitle($this->parseValue(
            $value,
            $templateKey ? new Title($this->model, $value, $templateKey) : Title::class
        ));

        return $this;
    }

    /**
     * Set title separator.
     *
     * @param  string  $value
     * @return $this
     */
    public function setTitleSeparator(string $value): self
    {
        $this->metaService->setTitleSeparator($this->parseValue($value, TitleSeparator::class));

        return $this;
    }

    /**
     * Set description.
     *
     * @param  array|string  $value
     * @param  string  $templateKey
     * @return $this
     * @throws BindingResolutionException
     */
    public function setDescription(array|string $value, string $templateKey = ''): self
    {
        $this->seoTools->setDescription($this->parseValue(
            $value,
            $templateKey ? new Description($this->model, $value, $templateKey) : Description::class
        ));

        return $this;
    }

    /**
     * Set canonical.
     *
     * @param  string  $value
     * @return $this
     */
    public function setCanonical(string $value): self
    {
        $this->seoTools->setCanonical($this->parseValue($value, Canonical::class));

        return $this;
    }

    /**
     * Set prev.
     *
     * @param  string  $value
     * @return $this
     */
    public function setPrev(string $value): self
    {
        $this->metaService->setPrev($this->parseValue($value, Prev::class));

        return $this;
    }

    /**
     * Set next.
     *
     * @param  string  $value
     * @return $this
     */
    public function setNext(string $value): self
    {
        $this->metaService->setNext($this->parseValue($value, Next::class));

        return $this;
    }

    /**
     * Set keywords.
     *
     * @param  array|string  $value
     * @return $this
     */
    public function setKeywords(array|string $value): self
    {
        $this->metaService->setKeywords($this->parseValue($value, Keywords::class));

        return $this;
    }

    /**
     * Set languages.
     *
     * @param  array  $value
     * @return $this
     */
    public function setLanguages(array $value): self
    {
        $this->metaService->addAlternateLanguages($this->parseValue($value, Languages::class));

        return $this;
    }

    /**
     * Add alternate languages.
     *
     * @param  string  $lang
     * @param  string  $url
     * @return $this
     */
    public function addLanguage(string $lang, string $url): self
    {
        $this->metaService->addAlternateLanguage(...array_values(
            $this->parseValue(
                [compact('lang', 'url')],
                Languages::class
            )[0]
        ));

        return $this;
    }

    /**
     * Get raw fields.
     *
     * @return array
     */
    protected function getRawFields(): array
    {
        return $this->modelSeoData;
    }
}
