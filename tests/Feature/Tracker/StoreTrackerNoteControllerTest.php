<?php

namespace Tests\Feature\Tracker;

use App\Http\Controllers\Tracker\StoreTrackerNoteController;
use App\Models\Tracker;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(StoreTrackerNoteController::class)]
class StoreTrackerNoteControllerTest extends TestCase
{
    #[Test]
    public function test_store_tracker_note()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->followingRedirects()->post(route('tracker.notes.store', $tracker), [
            'content' => 'This is a test note.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tracker_notes', [
            'tracker_id' => $tracker->id,
            'content' => 'This is a test note.',
        ]);
    }

    #[Test]
    public function test_store_tracker_note_unauthenticated()
    {
        $tracker = Tracker::factory()->create();

        $this->actingAsGuest();
        $response = $this->post(route('tracker.notes.store', $tracker), [
            'content' => 'This is a test note.',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('tracker_notes', [
            'tracker_id' => $tracker->id,
        ]);
    }

    #[Test]
    public function test_store_tracker_note_forbidden()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create();

        $this->actingAs($user);
        $response = $this->post(route('tracker.notes.store', $tracker), [
            'content' => 'This is a test note.',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('tracker_notes', [
            'tracker_id' => $tracker->id,
        ]);
    }

    #[Test]
    public function test_store_tracker_note_missing_content()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->post(route('tracker.notes.store', $tracker), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['content']);
        $this->assertDatabaseCount('tracker_notes', 0);
    }

    #[Test]
    public function test_store_tracker_note_content_too_long()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);
        $longContent = str_repeat('a', 1001);

        $this->actingAs($user);
        $response = $this->post(route('tracker.notes.store', $tracker), [
            'content' => $longContent,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['content']);
        $this->assertDatabaseCount('tracker_notes', 0);
    }

    #[Test]
    public function test_store_tracker_note_at_max_length()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);
        $maxContent = str_repeat('a', 1000);

        $this->actingAs($user);
        $response = $this->followingRedirects()->post(route('tracker.notes.store', $tracker), [
            'content' => $maxContent,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tracker_notes', [
            'tracker_id' => $tracker->id,
            'content' => $maxContent,
        ]);
    }
}
