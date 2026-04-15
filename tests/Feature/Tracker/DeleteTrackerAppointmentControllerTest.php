<?php

namespace Tests\Feature\Tracker;

use App\Http\Controllers\Tracker\DeleteTrackerAppointmentController;
use App\Models\Tracker;
use App\Models\TrackerAppointment;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DeleteTrackerAppointmentController::class)]
class DeleteTrackerAppointmentControllerTest extends TestCase
{
    #[Test]
    public function test_delete_tracker_appointment()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);
        $appointment = TrackerAppointment::factory()->create(['tracker_id' => $tracker->id]);

        $this->actingAs($user);
        $response = $this->followingRedirects()->delete(route('tracker.appointments.destroy', [$tracker, $appointment]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tracker_appointments', ['id' => $appointment->id]);
    }

    #[Test]
    public function test_delete_tracker_appointment_unauthenticated()
    {
        $tracker = Tracker::factory()->create();
        $appointment = TrackerAppointment::factory()->create(['tracker_id' => $tracker->id]);

        $this->actingAsGuest();
        $response = $this->delete(route('tracker.appointments.destroy', [$tracker, $appointment]));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('tracker_appointments', ['id' => $appointment->id]);
    }

    #[Test]
    public function test_delete_tracker_appointment_forbidden()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create();
        $appointment = TrackerAppointment::factory()->create(['tracker_id' => $tracker->id]);

        $this->actingAs($user);
        $response = $this->delete(route('tracker.appointments.destroy', [$tracker, $appointment]));

        $response->assertStatus(403);
        $this->assertDatabaseHas('tracker_appointments', ['id' => $appointment->id]);
    }

    #[Test]
    public function test_delete_tracker_appointment_mismatched_tracker()
    {
        $user = User::factory()->create();
        $tracker = Tracker::factory()->create(['user_id' => $user->id]);
        $otherTracker = Tracker::factory()->create(['user_id' => $user->id]);
        $appointment = TrackerAppointment::factory()->create(['tracker_id' => $otherTracker->id]);

        $this->actingAs($user);
        $response = $this->delete(route('tracker.appointments.destroy', [$tracker, $appointment]));

        $response->assertStatus(404);
        $this->assertDatabaseHas('tracker_appointments', ['id' => $appointment->id]);
    }
}
