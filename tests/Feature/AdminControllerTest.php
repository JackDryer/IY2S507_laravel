<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\User;
use App\Models\Department;
use App\Models\Device;
use App\Models\Colour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $admin;
    private $user;
    private $department;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a department for testing
        $this->department = Department::factory()->create();
        
        // Create an admin user
        $this->admin = User::factory()->create([
            'is_admin' => true,
            'status' => 'active',
            'department_id' => $this->department->id,
        ]);
        
        // Create a regular user
        $this->user = User::factory()->create([
            'is_admin' => false,
            'status' => 'active',
            'department_id' => $this->department->id,
        ]);
    }

    /** @test */
    public function admin_can_view_home_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.home'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.home');
        $response->assertViewHas(['user_requests', 'asset_requests']);
    }
    
    /** @test */
    public function admin_can_view_user_requests()
    {
        // Create some user requests
        $requestedUsers = User::factory()->count(3)->create([
            'status' => 'requested',
            'department_id' => $this->department->id,
        ]);
        
        $response = $this->actingAs($this->admin)->get(route('admin.user_requests'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.user_requests');
        $response->assertViewHas('user_requests');
    }
    
    /** @test */
    public function admin_can_approve_user_request()
    {
        $requestedUser = User::factory()->create([
            'status' => 'requested',
            'department_id' => $this->department->id,
        ]);
        
        $response = $this->actingAs($this->admin)->post(route('admin.approve_user_request'), [
            'id' => $requestedUser->id
        ]);
        
        $response->assertRedirect(route('admin.user_requests'));
        $response->assertSessionHas('success', 'User Approved');
        
        // Verify user status was changed to active
        $this->assertEquals('active', $requestedUser->fresh()->status);
    }
    
    /** @test */
    public function admin_can_view_asset_requests()
    {
        $device = Device::factory()->create();
        $colour = Colour::factory()->create();
        $asset = Asset::factory()->create([
            'device_id' => $device->id,
            'colour_id' => $colour->id
        ]);
        
        // Create some asset requests
        AssetRequest::factory()->count(3)->create([
            'status' => 'requested',
            'user_id' => $this->user->id,
            'asset_id' => $asset->id
        ]);
        
        $response = $this->actingAs($this->admin)->get(route('admin.asset_requests'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.asset_requests');
        $response->assertViewHas('asset_requests');
    }
    
    /** @test */
    public function admin_can_approve_asset_request()
    {
        $device = Device::factory()->create();
        $colour = Colour::factory()->create();
        $asset = Asset::factory()->create([
            'device_id' => $device->id,
            'colour_id' => $colour->id
        ]);
        
        $assetRequest = AssetRequest::factory()->create([
            'status' => 'requested',
            'user_id' => $this->user->id,
            'asset_id' => $asset->id
        ]);
        
        $response = $this->actingAs($this->admin)->post(route('admin.approve_asset_request'), [
            'id' => $assetRequest->id
        ]);
        
        $response->assertRedirect(route('admin.asset_requests'));
        $response->assertSessionHas('success', 'Asset Approved');
        
        // Verify asset request status was changed to approved
        $this->assertEquals('approved', $assetRequest->fresh()->status);
    }
    
    /** @test */
    public function admin_can_view_manage_users()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.manage_users'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.manage.users');
        $response->assertViewHas(['users', 'departments']);
    }
    
    /** @test */
    public function admin_can_add_asset()
    {
        $device = Device::factory()->create();
        $colour = Colour::factory()->create();
        
        $assetData = [
            'name' => $this->faker->unique()->word,
            'serial_number' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'colour_id' => $colour->id,
            'device_id' => $device->id,
        ];
        
        $response = $this->actingAs($this->admin)->post(route('admin.add_asset'), $assetData);
        
        $response->assertRedirect(route('admin.manage_assets'));
        $response->assertSessionHas('success', 'Asset created successfully');
        
        // Verify asset was created in the database
        $this->assertDatabaseHas('assets', [
            'name' => $assetData['name'],
            'serial_number' => $assetData['serial_number']
        ]);
    }
    
    /** @test */
    public function admin_can_view_manage_assets()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.manage_assets'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.manage.assets');
        $response->assertViewHas('assets');
    }
    
    /** @test */
    public function admin_can_delete_asset()
    {
        $device = Device::factory()->create();
        $colour = Colour::factory()->create();
        
        $asset = Asset::factory()->create([
            'device_id' => $device->id,
            'colour_id' => $colour->id
        ]);
        
        $response = $this->actingAs($this->admin)->post(route('admin.delete_asset'), [
            'id' => $asset->id
        ]);
        
        $response->assertRedirect(route('admin.manage_assets'));
        $response->assertSessionHas('success', 'Asset deleted successfully');
        
        // Verify asset was deleted from the database
        $this->assertDatabaseMissing('assets', ['id' => $asset->id]);
    }
    
    /** @test */
    public function admin_can_manage_user_update_via_json()
    {
        $userData = [
            'id' => $this->user->id,
            'action' => 'update',
            'first_name' => 'Updated',
            'last_name' => 'User',
            'email' => 'updated@example.com',
            'username' => 'updated_username',
            'employee_num' => 'EMP-UPDATED',
            'department_id' => $this->department->id,
            'device_limit' => 5,
            'status' => 'active',
            'is_admin' => false
        ];
        
        $response = $this->actingAs($this->admin)
                         ->postJson(route('admin.manage_user'), $userData);
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'User updated successfully'
        ]);
        
        // Verify user was updated in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'first_name' => 'Updated',
            'email' => 'updated@example.com',
            'name' => 'updated_username'
        ]);
    }
    
    /** @test */
    public function admin_can_approve_user_via_manage_user()
    {
        $requestedUser = User::factory()->create([
            'status' => 'requested',
            'department_id' => $this->department->id,
        ]);
        
        $response = $this->actingAs($this->admin)->post(route('admin.manage_user'), [
            'id' => $requestedUser->id,
            'action' => 'approve'
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('success', 'User approved');
        
        // Verify user status was changed to active
        $this->assertEquals('active', $requestedUser->fresh()->status);
    }
    
    /** @test */
    public function admin_can_strip_assets_from_user()
    {
        $device = Device::factory()->create();
        $colour = Colour::factory()->create();
        $asset = Asset::factory()->create([
            'device_id' => $device->id,
            'colour_id' => $colour->id
        ]);
        
        // Create pending asset request for the user
        $assetRequest = AssetRequest::factory()->create([
            'status' => 'requested',
            'user_id' => $this->user->id,
            'asset_id' => $asset->id
        ]);
        
        $response = $this->actingAs($this->admin)->post(route('admin.manage_user'), [
            'id' => $this->user->id,
            'action' => 'strip_assets'
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('success', 'All assets and pending requests removed from user');
        
        // Verify asset request was denied
        $this->assertEquals('denied', $assetRequest->fresh()->status);
    }
    
    /** @test */
    public function non_admin_cannot_access_admin_routes()
    {
        $regularUser = User::factory()->create([
            'is_admin' => false,
            'status' => 'active',
            'department_id' => $this->department->id,
        ]);
        
        $routes = [
            route('admin.home'),
            route('admin.user_requests'),
            route('admin.asset_requests'),
            route('admin.manage_users'),
            route('admin.manage_assets')
        ];
        
        foreach ($routes as $route) {
            $response = $this->actingAs($regularUser)->get($route);
            $response->assertStatus(403);
        }
    }
    
    /** @test */
    public function admin_gets_error_with_invalid_action()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.manage_user'), [
            'id' => $this->user->id,
            'action' => 'invalid_action'
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Invalid action');
    }
}