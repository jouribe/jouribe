<?php

namespace App\Protocols;

use App\Fields\TwitterCard\Description;
use App\Fields\TwitterCard\Images;
use App\Fields\TwitterCard\Site;
use App\Fields\TwitterCard\Title;
use App\Fields\TwitterCard\Type;
use App\Fields\TwitterCard\Url;
use App\Fields\TwitterCard\Values;
use Illuminate\Contracts\Container\BindingResolutionException;

class TwitterCard extends Protocol
{
    /**
     * Set the title of the card.
     *
     * @param  array|string  $value
     * @param  string  $templateKey
     * @return $this
     * @throws BindingResolutionException
     */
    public function setTitle(array|string $value, string $templateKey = ''): self
    {
        $this->twitterCardService->setTitle($this->parseValue(
            $value,
            $templateKey ? new Title($this->model, $value, $templateKey) : Title::class
        ));

        return $this;
    }

    /**
     * Set the description of the card.
     *
     * @param  array|string  $value
     * @param  string  $templateKey
     * @return $this
     * @throws BindingResolutionException
     */
    public function setDescription(array|string $value, string $templateKey = ''): self
    {
        $this->twitterCardService->setDescription($this->parseValue(
            $value,
            $templateKey ? new Description($this->model, $value, $templateKey) : Description::class
        ));

        return $this;
    }

    /**
     * Set the url of the card.
     *
     * @param  string  $value
     * @return $this
     */
    public function setUrl(string $value): self
    {
        $this->twitterCardService->setUrl($this->parseValue($value, Url::class));

        return $this;
    }

    /**
     * Set the site of the card.
     *
     * @param  string  $value
     * @return $this
     */
    public function setSite(string $value): self
    {
        $this->twitterCardService->setSite($this->parseValue($value, Site::class));

        return $this;
    }

    /**
     * Set the type of the card.
     *
     * @param  string  $value
     * @return $this
     */
    public function setType(string $value): self
    {
        $this->twitterCardService->setType($this->parseValue($value, Type::class));

        return $this;
    }

    /**
     * Set the images of the card.
     *
     * @param  array|string  $value
     * @return $this
     */
    public function setImages(array|string $value): self
    {
        $this->twitterCardService->setImage($this->parseValue($value, Images::class));

        return $this;
    }

    /**
     * Set the values of the card.
     *
     * @param  array  $value
     * @return $this
     */
    public function setValues(array $value): self
    {
        foreach ($this->parseValue($value, Values::class) as $item) {
            $this->twitterCardService->addValue(...array_values($item));
        }

        return $this;
    }

    /**
     * Add the values of the card.
     *
     * @param  string  $key
     * @param  array|string  $value
     * @return $this
     */
    public function addValue(string $key,array|string $value): self
    {
        $this->twitterCardService->addValue(
            ...array_values(
                $this->parseValue([compact('key', 'value')], Values::class)[0]
            )
        );

        return $this;
    }

    /**
     * Get raw fields.
     *
     * @return array
     */
    protected function getRawFields(): array
    {
        return $this->modelSeoData['twitter_card'] ?? [];
    }
}
