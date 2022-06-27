<?php

namespace App\Models;

use App\Enums\CommentStatus;
use App\Enums\CommentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'user_id',
        'commentable_id',
        'commentable_type',
        'status',
        'type',
        'parent_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'status' => CommentStatus::class,
        'type' => CommentType::class,
    ];

    /**
     * Comments to a commentable.
     *
     * @return MorphTo
     * @noinspection PhpUnused
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * User who created the comment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
