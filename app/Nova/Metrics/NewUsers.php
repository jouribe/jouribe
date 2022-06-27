<?php

namespace App\Nova\Metrics;

use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult as ValueResultAlias;

class NewUsers extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  NovaRequest  $request
     * @return ValueResultAlias
     */
    public function calculate(NovaRequest $request): ValueResultAlias
    {
        return $this->count($request, User::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    #[ArrayShape([
        30 => 'string',
        60 => 'string',
        365 => 'string',
        'TODAY' => 'string',
        'YESTERDAY' => 'string',
        'MTD' => 'string',
        'QTD' => 'string',
        'YTD' => 'string',
    ])]
    public function ranges(): array
    {
        return [
            30 => '30 Days',
            60 => '60 Days',
            365 => '365 Days',
            'TODAY' => 'Today',
            'YESTERDAY' => 'Yesterday',
            'MTD' => 'Month To Date',
            'QTD' => 'Quarter To Date',
            'YTD' => 'Year To Date',
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'new-users';
    }
}
