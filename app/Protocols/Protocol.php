<?php

namespace App\Protocols;

use App\Contracts\Seoable;
use App\Fields\Field;
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
    protected Model|Seoable $model;

    /**
     * Model seo data.
     *
     * @var array
     */
    protected array $modelSeoData;

    /**
     * SEO Meta tools service.
     *
     * @var SEOMeta|null
     */
    protected ?SEOMeta $metaService = null;

    /**
     * Open graph tools service.
     *
     * @var OpenGraph|null
     */
    protected ?OpenGraph $openGraphService = null;

    /**
     * Twitter cards tools service.
     *
     * @var TwitterCards|null
     */
    protected ?TwitterCards $twitterCardService = null;

    /**
     * SEO tools.
     *
     * @var SEOTools|null
     */
    protected ?SEOTools $seoTools = null;

    /**
     * Raw.
     *
     * @var bool
     */
    protected bool $isRaw = false;

    /**
     * Stored Fields Ignored.
     *
     * @var bool
     */
    protected bool $isStoredFieldsIgnores = false;

    /**
     * Constructor.
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
        $this->twitterCardService = resolve('seotools.twitter');
    }

    /**
     * Parse value.
     *
     * @param  array|string  $value
     * @param  Field|string  $type
     * @return mixed
     */
    protected function parseValue(array|string $value, Field|string $type): mixed
    {
        $raw_field = $this->isStoredFieldsIgnores ?
            null :
            $this->getRawFields()[Str::snake(class_basename($type))] ?? null;

        if (!$raw_field && !$this->isRaw) {
            $type = $type instanceof Field ? $type : new $type($value, $this->model);
        }

        return $raw_field ?? ($this->isRaw ? $value : $type->getValue());
    }

    /**
     * Call.
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
     * Open graph.
     *
     * @return \App\Protocols\OpenGraph
     */
    public function opengraph(): \App\Protocols\OpenGraph
    {
        return new \App\Protocols\OpenGraph($this->model);
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
