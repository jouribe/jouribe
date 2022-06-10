<?php

namespace App\Observers;

use App\Enums\PostState;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function forceDeleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "saved" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function saved(Post $post): void
    {
        $post->state === PostState::Published ? $post->publish() : $post->unpublish();
        $post->state === PostState::Archived ? $post->archive() : $post->unarchive();

        if ($post->state === PostState::Draft) {
            $post->unpublish();
            $post->unarchive();
            $post->featured(false);
        }
    }
}
