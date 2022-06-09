<?php

namespace App\Nova;

use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Comment extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'all' => 'manage comments',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Comment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'post.title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'post.title', 'user.name', 'user.email',
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

            BelongsTo::make('User')
                ->searchable()
                ->withSubtitles()
                ->withoutTrashed(),

            Markdown::make('Content')
                ->rules('required')
                ->alwaysShow()
                ->showOnPreview(),

            MorphTo::make('Commentable')
                ->types([
                    Post::class,
                ])
                ->searchable()
                ->withSubtitles()
                ->withoutTrashed(),

            Select::make('Type')
                ->options([
                    'comment' => 'Comment',
                    'reply' => 'Reply'
                ]),

            Select::make('Status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'spam' => 'Spam',
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
