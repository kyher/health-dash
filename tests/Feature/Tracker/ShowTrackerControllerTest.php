<?php

namespace Tests\Feature\Tracker;

use App\Http\Controllers\Tracker\ShowTrackerController;
use App\Models\Tracker;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ShowTrackerController::class)]
class ShowTrackerControllerTest extends TestCase
{
    #[Test]
    public function test_show_tracker()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->get(route('tracker.show', $tracker));

        $response->assertStatus(200);
        $response->assertInertia(
            fn ($page) => $page
                ->component('ShowTracker')
                ->has(
                    'tracker',
                    fn ($t) => $t
                        ->where('id', $tracker->id)
                        ->where('name', $tracker->name)
                        ->etc()
                )
                ->has('categories')
        );
    }

    #[Test]
    public function test_show_tracker_unauthenticated()
    {
        $tracker = Tracker::factory()->create();

        $response = $this->get(route('tracker.show', $tracker));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function test_show_tracker_forbidden()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create();

        $this->actingAs($user);
        $response = $this->get(route('tracker.show', $tracker));

        $response->assertStatus(403);
    }
}
