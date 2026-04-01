<?php

namespace JustBetter\Veto\Tests\Policies;

use Illuminate\Support\Facades\Gate;
use JustBetter\Veto\Policies\NavigationTree as NavigationTreePolicy;
use JustBetter\Veto\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Statamic\Structures\NavTree;

class NavigationTreeTest extends TestCase
{
    #[Test]
    public function a_user_with_the_navigation_veto_permission_can_manage_navigation_trees(): void
    {
        $user = $this->setUpUser(config()->string('statamic-veto.permissions.nav'));

        /** @var NavTree $tree */
        $tree = app(NavTree::class);

        $this->assertTrue(Gate::forUser($user)->check('view', $tree));
        $this->assertTrue(Gate::forUser($user)->check('edit', $tree));
    }

    #[Test]
    public function before_falls_back_to_the_parent_policy(): void
    {
        $policy = app(NavigationTreePolicy::class);

        $this->assertNull($policy->before($this->makeUser()));
    }
}
