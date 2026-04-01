<?php

namespace JustBetter\Veto\Tests\Policies;

use Illuminate\Support\Facades\Gate;
use JustBetter\Veto\Policies\AssetFolder as AssetFolderPolicy;
use JustBetter\Veto\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Statamic\Assets\AssetContainer;
use Statamic\Facades\AssetContainer as AssetContainerFacade;

class AssetFolderTest extends TestCase
{
    #[Test]
    public function a_user_with_the_asset_veto_permission_can_manage_asset_folders(): void
    {
        $user = $this->setUpUser(config()->string('statamic-veto.permissions.asset'));

        /** @var AssetContainer $container */
        $container = AssetContainerFacade::make('test')->title('Test');
        $folder = $container->assetFolder('images');

        $this->assertTrue(Gate::forUser($user)->check('create', $container));
        $this->assertTrue(Gate::forUser($user)->check('move', $folder));
        $this->assertTrue(Gate::forUser($user)->check('rename', $folder));
        $this->assertTrue(Gate::forUser($user)->check('delete', $folder));
    }

    #[Test]
    public function before_falls_back_to_the_parent_policy(): void
    {
        $policy = app(AssetFolderPolicy::class);

        $this->assertNull($policy->before($this->makeUser()));
    }
}
