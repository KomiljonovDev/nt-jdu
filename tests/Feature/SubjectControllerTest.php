<?php

namespace Tests\Feature;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_subject () {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;

        $createSubject = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/subjects', [
                'name' => 'Test Subject',
            ]);
        $createSubject->assertStatus(201);
        $createSubject->assertJson([
            'message' => 'Subject created successfully.'
        ]);
    }

    public function test_cannot_create_subject () {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;

        $createSubject = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/subjects', [
            ]);
        $createSubject->assertStatus(422);
        $createSubject->assertJson([
            'errors' => [
                'name' => ['The name field is required.'],
            ]
        ]);
    }
    public function test_can_update_subject () {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;

        $subject = Subject::factory()->create();

        $updateSubject = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->putJson('api/subjects/' . $subject->id, [
            'name' => 'Updated Subject',
        ]);
        $updateSubject->assertStatus(201);
        $updateSubject->assertJson([
            'message' => 'Subject updated successfully.'
        ]);
    }
    public function test_cannot_update_subject () {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;

        Subject::query()->create([
            'name'=>'Subject Name',
        ]);
        $subject = Subject::query()->create([
            'name'=>'Subject Name2',
        ]);
        $updateSubject = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->putJson('api/subjects/' . $subject->id, [
                'name' => 'Subject Name',
            ]);
        $updateSubject->assertStatus(422);
        $updateSubject->assertJson([
            'errors' => [
                'name' => ['The name has already been taken.'],
            ]
        ]);
    }
    public function test_can_delete_subject () {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;
        $subject = Subject::factory()->create();

        $deleteSubject = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->deleteJson('api/subjects/' . $subject->id);
        $deleteSubject->assertStatus(200);
        $deleteSubject->assertJson(['message' => 'Subject deleted successfully.']);
    }
    public function test_cannot_delete_subject () {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;
        Subject::factory()->create();
        $deleteSubject = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->deleteJson('api/subjects/' . 5);
        $deleteSubject->assertStatus(404);
    }
}
