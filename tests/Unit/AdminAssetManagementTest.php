<?php

namespace Tests\Unit;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\User;
use App\Models\Department;
use App\Models\Device;
use App\Models\Colour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAssetManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function asset_can_be_created_with_required_fields()
    {
        $device = Device::factory()->create();
        $colour = Colour::factory()->create();
        
        $asset = Asset::create([
            'name' => 'Test Asset',
            'serial_number' => 'SN12345678',
            'colour_id' => $colour->id,
            'device_id' => $device->id
        ]);
        
        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'name' => 'Test Asset',
            'serial_number' => 'SN12345678'
        ]);
    }

    /** @test */
    public function asset_can_be_deleted()
    {
        $device = Device::factory()->create();
        $colour = Colour::factory()->create();
        
        $asset = Asset::factory()->create([
            'device_id' => $device->id,
            'colour_id' => $colour->id
        ]);
        
        $assetId = $asset->id;
        $asset->delete();
        
        $this->assertDatabaseMissing('assets', ['id' => $assetId]);
    }

    /** @test */
    public function user_status_can_be_updated()
    {
        $department = Department::factory()->create();
        $user = User::factory()->create([
            'status' => 'requested',
            'department_id' => $department->id,
        ]);
        
        $user->status = 'active';
        $user->save();
        
        $this->assertEquals('active', $user->fresh()->status);
    }

    /** @test */
    public function asset_request_status_can_be_updated()
    {
        $department = Department::factory()->create();
        $user = User::factory()->create([
            'status' => 'active',
            'department_id' => $department->id,
        ]);
        
        $device = Device::factory()->create();
        $colour = Colour::factory()->create();
        $asset = Asset::factory()->create([
            'device_id' => $device->id,
            'colour_id' => $colour->id
        ]);
        
        $assetRequest = AssetRequest::factory()->create([
            'status' => 'requested',
            'user_id' => $user->id,
            'asset_id' => $asset->id
        ]);
        
        $assetRequest->status = 'approved';
        $assetRequest->save();
        
        $this->assertEquals('approved', $assetRequest->fresh()->status);
    }
}