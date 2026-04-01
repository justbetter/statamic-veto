<?php

namespace JustBetter\Veto\Tests\Policies;

use Illuminate\Support\Facades\Gate;
use JustBetter\Veto\Policies\Asset as AssetPolicy;
use JustBetter\Veto\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Statamic\Assets\Asset;
use Statamic\Facades\Asset as AssetFacade;
use Statamic\Facades\AssetContainer as AssetContainerFacade;

class AssetTest extends TestCase
{
    #[Test]
    public function a_user_with_the_asset_veto_permission_can_manage_assets(): void
    {
        $user = $this->setUpUser(config()->string('statamic-veto.permissions.asset'));
        $container = AssetContainerFacade::make('test')->title('Test');

        /** @var Asset $asset */
        $asset = AssetFacade::make();
        $asset->container($container);
        $asset->path('images/test.jpg');
        $asset->syncOriginal();

        $this->assertTrue(Gate::forUser($user)->check('view', $asset));
        $this->assertTrue(Gate::forUser($user)->check('edit', $asset));
        $this->assertTrue(Gate::forUser($user)->check('store', [$asset, $container]));
        $this->assertTrue(Gate::forUser($user)->check('move', $asset));
        $this->assertTrue(Gate::forUser($user)->check('rename', $asset));
        $this->assertTrue(Gate::forUser($user)->check('delete', $asset));
        $this->assertTrue(Gate::forUser($user)->check('replace', $asset));
        $this->assertTrue(Gate::forUser($user)->check('reupload', $asset));
    }

    #[Test]
    public function before_falls_back_to_the_parent_policy(): void
    {
        $policy = app(AssetPolicy::class);

        $this->assertNull($policy->before($this->makeUser()));
    }
}
