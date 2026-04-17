<?php

namespace JustBetter\Veto\Policies;

use Illuminate\Database\Eloquent\Model;
use Statamic\Auth\User;
use Statamic\Entries\Collection as StatamicCollection;
use Statamic\Facades\User as UserFacade;
use Statamic\Policies\CollectionPolicy;

class Collection extends CollectionPolicy
{
    /**
     * @param  User|Model  $user
     * @param  StatamicCollection  $collection
     */
    public function view($user, $collection): bool
    {
        $user = UserFacade::fromUser($user);
        $permission = config()->string('statamic-veto.permissions.entry');

        return $user !== null && ($user->hasPermission($permission) || parent::view($user, $collection));
    }

    public static function bind(): void
    {
        app()->bind(
            CollectionPolicy::class,
            static::class
        );
    }
}
