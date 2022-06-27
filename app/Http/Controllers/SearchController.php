<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MeiliSearch\Endpoints\Indexes;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        return new JsonResponse(
            data: Post::search(
                query: $request->get('search'),
                callback: static function (Indexes $meilisearch, string $query, array $options) use ($request) {
                    $options['filter'] = ['category.slug = category-4'];

                    return $meilisearch->search(
                        query: $query,
                        options: $options
                    );
                },
            )->get(),
            status: 200,
        );
    }
}
