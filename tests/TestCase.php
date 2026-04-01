<?php

namespace JustBetter\Veto\Tests;

use JustBetter\Veto\ServiceProvider;
use Statamic\Auth\User;
use Statamic\Facades\Role;
use Statamic\Facades\User as UserFacade;
use Statamic\Testing\AddonTestCase;
use Statamic\Testing\Concerns\PreventsSavingStacheItemsToDisk;

class TestCase extends AddonTestCase
{
    use PreventsSavingStacheItemsToDisk;

    protected string $addonServiceProvider = ServiceProvider::class;

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('statamic.editions.pro', true);
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:7tG0yY7g3QkFrQ+Vk4EBSbcT8D9C4/5Dph1dNRjh6WU=');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpUser(string $permission): User
    {
        $user = $this->makeUser();

        $role = Role::make('::role::')->save();
        $role->addPermission($permission)->save();
        $user->assignRole($role);

        return $user;
    }

    protected function makeUser(): User
    {
        /** @var User $user */
        $user = UserFacade::make();
        $user->data([
            'email' => 'example@example.com',
        ])->save();

        return $user;
    }
}
