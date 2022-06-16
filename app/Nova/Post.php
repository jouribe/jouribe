<?php /** @noinspection PhpUnused */

namespace App\Nova;

use App\Enums\PostState;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableRelation;
use Spatie\TagsField\Tags;
use Suleymanozev\EnumField\Enum;

/**
 * @property mixed $user
 */
class Post extends Resource
{
    use PermissionsBasedAuthTrait;

    /**
     * Permissions based on the user's role.
     *
     * @var array|string[]
     */
    public static array $permissionsForAbilities = [
        'all' => 'mange posts',
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
     * Get the searchable columns for the resource.
     *
     * @return array
     */
    public static function searchableColumns(): array
    {
        return [
            'id',
            'title',
            'content',
            new SearchableRelation('users', 'name'),
            new SearchableRelation('categories', 'name')
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     * @noinspection PhpUnusedParameterInspection
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
                ->rules('required', 'max:500')
                ->hideFromIndex()
                ->alwaysShow(),
            //->stacked(),

            Markdown::make('Content')
                ->rules('required')
                ->preset('commonmark')
                ->showOnPreview()
                ->hideFromIndex()
                ->alwaysShow(),
            //->stacked(),

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

            Enum::make('State')
                ->attach(PostState::class)
                ->sortable()
                ->rules('nullable'),

            DateTime::make('Created At')
                ->filterable()
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Date::make('Schedule', 'schedule_at')
                ->hideFromIndex(),

            Tags::make('Tags')
                ->withLinkToTagResource()
                ->hideFromIndex(),

            Images::make('Banner', 'post_banner')
                ->withResponsiveImages()
                ->rules('nullable')
                ->hideFromIndex()
                ->setFileName(function ($originalFileName, $extension, $model) {
                    return md5($originalFileName).'.'.$extension;
                })
                ->setName(function ($originalFileName, $model) {
                    return md5($originalFileName);
                }),

            Images::make('Cover', 'post_cover')
                ->withResponsiveImages()
                ->rules('nullable')
                ->hideFromIndex()
                ->setFileName(function ($originalFileName, $extension, $model) {
                    return md5($originalFileName).'.'.$extension;
                })
                ->setName(function ($originalFileName, $model) {
                    return md5($originalFileName);
                }),

            MorphOne::make('Seo', 'seoData'),

            MorphMany::make('Comments'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     * @noinspection SenselessMethodDuplicationInspection
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
     * @noinspection SenselessMethodDuplicationInspection
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
     * @noinspection SenselessMethodDuplicationInspection
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
        return [];
    }
}
