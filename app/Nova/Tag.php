<?php

namespace App\Nova;

use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tag extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'all' => 'manage tags',
        'viewAny' => 'view tags',
        'view' => 'view tags',
        'create' => 'create tags',
        'update' => 'update tags',
        'delete' => 'delete tags',
        'restore' => 'restore tags',
        'forceDelete' => 'destroy tags',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \Spatie\Tags\Tag::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
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
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [
            //
        ];
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
