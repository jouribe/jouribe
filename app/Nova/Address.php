<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Address extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'all' => 'manage addresses',
        'view' => 'view addresses',
        'create' => 'create addresses',
        'update' => 'update addresses',
        'delete' => 'delete addresses',
        'restore' => 'restore addresses',
        'forceDelete' => 'destroy addresses',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Address::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'street';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'street', 'city', 'state', 'zip',
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
            ID::make()->sortable(),

            Select::make('Type', 'type')
                ->options([
                    'home' => 'Home',
                    'work' => 'Work',
                ])
                ->displayUsingLabels(),

            Text::make('Street')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('City')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('State')
                ->sortable()
                ->rules('nullable', 'max:255'),

            Text::make('Zip')
                ->sortable()
                ->rules('nullable', 'max:255'),
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
