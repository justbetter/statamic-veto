<?php

namespace JustBetter\Veto\Policies;

use Illuminate\Database\Eloquent\Model;
use Statamic\Auth\User;
use Statamic\Contracts\Auth\User as UserContract;
use Statamic\Facades\User as UserFacade;
use Statamic\Policies\TermPolicy;
use Statamic\Sites\Site;
use Statamic\Taxonomies\Taxonomy;
use Statamic\Taxonomies\Term as StatamicTerm;

class Term extends TermPolicy
{
    /**
     * @param  User|Model  $user
     * @param  StatamicTerm  $term
     */
    public function view($user, $term): bool
    {
        $user = UserFacade::fromUser($user);

        return $user !== null && ($this->can($user) || parent::view($user, $term));
    }

    /**
     * @param  User|Model  $user
     * @param  StatamicTerm  $term
     */
    public function edit($user, $term): bool
    {
        $user = UserFacade::fromUser($user);

        return $user !== null && ($this->can($user) || parent::edit($user, $term));
    }

    /**
     * @param  User|Model  $user
     * @param  StatamicTerm  $term
     */
    public function update($user, $term): bool
    {
        $user = UserFacade::fromUser($user);

        return $user !== null && ($this->can($user) || parent::update($user, $term));
    }

    /**
     * @param  User|Model  $user
     * @param  Taxonomy  $taxonomy
     * @param  Site|null  $site
     */
    public function create($user, $taxonomy, $site = null): bool
    {
        $user = UserFacade::fromUser($user);

        return $user !== null && ($this->can($user) || parent::create($user, $taxonomy, $site));
    }

    protected function can(UserContract $user): bool
    {
        $permission = config()->string('statamic-veto.permissions.term');

        return $user->hasPermission($permission);
    }

    public static function bind(): void
    {
        app()->bind(
            TermPolicy::class,
            static::class
        );
    }
}
