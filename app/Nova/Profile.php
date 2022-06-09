<?php

namespace App\Nova;

use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use Stepanenko3\NovaJson\JSON;

class Profile extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'all' => 'manage profiles',
        'view' => 'view profiles',
        'create' => 'create profiles',
        'update' => 'update profiles',
        'delete' => 'delete profiles',
        'restore' => 'restore profiles',
        'forceDelete' => 'destroy profiles',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Profile::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'user.name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'users.name', 'users.email'
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
            BelongsTo::make('User')
                ->searchable(),

            Date::make('Birthday'),

            Select::make('Gender')
                ->options([
                    'female' => 'Female',
                    'male' => 'Male',
                    'other' => 'Other'
                ]),

            JSON::make('Socials', [
                URL::make('Facebook'),
                URL::make('Twitter'),
                URL::make('Github'),
                URL::make('Web'),
            ])
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
