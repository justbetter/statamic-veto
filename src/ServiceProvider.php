<?php

namespace JustBetter\Veto;

use JustBetter\Veto\Policies\Asset;
use JustBetter\Veto\Policies\AssetContainer;
use JustBetter\Veto\Policies\AssetFolder;
use JustBetter\Veto\Policies\Collection;
use JustBetter\Veto\Policies\Entry;
use JustBetter\Veto\Policies\GlobalSet;
use JustBetter\Veto\Policies\GlobalSetVariables;
use JustBetter\Veto\Policies\Navigation;
use JustBetter\Veto\Policies\NavigationTree;
use JustBetter\Veto\Policies\Taxonomy;
use JustBetter\Veto\Policies\Term;
use Statamic\Auth\Permission;
use Statamic\Facades\Permission as PermissionFacade;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->registerPolicies();
    }

    protected function registerPolicies(): static
    {
        Collection::bind();
        Entry::bind();
        GlobalSet::bind();
        GlobalSetVariables::bind();
        Navigation::bind();
        NavigationTree::bind();
        AssetContainer::bind();
        AssetFolder::bind();
        Asset::bind();

        Taxonomy::bind();
        Term::bind();

        return $this;
    }

    public function bootAddon(): void
    {
        $this
            ->bootGlobalSetVariablesPermission()
            ->bootEntryPermission()
            ->bootTermPermission()
            ->bootNavigationPermission()
            ->bootAssetContainerPermission();
    }

    protected function bootGlobalSetVariablesPermission(): static
    {
        // @phpstan-ignore-next-line argument.type
        PermissionFacade::group('globals', function (): void {
            $permission = config()->string('statamic-veto.permissions.global');
            PermissionFacade::register($permission, function (Permission $permission): void {
                $permission
                    ->label('Edit all globals')
                    ->description(__('👑 Veto the ability to let this role edit all globals.'));
            });
        });

        return $this;
    }

    protected function bootEntryPermission(): static
    {
        // @phpstan-ignore-next-line argument.type
        PermissionFacade::group('collections', function (): void {
            $permission = config()->string('statamic-veto.permissions.entry');
            PermissionFacade::register($permission, function (Permission $permission): void {
                $permission
                    ->label('Edit all entries')
                    ->description(__('👑 Veto the ability to let this role edit all collection entries.'));
            });
        });

        return $this;
    }

    protected function bootTermPermission(): static
    {
        // @phpstan-ignore-next-line argument.type
        PermissionFacade::group('taxonomies', function (): void {
            $permission = config()->string('statamic-veto.permissions.term');
            PermissionFacade::register($permission, function (Permission $permission): void {
                $permission
                    ->label('Edit all taxonomy terms')
                    ->description(__('👑 Veto the ability to let this role edit all taxonomy terms.'));
            });
        });

        return $this;
    }

    protected function bootNavigationPermission(): static
    {
        // @phpstan-ignore-next-line argument.type
        PermissionFacade::group('navigation', function (): void {
            $permission = config()->string('statamic-veto.permissions.nav');
            PermissionFacade::register($permission, function (Permission $permission): void {
                $permission
                    ->label('Edit all navigation')
                    ->description(__('👑 Veto the ability to let this role edit all navigation.'));
            });
        });

        return $this;
    }

    protected function bootAssetContainerPermission(): static
    {
        // @phpstan-ignore-next-line argument.type
        PermissionFacade::group('assets', function (): void {
            $permission = config()->string('statamic-veto.permissions.asset');
            PermissionFacade::register($permission, function (Permission $permission): void {
                $permission
                    ->label('Edit all asset containers')
                    ->description(__('👑 Veto the ability to let this role edit all assets.'));
            });
        });

        return $this;
    }
}
