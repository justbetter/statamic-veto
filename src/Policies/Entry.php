<?php

namespace JustBetter\Veto\Policies;

use Illuminate\Database\Eloquent\Model;
use Statamic\Auth\User;
use Statamic\Contracts\Auth\User as UserContract;
use Statamic\Entries\Collection;
use Statamic\Entries\Entry as StatamicEntry;
use Statamic\Facades\User as UserFacade;
use Statamic\Policies\EntryPolicy;
use Statamic\Sites\Site;

class Entry extends EntryPolicy
{
    /**
     * @param  User|Model  $user
     * @param  StatamicEntry  $entry
     */
    public function edit($user, $entry): bool
    {
        $user = UserFacade::fromUser($user);

        return $user !== null && ($this->can($user) || parent::edit($user, $entry));
    }

    /**
     * @param  User|Model  $user
     * @param  StatamicEntry  $entry
     */
    public function update($user, $entry): bool
    {
        $user = UserFacade::fromUser($user);

        return $user !== null && ($this->can($user) || parent::update($user, $entry));
    }

    /**
     * @param  User|Model  $user
     * @param  Collection  $collection
     * @param  Site|null  $site
     */
    public function create($user, $collection, $site = null): bool
    {
        $user = UserFacade::fromUser($user);

        return $user !== null && ($this->can($user) || parent::create($user, $collection, $site));
    }

    /**
     * @param  User|Model  $user
     * @param  Collection  $collection
     * @param  Site|null  $site
     */
    public function store($user, $collection, $site = null): bool
    {
        $user = UserFacade::fromUser($user);

        return $user !== null && ($this->can($user) || parent::store($user, $collection, $site));
    }

    protected function can(UserContract $user): bool
    {
        $permission = config()->string('statamic-veto.permissions.entry');

        return $user->hasPermission($permission);
    }

    public static function bind(): void
    {
        app()->bind(
            EntryPolicy::class,
            static::class
        );
    }
}
