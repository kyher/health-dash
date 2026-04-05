<?php

namespace Tests\Feature\Tracker;

use App\Http\Controllers\TrackerController;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(TrackerController::class)]
class TrackerControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function test_store_tracker()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->followingRedirects()->post(route('tracker.store'), [
            'name' => 'New Tracker',
            'category' => 1,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('trackers', [
            'name' => 'New Tracker',
            'category_id' => 1,
        ]);
    }

    #[Test]
    public function test_store_tracker_unauthenticated()
    {
        $this->actingAsGuest();
        $response = $this->post(route('tracker.store'), [
            'name' => 'New Tracker',
            'category' => 1,
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function test_store_tracker_invalid_category()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->post(route('tracker.store'), [
            'name' => 'New Tracker',
            'category' => 999,
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['category']);
        $this->assertDatabaseMissing('trackers', [
            'name' => 'New Tracker',
            'category_id' => 999,
        ]);
    }

    #[Test]
    public function test_store_tracker_missing_name()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->post(route('tracker.store'), [
            'category' => 1,
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('trackers', 0);
    }

    #[Test]
    public function test_store_tracker_name_too_long()
    {
        $this->actingAs(User::factory()->create());
        $longName = str_repeat('a', 300);
        $response = $this->post(route('tracker.store'), [
            'name' => $longName,
            'category' => 1,
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('trackers', [
            'name' => $longName,
        ]);
    }

    #[Test]
    public function test_store_tracker_missing_category()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->post(route('tracker.store'), [
            'name' => 'No Category',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['category']);
        $this->assertDatabaseMissing('trackers', [
            'name' => 'No Category',
        ]);
    }
}
