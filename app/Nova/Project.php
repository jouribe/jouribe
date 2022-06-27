<?php

namespace App\Nova;

use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

class Project extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'all' => 'manage projects',
        'viewAny' => 'view projects',
        'view' => 'view projects',
        'create' => 'create projects',
        'update' => 'update projects',
        'delete' => 'delete projects',
        'restore' => 'restore projects',
        'forceDelete' => 'destroy projects',
        'addComment' => 'add project on comments',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Project::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle(): string
    {
        return "Author: {$this->user->name}";
    }

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['user', 'category'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'slug', 'summary', 'description',
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

            Text::make('Name')
                ->sortable()
                ->rules('required'),

            Markdown::make('Summary')
                ->sortable()
                ->rules('required', 'max:500')
                ->hideFromIndex()
                ->alwaysShow(),

            Markdown::make('Description')
                ->rules('required')
                ->showOnPreview()
                ->hideFromIndex()
                ->alwaysShow(),

            Text::make('Url')
                ->sortable()
                ->rules('nullable'),

            BelongsTo::make('Category')
                ->searchable()
                ->withoutTrashed()
                ->sortable()
                ->showCreateRelationButton()
                ->display('name'),

            BelongsTo::make('User')
                ->searchable()
                ->withSubtitles()
                ->rules('required')
                ->hideFromIndex()
                ->withoutTrashed()
                ->showCreateRelationButton(),

            Tags::make('Tags')
                ->withLinkToTagResource()
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available on the entity.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available on the entity.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available on the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available on the entity.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
