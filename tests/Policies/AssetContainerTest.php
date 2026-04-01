<?php

namespace JustBetter\Veto\Tests\Policies;

use Illuminate\Support\Facades\Gate;
use JustBetter\Veto\Policies\AssetContainer as AssetContainerPolicy;
use JustBetter\Veto\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Statamic\Facades\AssetContainer as AssetContainerFacade;

class AssetContainerTest extends TestCase
{
    #[Test]
    public function a_user_with_the_asset_veto_permission_can_manage_asset_containers(): void
    {
        $user = $this->setUpUser(config()->string('statamic-veto.permissions.asset'));
        $container = AssetContainerFacade::make('test')->title('Test');

        $this->assertTrue(Gate::forUser($user)->check('index', $container));
        $this->assertTrue(Gate::forUser($user)->check('create', $container));
        $this->assertTrue(Gate::forUser($user)->check('view', $container));
        $this->assertTrue(Gate::forUser($user)->check('edit', $container));
        $this->assertTrue(Gate::forUser($user)->check('update', $container));
        $this->assertTrue(Gate::forUser($user)->check('delete', $container));
    }

    #[Test]
    public function before_falls_back_to_the_parent_policy_without_the_veto_permission(): void
    {
        $policy = app(AssetContainerPolicy::class);

        $this->assertNull($policy->before($this->makeUser(), 'view'));
    }
}
