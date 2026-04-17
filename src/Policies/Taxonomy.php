<?php

namespace JustBetter\Veto\Policies;

use Illuminate\Database\Eloquent\Model;
use Statamic\Auth\User;
use Statamic\Facades\User as UserFacade;
use Statamic\Policies\TaxonomyPolicy;

class Taxonomy extends TaxonomyPolicy
{
    /**
     * @param  User|Model  $user
     * @param  string  $taxonomy
     */
    public function view($user, $taxonomy): bool
    {
        $user = UserFacade::fromUser($user);
        $permission = config()->string('statamic-veto.permissions.term');

        return $user !== null && ($user->hasPermission($permission) || parent::view($user, $taxonomy));
    }

    public static function bind(): void
    {
        app()->bind(
            TaxonomyPolicy::class,
            static::class
        );
    }
}
