<?php

namespace Tests\Feature\Tracker;

use App\Http\Controllers\Tracker\DeleteTrackerController;
use App\Models\Tracker;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DeleteTrackerController::class)]
class DeleteTrackerControllerTest extends TestCase
{
    #[Test]
    public function test_destroy_tracker()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->followingRedirects()->delete(route('tracker.destroy', $tracker));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('trackers', [
            'id' => $tracker->id,
        ]);
    }

    #[Test]
    public function test_destroy_tracker_unauthenticated()
    {
        $tracker = Tracker::factory()->create();

        $response = $this->delete(route('tracker.destroy', $tracker));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function test_destroy_tracker_forbidden()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create();

        $this->actingAs($user);
        $response = $this->delete(route('tracker.destroy', $tracker));

        $response->assertStatus(403);
    }
}
