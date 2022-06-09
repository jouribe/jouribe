<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

class Post extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'viewAny' => 'view posts',
        'view' => 'view posts',
        'create' => 'create posts',
        'update' => 'update posts',
        'delete' => 'delete posts',
        'restore' => 'restore posts',
        'forceDelete' => 'destroy posts',
        'addComment' => 'add post on comments',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['user', 'category'];

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
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'content'
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

            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),

            Markdown::make('Summary')
                ->sortable()
                ->rules('required', 'max:255')
                ->hideFromIndex()
                ->alwaysShow(),

            Markdown::make('Content')
                ->rules('required')
                ->preset('commonmark')
                ->showOnPreview()
                ->hideFromIndex()
                ->alwaysShow(),

            BelongsTo::make('User')
                ->searchable()
                ->withSubtitles()
                ->rules('required')
                ->hideFromIndex()
                ->withoutTrashed()
                ->showCreateRelationButton(),

            BelongsTo::make('Category')
                ->searchable()
                ->rules('required')
                ->withoutTrashed()
                ->sortable()
                ->showCreateRelationButton()
                ->display('name'),

            Boolean::make('Featured')
                ->rules('nullable')
                ->sortable(),

            Boolean::make('Draft')
                ->rules('nullable')
                ->sortable(),

            Date::make('Published At')
                ->rules('nullable')
                ->sortable(),

            DateTime::make('Created At')
                ->filterable()
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Tags::make('Tags')
                ->withLinkToTagResource()
                ->hideFromIndex(),

            Images::make('Cover', 'post_cover')
                ->conversionOnIndexView('thumb') // conversion used to display the image
                ->enableExistingMedia()
                ->hideFromIndex(),

            MorphMany::make('Comments'),
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
