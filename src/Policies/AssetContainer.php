<?php

namespace JustBetter\Veto\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Statamic\Auth\User;
use Statamic\Facades\User as UserFacade;
use Statamic\Policies\AssetContainerPolicy;

class AssetContainer extends AssetContainerPolicy
{
    /**
     * @param  Authenticatable  $user
     * @param  string  $ability
     */
    public function before($user, $ability): ?bool
    {
        /** @var User $user */
        $user = UserFacade::fromUser($user);

        if ($ability === 'delete') {
            return $user->isSuper();
        }

        if ($this->can($user)) {
            return true;
        }

        return parent::before($user, $ability);
    }

    protected function can(Authenticatable $user): bool
    {
        /** @var User $user */
        $user = UserFacade::fromUser($user);

        return $user->hasPermission(
            config()->string('statamic-veto.permissions.asset')
        );
    }

    public static function bind(): void
    {
        app()->bind(
            AssetContainerPolicy::class,
            static::class
        );
    }
}
