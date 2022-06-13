<?php

namespace App\Nova;

use App\Nova\Metrics\NewUsers;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Validation\Rules;
use Itsmejoshua\Novaspatiepermissions\Permission;
use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Itsmejoshua\Novaspatiepermissions\Role;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'all' => 'manage users',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\User::class;

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
        'id', 'name', 'email',
    ];

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle(): string
    {
        return "Email: $this->email";
    }

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

            Avatar::make('Avatar')
                ->hide()
                ->hideFromIndex()
                ->hideFromDetail(),

            Images::make('Avatar', 'user_avatar')
                ->conversionOnIndexView('thumb'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),

            HasOne::make('Profile'),
            HasMany::make('Addresses'),

            MorphToMany::make('Roles', 'roles', Role::class)
                ->canSee(function ($request) {
                    return $request->user()->can('view roles');
                }),

            MorphToMany::make('Permissions', 'permissions', Permission::class)
                ->canSee(function ($request) {
                    return $request->user()->can('view permissions');
                })
                ->searchable(),
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
            //new NewUsers
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [
            ExportAsCsv::make()
        ];
    }
}
