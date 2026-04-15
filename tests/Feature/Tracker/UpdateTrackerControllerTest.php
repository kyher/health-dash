<?php

namespace Tests\Feature\Tracker;

use App\Http\Controllers\Tracker\UpdateTrackerController;
use App\Models\Tracker;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UpdateTrackerController::class)]
class UpdateTrackerControllerTest extends TestCase
{
    #[Test]
    public function test_update_tracker()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->followingRedirects()->put(route('tracker.update', $tracker), [
            'name' => 'Updated Tracker',
            'category' => 1,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('trackers', [
            'id' => $tracker->id,
            'name' => 'Updated Tracker',
            'category_id' => 1,
        ]);
    }

    #[Test]
    public function test_update_tracker_unauthenticated()
    {
        $tracker = Tracker::factory()->create();

        $response = $this->put(route('tracker.update', $tracker), [
            'name' => 'Updated Tracker',
            'category' => 1,
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function test_update_tracker_forbidden()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create();

        $this->actingAs($user);
        $response = $this->put(route('tracker.update', $tracker), [
            'name' => 'Updated Tracker',
            'category' => 1,
        ]);

        $response->assertStatus(403);
    }
}
