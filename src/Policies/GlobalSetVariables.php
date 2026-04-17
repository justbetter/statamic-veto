<?php

namespace JustBetter\Veto\Policies;

use Illuminate\Database\Eloquent\Model;
use Statamic\Auth\User;
use Statamic\Facades\User as UserFacade;
use Statamic\Policies\GlobalSetVariablesPolicy;

class GlobalSetVariables extends GlobalSetVariablesPolicy
{
    /**
     * @param  User|Model  $user
     * @param  string  $entry
     */
    public function edit($user, $entry): bool
    {
        $user = UserFacade::fromUser($user);
        $permission = config()->string('statamic-veto.permissions.global');

        return $user !== null && ($user->hasPermission($permission) || parent::edit($user, $entry));
    }

    public static function bind(): void
    {
        app()->bind(
            GlobalSetVariablesPolicy::class,
            static::class
        );
    }
}
