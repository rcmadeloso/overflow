<?php

namespace App\Providers\Cache;

use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Cache;


class AuthUser extends EloquentUserProvider
{

    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, User::class);
    }

    public function retrieveById($identifier)
    {
        return Cache::get("user.$identifier") ?? parent::retrieveById($identifier);
    }
}