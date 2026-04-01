<?php

namespace JustBetter\Veto\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Statamic\Auth\User;
use Statamic\Facades\User as UserFacade;
use Statamic\Policies\AssetFolderPolicy;

class AssetFolder extends AssetFolderPolicy
{
    /**
     * @param  Authenticatable  $user
     */
    public function before($user): ?bool
    {
        if ($this->can($user)) {
            return true;
        }

        return parent::before($user);
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
            AssetFolderPolicy::class,
            static::class
        );
    }
}
