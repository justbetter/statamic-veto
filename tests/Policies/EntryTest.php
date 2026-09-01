<?php

namespace JustBetter\Veto\Tests\Policies;

use JustBetter\Veto\Policies\Entry;
use JustBetter\Veto\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Statamic\Entries\Collection;
use Statamic\Entries\Entry as StatamicEntry;
use Statamic\Facades\Collection as CollectionFacade;
use Statamic\Facades\Entry as EntryFacade;

class EntryTest extends TestCase
{
    #[Test]
    public function a_user_can_view(): void
    {
        $permission = config()->string('statamic-veto.permissions.entry');
        $user = $this->setupUser($permission);
        /** @var Collection $collection */
        $collection = CollectionFacade::make('test');
        $collection->save();
        /** @var StatamicEntry $entry */
        $entry = EntryFacade::make();
        $entry->collection($collection);
        $entry->saveQuietly();

        $policy = app(Entry::class);

        $this->assertTrue($policy->view($user, $entry));
    }

    #[Test]
    public function a_user_can_update(): void
    {
        $permission = config()->string('statamic-veto.permissions.entry');
        $user = $this->setupUser($permission);

        /** @var Collection $collection */
        $collection = CollectionFacade::make('test');
        $collection->save();

        /** @var StatamicEntry $entry */
        $entry = EntryFacade::make();
        $entry->collection($collection);
        $entry->saveQuietly();

        $policy = app(Entry::class);

        $this->assertTrue($policy->update($user, $entry));
    }

    #[Test]
    public function a_user_can_edit(): void
    {
        $permission = config()->string('statamic-veto.permissions.entry');
        $user = $this->setupUser($permission);

        /** @var Collection $collection */
        $collection = CollectionFacade::make('test');
        $collection->save();

        /** @var StatamicEntry $entry */
        $entry = EntryFacade::make();
        $entry->collection($collection);
        $entry->saveQuietly();

        $policy = app(Entry::class);

        $this->assertTrue($policy->edit($user, $entry));
    }

    #[Test]
    public function a_user_can_create(): void
    {
        $permission = config()->string('statamic-veto.permissions.entry');
        $user = $this->setupUser($permission);

        /** @var Collection $collection */
        $collection = CollectionFacade::make('test');
        $collection->save();

        $policy = app(Entry::class);

        $this->assertTrue($policy->create($user, $collection));
    }

    #[Test]
    public function a_user_can_store(): void
    {
        $permission = config()->string('statamic-veto.permissions.entry');
        $user = $this->setupUser($permission);

        /** @var Collection $collection */
        $collection = CollectionFacade::make('test');
        $collection->save();

        $policy = app(Entry::class);

        $this->assertTrue($policy->store($user, $collection));
    }

    #[Test]
    public function a_user_can_delete(): void
    {
        $permission = config()->string('statamic-veto.permissions.entry');
        $user = $this->setupUser($permission);

        /** @var Collection $collection */
        $collection = CollectionFacade::make('test');
        $collection->save();

        /** @var StatamicEntry $entry */
        $entry = EntryFacade::make();
        $entry->collection($collection);
        $entry->saveQuietly();

        $policy = app(Entry::class);

        $this->assertTrue($policy->delete($user, $entry));
    }

    #[Test]
    public function a_user_can_publish(): void
    {
        $permission = config()->string('statamic-veto.permissions.entry');
        $user = $this->setupUser($permission);

        /** @var Collection $collection */
        $collection = CollectionFacade::make('test');
        $collection->save();

        /** @var StatamicEntry $entry */
        $entry = EntryFacade::make();
        $entry->collection($collection);
        $entry->saveQuietly();

        $policy = app(Entry::class);

        $this->assertTrue($policy->publish($user, $entry));
    }
}
