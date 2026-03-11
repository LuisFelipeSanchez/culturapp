<?php

namespace Tests\Feature;

use App\Models\Sede;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SedeAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_citizen_cannot_manage_sedes_even_if_linked(): void
    {
        $sede = Sede::create([
            'name' => 'Sede Test',
            'address' => 'Calle 123',
            'zone' => 'urbana',
            'latitude' => 5.068890,
            'longitude' => -75.517380,
        ]);

        $citizen = User::factory()->create([
            'role' => 'citizen',
            'sede_id' => $sede->id,
        ]);

        $response = $this->actingAs($citizen)->get(route('admin.manage', $sede));

        $response->assertStatus(403);
    }

    public function test_admin_can_manage_their_assigned_sede(): void
    {
        $sede = Sede::create([
            'name' => 'Sede Admin Test',
            'address' => 'Calle 456',
            'zone' => 'urbana',
            'latitude' => 5.068890,
            'longitude' => -75.517380,
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
            'sede_id' => $sede->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.manage', $sede));

        $response->assertStatus(200);
    }

    public function test_super_admin_can_manage_any_sede(): void
    {
        $sede = Sede::create([
            'name' => 'Sede Super Test',
            'address' => 'Calle 789',
            'zone' => 'urbana',
            'latitude' => 5.068890,
            'longitude' => -75.517380,
        ]);

        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $response = $this->actingAs($superAdmin)->get(route('admin.manage', $sede));

        $response->assertStatus(200);
    }
}
