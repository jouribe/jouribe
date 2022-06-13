<?php

namespace App\Protocols;

use App\Contracts\Seoable;
use App\Fields\Field;
use App\Protocols\OpenGraph as OpenGraphs;
use Artesaos\SEOTools\OpenGraph;
use Artesaos\SEOTools\SEOMeta;
use Artesaos\SEOTools\SEOTools;
use Artesaos\SEOTools\TwitterCards;
use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class Protocol
{
    /**
     * Model.
     *
     * @var Model|Seoable
     */
    protected Seoable|Model $model;

    /**
     * Seo protocol model.
     *
     * @var array
     */
    protected array $modelSeoData;

    /**
     * Meta service.
     *
     * @var SEOMeta|null
     */
    protected ?SEOMeta $metaService = null;

    /**
     * Open graph service.
     *
     * @var OpenGraph|null
     */
    protected ?OpenGraph $openGraphService = null;

    /**
     * Twitter cards service.
     *
     * @var TwitterCards|null
     */
    protected ?TwitterCards $twitterCardService = null;

    /**
     * Seo tools.
     *
     * @var SEOTools|null
     */
    protected ?SEOTools $seoTools = null;

    /**
     * Raw seo data.
     *
     * @var bool
     */
    protected bool $isRaw = false;

    /**
     * Stored seo data.
     *
     * @var bool
     */
    protected bool $isStoredFieldsIgnores = false;

    /**
     * Protocol constructor.
     *
     * @param  Seoable  $model
     */
    public function __construct(Seoable $model)
    {
        $this->model = $model;
        $this->modelSeoData = (array) $this->model->getSeoData();

        $this->seoTools = resolve('seotools');
        $this->metaService = resolve('seotools.metatags');
        $this->openGraphService = resolve('seotools.opengraph');
        $this->twitterCardService = resolve('seotools.twitter'); //TODO: resolve method ability
    }

    /**
     * Parse seo data.
     *
     * @param  array|string  $value
     * @param  Field|string  $type
     * @return array|mixed|string
     */
    protected function parseValue(array|string $value, Field|string $type): mixed
    {
        $raw_field = $this->isStoredFieldsIgnores ?
            null :
            $this->getRawFields()[Str::snake(class_basename($type))] ?? null;

        if (! $raw_field && ! $this->isRaw) {
            $type = $type instanceof Field ? $type : new $type($value, $this->model);
        }

        return $raw_field ?? ($this->isRaw ? $value : $type->getValue());
    }

    /**
     * Call method.
     *
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (Str::endsWith($name, 'Raw')) {
            $this->isRaw = true;
            $this->{mb_strstr($name, 'Raw', true)}(...$arguments);
            $this->isRaw = false;

            return $this;
        }

        throw new BadMethodCallException;
    }

    /**
     * Twitter card.
     *
     * @return TwitterCard
     */
    public function twitter(): TwitterCard
    {
        return new TwitterCard($this->model);
    }

    /**
     * Open Graph.
     *
     * @return \App\Protocols\OpenGraph
     */
    public function opengraph(): OpenGraphs
    {
        return new OpenGraphs($this->model);
    }

    /**
     * Meta.
     *
     * @return Meta
     */
    public function meta(): Meta
    {
        return new Meta($this->model);
    }

    /**
     * Ignore stored fields.
     *
     * @return $this
     */
    public function ignoreStored()
    {
        $this->isStoredFieldsIgnores = true;

        return $this;
    }

    /**
     * Get raw fields.
     *
     * @return array
     */
    abstract protected function getRawFields(): array;
}
