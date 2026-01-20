<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;
    // However, for basic model auditing, we just need the tables.
    // IMPORTANT: Spatie roles/permissions tables might be needed if models use them on boot,
    // but Auditing usually works independently.

    // We'll perform manual cleanup or just rely on factory creation.

    public function test_audit_log_is_created_when_updating_student()
    {
        // 1. Create a student (this might create an audit log for 'created' event if configured)
        $student = Student::factory()->create();

        // 2. Login as admin so we have a 'user_id' responsible for the change (optional depending on config)
        $admin = User::factory()->create();
        $this->actingAs($admin);

        // 3. Update the student
        $oldName = $student->name;
        $newName = 'Updated Name ' . uniqid();

        $student->update(['name' => $newName]);

        // 4. Check 'audits' table
        $this->assertDatabaseHas('audits', [
            'auditable_type' => Student::class,
            'auditable_id' => $student->id,
            'event' => 'updated',
            'user_id' => $admin->id,
        ]);

        // Optionally verification of old/new values in 'old_values' and 'new_values' json columns
        // This is harder to do with simple assertDatabaseHas on JSON fields, so we can fetch the audit.

        $audit = \OwenIt\Auditing\Models\Audit::where('auditable_type', Student::class)
            ->where('auditable_id', $student->id)
            ->where('event', 'updated')
            ->latest()
            ->first();

        $this->assertNotNull($audit);
        $this->assertEquals($admin->id, $audit->user_id);
    }

    public function test_audit_log_created_for_payment_creation()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        // 1. Create a payment
        $payment = Payment::factory()->create();

        // 2. Check for 'created' audit log
        $this->assertDatabaseHas('audits', [
            'auditable_type' => Payment::class,
            'auditable_id' => $payment->id,
            'event' => 'created',
            'user_id' => $admin->id, // If payment factory doesn't auth, might be null. 
            // But we did actingAs, so web requests would capture it.
            // Model events via factory *might* not capture user if not set in resolver,
            // but standard Laravel Auditing tries to resolve Auth::user().
        ]);
    }
}
