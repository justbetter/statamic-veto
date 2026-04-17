<?php

namespace JustBetter\Veto\Policies;

use Illuminate\Database\Eloquent\Model;
use Statamic\Auth\User;
use Statamic\Facades\User as UserFacade;
use Statamic\Globals\GlobalSet as StatamicGlobalSet;
use Statamic\Policies\GlobalSetPolicy;

class GlobalSet extends GlobalSetPolicy
{
    /**
     * @param  User|Model  $user
     * @param  StatamicGlobalSet  $set
     */
    public function view($user, $set): bool
    {
        $user = UserFacade::fromUser($user);
        $permission = config()->string('statamic-veto.permissions.global');

        return $user !== null && ($user->hasPermission($permission) || parent::view($user, $set));
    }

    public static function bind(): void
    {
        app()->bind(
            GlobalSetPolicy::class,
            static::class
        );
    }
}
