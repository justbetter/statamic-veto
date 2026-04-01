<?php

namespace JustBetter\Veto\Tests\Policies;

use Illuminate\Support\Facades\Gate;
use JustBetter\Veto\Policies\Navigation as NavigationPolicy;
use JustBetter\Veto\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Statamic\Contracts\Structures\Nav;
use Statamic\Facades\Nav as NavFacade;

class NavigationTest extends TestCase
{
    #[Test]
    public function a_user_with_the_navigation_veto_permission_can_manage_navigation(): void
    {
        $user = $this->setUpUser(config()->string('statamic-veto.permissions.nav'));

        /** @var Nav $navigation */
        $navigation = NavFacade::make('test');

        $this->assertTrue(Gate::forUser($user)->check('index', $navigation));
        $this->assertTrue(Gate::forUser($user)->check('create', $navigation));
        $this->assertTrue(Gate::forUser($user)->check('store', $navigation));
        $this->assertTrue(Gate::forUser($user)->check('configure', $navigation));
        $this->assertTrue(Gate::forUser($user)->check('view', $navigation));
        $this->assertTrue(Gate::forUser($user)->check('edit', $navigation));
        $this->assertTrue(Gate::forUser($user)->check('update', $navigation));
        $this->assertTrue(Gate::forUser($user)->check('delete', $navigation));
    }

    #[Test]
    public function before_falls_back_to_the_parent_policy(): void
    {
        $policy = app(NavigationPolicy::class);

        $this->assertNull($policy->before($this->makeUser()));
    }
}
