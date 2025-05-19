<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    public function index(Request $request)
    {
        // Get current tab from the request
        $currentTab = $request->query('tab', 'assets');
        
        // Ensure sort parameters also include the tab
        $queryParams = $request->except(['page', 'assets', 'devices', 'cpus']);
        $queryParams['tab'] = $currentTab;
        
        $assets = Asset::with(["device", "colour"])
            ->sortable()
            ->paginate(10, ['*'], 'assets')
            ->appends($queryParams);
            
        $devices = \App\Models\Device::with(["brand", "cpu", "productType"])
            ->sortable()
            ->paginate(10, ['*'], 'devices')
            ->appends($queryParams);
            
        $cpus = \App\Models\Cpu::with(["brand"])
            ->sortable()
            ->paginate(10, ['*'], 'cpus')
            ->appends($queryParams);
            
        $colours = \App\Models\Colour::all();
        $brands = \App\Models\Brand::all();
        $productTypes = \App\Models\ProductType::all();
        
        return view("admin.manage.hardware", [
            "assets" => $assets,
            "devices" => $devices,
            "cpus" => $cpus,
            "colours" => $colours,
            "brands" => $brands,
            "productTypes" => $productTypes,
            "currentTab" => $currentTab
        ]);
    }

    public function handleAction(Request $request)
    {
        // Validate the action parameter
        $request->validate([
            'action' => 'required|string|in:add_asset,delete_asset,add_device,add_cpu,add_colour,add_brand'
        ]);
        
        $action = $request->input('action');
        $tab = 'assets'; // Default tab to return to
        
        switch($action) {
            case 'add_asset':
                $validated = $request->validate([
                    'name' => 'required|string|max:255|unique:assets',
                    'serial_number' => 'required|string|max:255',
                    'colour_id' => 'required|exists:colours,id',
                    'device_id' => 'required|exists:devices,id'
                ]);
                Asset::create($validated);
                $message = 'Asset created successfully';
                break;
                
            case 'delete_asset':
                $validated = $request->validate([
                    'id' => 'required|integer|exists:assets,id'
                ]);
                Asset::find($validated['id'])->delete();
                $message = 'Asset deleted successfully';
                break;
                
            case 'add_device':
                $validated = $request->validate([
                    'name' => 'required|string|max:255|unique:devices',
                    'ram_gb' => 'required|numeric',
                    'storage_gb' => 'required|numeric',
                    'brand_id' => 'required|exists:brands,id',
                    'cpu_id' => 'required|exists:cpus,id',
                    'product_type_id' => 'required|exists:product_types,id'
                ]);
                
                // Convert GB to bytes (1 GB = 1,073,741,824 bytes)
                $deviceData = [
                    'name' => $validated['name'],
                    'ram_bytes' => (int)($validated['ram_gb'] * 1073741824),
                    'storage_bytes' => (int)($validated['storage_gb'] * 1073741824),
                    'brand_id' => $validated['brand_id'],
                    'cpu_id' => $validated['cpu_id'],
                    'product_type_id' => $validated['product_type_id']
                ];
                
                \App\Models\Device::create($deviceData);
                $message = 'Device created successfully';
                $tab = 'devices';
                break;
                
            case 'add_cpu':
                $validated = $request->validate([
                    'name' => 'required|string|max:255|unique:cpus',
                    'base_clock_speed_ghz' => 'required|numeric',
                    'cores' => 'required|integer',
                    'brand_id' => 'required|exists:brands,id'
                ]);
                
                // Convert GHz to Hz (1 GHz = 1,000,000,000 Hz)
                $cpuData = [
                    'name' => $validated['name'],
                    'base_clock_speed_hz' => (int)($validated['base_clock_speed_ghz'] * 1000000000),
                    'cores' => $validated['cores'],
                    'brand_id' => $validated['brand_id']
                ];
                
                \App\Models\Cpu::create($cpuData);
                $message = 'CPU created successfully';
                $tab = 'cpus';
                break;
                
            case 'add_colour':
                $validated = $request->validate([
                    'name' => 'required|string|max:255|unique:colours'
                ]);
                \App\Models\Colour::create($validated);
                $message = 'Colour created successfully';
                $tab = 'other';
                break;
                
            case 'add_brand':
                $validated = $request->validate([
                    'name' => 'required|string|max:255|unique:brands'
                ]);
                \App\Models\Brand::create($validated);
                $message = 'Brand created successfully';
                $tab = 'other';
                break;
        }
        
        return redirect()->route('hardware.index', ['tab' => $tab])->with('success', $message);
    }
}