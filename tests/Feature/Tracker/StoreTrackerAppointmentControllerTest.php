<?php

namespace Tests\Feature\Tracker;

use App\Http\Controllers\Tracker\StoreTrackerAppointmentController;
use App\Models\Tracker;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(StoreTrackerAppointmentController::class)]
class StoreTrackerAppointmentControllerTest extends TestCase
{
    #[Test]
    public function test_store_tracker_appointment()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->followingRedirects()->post(route('tracker.appointments.store', $tracker), [
            'appointment_at' => '2026-05-01 10:00:00',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tracker_appointments', [
            'tracker_id' => $tracker->id,
            'appointment_at' => '2026-05-01 10:00:00',
        ]);
    }

    #[Test]
    public function test_store_tracker_appointment_unauthenticated()
    {
        $tracker = Tracker::factory()->create();

        $this->actingAsGuest();
        $response = $this->post(route('tracker.appointments.store', $tracker), [
            'appointment_at' => '2026-05-01 10:00:00',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('tracker_appointments', [
            'tracker_id' => $tracker->id,
        ]);
    }

    #[Test]
    public function test_store_tracker_appointment_forbidden()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create();

        $this->actingAs($user);
        $response = $this->post(route('tracker.appointments.store', $tracker), [
            'appointment_at' => '2026-05-01 10:00:00',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('tracker_appointments', [
            'tracker_id' => $tracker->id,
        ]);
    }

    #[Test]
    public function test_store_tracker_appointment_missing_appointment_at()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->post(route('tracker.appointments.store', $tracker), []);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['appointment_at']);
        $this->assertDatabaseCount('tracker_appointments', 0);
    }

    #[Test]
    public function test_store_tracker_appointment_invalid_date()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->post(route('tracker.appointments.store', $tracker), [
            'appointment_at' => 'not-a-date',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['appointment_at']);
        $this->assertDatabaseCount('tracker_appointments', 0);
    }
}
