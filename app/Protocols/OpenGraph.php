<?php

namespace App\Protocols;

use App\Fields\OpenGraph\Description;
use App\Fields\OpenGraph\Images;
use App\Fields\OpenGraph\Properties;
use App\Fields\OpenGraph\SiteName;
use App\Fields\OpenGraph\Title;
use App\Fields\OpenGraph\Url;
use Illuminate\Contracts\Container\BindingResolutionException;

class OpenGraph extends Protocol
{
    /**
     * Set the title of the page.
     *
     * @param  array|string  $value
     * @param  string  $templateKey
     * @return $this
     * @throws BindingResolutionException
     */
    public function setTitle(array|string $value, string $templateKey = ''): self
    {
        $this->openGraphService->setTitle($this->parseValue(
            $value,
            $templateKey ? new Title($this->model, $value, $templateKey) : Title::class
        ));

        return $this;
    }

    /**
     * Set the description of the page.
     *
     * @param  array|string  $value
     * @param  string  $templateKey
     * @return $this
     * @throws BindingResolutionException
     */
    public function setDescription(array|string $value, string $templateKey = ''): self
    {
        $this->openGraphService->setDescription($this->parseValue(
            $value,
            $templateKey ? new Description($this->model, $value, $templateKey) : Description::class
        ));

        return $this;
    }

    /**
     * Set the URL of the page.
     *
     * @param  string  $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->openGraphService->setUrl($this->parseValue($url, Url::class));

        return $this;
    }

    /**
     * Set the site name of the page.
     *
     * @param  string  $name
     * @return $this
     */
    public function setSiteName(string $name): self
    {
        $this->openGraphService->setSiteName($this->parseValue($name, SiteName::class));

        return $this;
    }

    /**
     * Set the images of the page.
     *
     * @param  array|string  $images
     * @return $this
     */
    public function setImages(array|string $images): self
    {
        $this->openGraphService->addImages([$this->parseValue($images, Images::class)]);

        return $this;
    }

    /**
     * Set the properties of the page.
     *
     * @param  array  $properties
     * @return $this
     */
    public function setProperties(array $properties): self
    {
        foreach ($this->parseValue($properties, Properties::class) as $item) {
            $this->openGraphService->addProperty(...array_values($item));
        }

        return $this;
    }

    /**
     * Add property to the page.
     *
     * @param  string  $key
     * @param  array|string  $value
     * @return $this
     */
    public function addProperty(string $key,array|string $value): self
    {
        $this->openGraphService->addProperty(
            ...array_values(
                $this->parseValue([compact('key', 'value')], Properties::class)[0]
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
        return $this->modelSeoData['open_graph'] ?? [];
    }
}
