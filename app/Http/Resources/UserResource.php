<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin User */
class UserResource extends JsonResource
{
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public bool $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape([
        'id' => 'int',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => "\Illuminate\Support\Carbon|null",
        'avatar' => 'array|string|string[]',
        'posts' => "\Illuminate\Support\Collection",
        'remember_token' => 'string|null',
        'created_at' => "\Illuminate\Support\Carbon|null",
        'updated_at' => "\Illuminate\Support\Carbon|null",
        'deleted_at' => "\Illuminate\Support\Carbon|null",
    ])]
 public function toArray($request): array
 {
     return [
         'id' => $this->id,
         'name' => $this->name,
         'email' => $this->email,
         'email_verified_at' => $this->email_verified_at,
         'avatar' => $this->avatar,
         //'posts' => $this->posts,
         //'remember_token' => $this->when($request->user()->isAdmin(), $this->remember_token),
         'created_at' => $this->created_at,
         'updated_at' => $this->updated_at,
         'deleted_at' => $this->deleted_at,
     ];
 }
}
