<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;

class Logout
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $guard = Auth::guard();

        $user = $guard->user();
        $guard->logout();

        return $user;
    }
}
