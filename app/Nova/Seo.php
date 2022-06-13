<?php

namespace App\Nova;

use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Stepanenko3\NovaJson\JSON;

class Seo extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'all' => 'manage seos'
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Seo::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'meta.title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'meta.title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable()
                ->hide(),

            MorphTo::make('Seoable')
                ->types([
                    Post::class,
                    Project::class
                ])
                ->searchable()
                ->withSubtitles()
                ->withoutTrashed(),

            JSON::make('Meta', [
                Text::make('Title')
                    ->rules('required', 'max:70'),

                Textarea::make('Description')
                    ->rules('required', 'max:160')
                    ->alwaysShow(),

                Text::make('Keywords')
                    ->rules('required', 'max:160'),
            ]),

            /*JSON::make('Open Graph'),

            JSON::make('Twitter'),*/
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
