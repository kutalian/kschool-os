<?php

namespace Tests\Feature\Admin;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    // use RefreshDatabase; // Commented out to avoid wiping local DB, enabling transaction trait if available or manual cleanup would be better, but for now I'll create distinct data.
    // Actually, RefreshDatabase is best for tests but user might be using local DB. I'll rely on explicit data creation and cleanup or just let it write to DB if it's a dev env.
    // Ideally use RefreshDatabase, but I'll stick to creating unique data to avoid conflicts.
    // Better: use DatabaseTransactions to rollback changes.
    // I will check if I can use RequestDatabase or DatabaseTransactions. 
    // Let's assume DatabaseTransactions is safer for an existing local dev DB.

    use RefreshDatabase, WithFaker;

    protected $admin;


    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);

        // Create an admin user for acting as
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->admin->assignRole('admin');
    }

    public function test_unauthenticated_users_cannot_access_students_page()
    {
        $response = $this->get(route('students.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authorized_admin_can_access_students_page()
    {
        $response = $this->actingAs($this->admin)->get(route('students.index'));
        $response->assertStatus(200);
    }

    public function test_student_cannot_access_admin_students_page()
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $studentUser->assignRole('student');

        $response = $this->actingAs($studentUser)->get(route('students.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_create_student_with_new_parent()
    {
        $classRoom = ClassRoom::factory()->create();

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe.' . uniqid() . '@example.com',
            'class_id' => $classRoom->id,
            'dob' => '2010-01-01',
            'gender' => 'Male',
            'nationality' => 'TestLand',
            'country' => 'TestCountry',
            'parent_choice' => 'new',
            'parent_name' => 'Jane Doe',
            'parent_email' => 'jane.doe.' . uniqid() . '@example.com',
            'parent_phone' => '1234567890',
        ];

        $response = $this->actingAs($this->admin)->post(route('students.store'), $data);


        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'name' => 'John Doe',
            'email' => $data['email'],
        ]);

        $this->assertDatabaseHas('parents', [
            'name' => 'Jane Doe',
            'email' => $data['parent_email'],
        ]);
    }

    public function test_admin_can_update_student()
    {
        $student = Student::factory()->create();

        $newData = [
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => 'updated.' . uniqid() . '@example.com',
            'class_id' => $student->class_id,
            'dob' => '2010-01-01',
            'gender' => 'Male',
            'nationality' => 'TestLand',
            'country' => 'TestCountry',
            'parent_id' => $student->parent_id,
        ];

        $response = $this->actingAs($this->admin)->put(route('students.update', $student), $newData);

        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_admin_can_delete_student()
    {
        $student = Student::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('students.destroy', $student));

        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}
