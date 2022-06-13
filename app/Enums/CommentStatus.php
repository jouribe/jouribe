<?php

namespace App\Enums;

enum CommentStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Spam = 'spam';
}
