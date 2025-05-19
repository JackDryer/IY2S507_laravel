<x-layout>
    <h2>Hardware Management</h2>

    <div x-data="{ 
        activeTab: '{{ request()->query('tab', 'assets') }}',
        editingAsset: null,
        editingDevice: null,
        editingCpu: null,
        switchTab(tab) {
            this.activeTab = tab;
            this.editingAsset = null;
            this.editingDevice = null;
            this.editingCpu = null;
            // Update URL without page reload
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tab);
            history.pushState({}, '', url);
        },
        startEditingAsset(id) {
            this.editingAsset = id;
            this.editingDevice = null;
            this.editingCpu = null;
        },
        startEditingDevice(id) {
            this.editingDevice = id;
            this.editingAsset = null;
            this.editingCpu = null;
        },
        startEditingCpu(id) {
            this.editingCpu = id;
            this.editingAsset = null;
            this.editingDevice = null;
        },
        cancelEditing() {
            this.editingAsset = null;
            this.editingDevice = null;
            this.editingCpu = null;
        }
    }">
        <!-- Tab Navigation -->
        <div class="tabs">
            <a 
                @click.prevent="switchTab('assets')" 
                :class="{ 'active': activeTab === 'assets' }" 
                class="tab-btn"
                href="#"
            >Assets</a>
            <a 
                @click.prevent="switchTab('devices')" 
                :class="{ 'active': activeTab === 'devices' }" 
                class="tab-btn"
                href="#"
            >Devices</a>
            <a 
                @click.prevent="switchTab('cpus')" 
                :class="{ 'active': activeTab === 'cpus' }" 
                class="tab-btn"
                href="#"
            >CPUs</a>
            <a 
                @click.prevent="switchTab('other')" 
                :class="{ 'active': activeTab === 'other' }" 
                class="tab-btn"
                href="#"
            >Colours & Brands</a>
        </div>

        <!-- Assets Tab -->
        <div x-show="activeTab === 'assets'" class="tab-content">
            <h3>Manage Assets</h3>
            
            <div class="create-form">
                <h4>Add New Asset</h4>
                <form action="{{ route('hardware.action') }}" method="POST" class="inline-form">
                    @csrf
                    <input type="hidden" name="action" value="add_asset">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Asset Name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="serial_number" placeholder="Serial Number" required>
                    </div>
                    <div class="form-group">
                        <select name="colour_id" required>
                            <option value="" disabled selected>Select Colour</option>
                            @foreach ($colours as $colour)
                                <option value="{{ $colour->id }}">{{ $colour->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="device_id" required>
                            <option value="" disabled selected>Select Device</option>
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn">Add Asset</button>
                </form>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>@sortablelink('name', 'Name', null, ['tab' => 'assets'])</th>
                        <th>@sortablelink('serial_number', 'Serial Number', null, ['tab' => 'assets'])</th>
                        <th>Colour</th>
                        <th>Device</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets as $asset)
                        <tr 
                            x-data="{ asset: {{ json_encode($asset) }} }"
                            @click="editingAsset != {{ $asset->id }} && startEditingAsset({{ $asset->id }})"
                            :class="{ 'editing': editingAsset == {{ $asset->id }} }"
                        >
                            <template x-if="editingAsset != {{ $asset->id }}">
                                <td>{{ $asset->name }}</td>
                            </template>
                            <template x-if="editingAsset == {{ $asset->id }}">
                                <td>
                                    <input type="text" name="name" x-model="asset.name" class="inline-edit" @click.stop>
                                </td>
                            </template>
                            
                            <template x-if="editingAsset != {{ $asset->id }}">
                                <td>{{ $asset->serial_number }}</td>
                            </template>
                            <template x-if="editingAsset == {{ $asset->id }}">
                                <td>
                                    <input type="text" name="serial_number" x-model="asset.serial_number" class="inline-edit" @click.stop>
                                </td>
                            </template>
                            
                            <template x-if="editingAsset != {{ $asset->id }}">
                                <td>{{ $asset->colour->name ?? 'N/A' }}</td>
                            </template>
                            <template x-if="editingAsset == {{ $asset->id }}">
                                <td>
                                    <select name="colour_id" x-model="asset.colour_id" class="inline-edit" @click.stop>
                                        @foreach ($colours as $colour)
                                            <option value="{{ $colour->id }}">{{ $colour->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </template>
                            
                            <template x-if="editingAsset != {{ $asset->id }}">
                                <td>{{ $asset->device->name ?? 'N/A' }}</td>
                            </template>
                            <template x-if="editingAsset == {{ $asset->id }}">
                                <td>
                                    <select name="device_id" x-model="asset.device_id" class="inline-edit" @click.stop>
                                        @foreach ($devices as $device)
                                            <option value="{{ $device->id }}">{{ $device->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </template>
                            
                            <td>
                                <template x-if="editingAsset != {{ $asset->id }}">
                                    <div>
                                        <form action="{{ route('hardware.action') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="delete_asset">
                                            <input type="hidden" name="id" value="{{ $asset->id }}">
                                            <button type="submit" class="btn-small danger" onclick="return confirm('Are you sure?')" @click.stop>Delete</button>
                                        </form>
                                    </div>
                                </template>
                                <template x-if="editingAsset == {{ $asset->id }}">
                                    <div>
                                        <form action="{{ route('hardware.action') }}" method="POST" class="inline" @click.stop>
                                            @csrf
                                            <input type="hidden" name="action" value="update_asset">
                                            <input type="hidden" name="id" value="{{ $asset->id }}">
                                            <input type="hidden" name="name" :value="asset.name">
                                            <input type="hidden" name="serial_number" :value="asset.serial_number">
                                            <input type="hidden" name="colour_id" :value="asset.colour_id">
                                            <input type="hidden" name="device_id" :value="asset.device_id">
                                            <button type="submit" class="btn-small success" @click.stop>Save</button>
                                        </form>
                                        <button class="btn-small" @click.stop="cancelEditing()">Cancel</button>
                                    </div>
                                </template>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $assets->appends(['devices' => $devices->currentPage(), 'cpus' => $cpus->currentPage(), 'tab' => 'assets'])->links() }}
        </div>

        <!-- Devices Tab -->
        <div x-show="activeTab === 'devices'" class="tab-content">
            <h3>Manage Devices</h3>
            
            <div class="create-form">
                <h4>Add New Device</h4>
                <form action="{{ route('hardware.action') }}" method="POST" class="inline-form">
                    @csrf
                    <input type="hidden" name="action" value="add_device">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Device Name" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="ram_gb" placeholder="RAM (GB)" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="storage_gb" placeholder="Storage (GB)" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <select name="brand_id" required>
                            <option value="" disabled selected>Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="cpu_id" required>
                            <option value="" disabled selected>Select CPU</option>
                            @foreach ($cpus as $cpu)
                                <option value="{{ $cpu->id }}">{{ $cpu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="product_type_id" required>
                            <option value="" disabled selected>Select Type</option>
                            @foreach ($productTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn">Add Device</button>
                </form>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>@sortablelink('name', 'Name', null, ['tab' => 'devices'])</th>
                        <th>@sortablelink('ram_bytes', 'RAM', null, ['tab' => 'devices'])</th>
                        <th>@sortablelink('storage_bytes', 'Storage', null, ['tab' => 'devices'])</th>
                        <th>Brand</th>
                        <th>CPU</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr 
                            x-data="{ 
                                device: {
                                    id: {{ $device->id }},
                                    name: '{{ $device->name }}',
                                    ram_gb: {{ number_format($device->ram_bytes / 1073741824, 2) }},
                                    storage_gb: {{ number_format($device->storage_bytes / 1073741824, 2) }},
                                    brand_id: {{ $device->brand->id ?? 'null' }},
                                    cpu_id: {{ $device->cpu->id ?? 'null' }},
                                    product_type_id: {{ $device->productType->id ?? 'null' }}
                                }
                            }"
                            @click="editingDevice != {{ $device->id }} && startEditingDevice({{ $device->id }})"
                            :class="{ 'editing': editingDevice == {{ $device->id }} }"
                        >
                            <template x-if="editingDevice != {{ $device->id }}">
                                <td>{{ $device->name }}</td>
                            </template>
                            <template x-if="editingDevice == {{ $device->id }}">
                                <td>
                                    <input type="text" name="name" x-model="device.name" class="inline-edit" @click.stop>
                                </td>
                            </template>
                            
                            <template x-if="editingDevice != {{ $device->id }}">
                                <td>{{ number_format($device->ram_bytes / 1073741824, 2) }} GB</td>
                            </template>
                            <template x-if="editingDevice == {{ $device->id }}">
                                <td>
                                    <input type="number" name="ram_gb" x-model="device.ram_gb" step="0.01" class="inline-edit" @click.stop>
                                </td>
                            </template>
                            
                            <template x-if="editingDevice != {{ $device->id }}">
                                <td>{{ number_format($device->storage_bytes / 1073741824, 2) }} GB</td>
                            </template>
                            <template x-if="editingDevice == {{ $device->id }}">
                                <td>
                                    <input type="number" name="storage_gb" x-model="device.storage_gb" step="0.01" class="inline-edit" @click.stop>
                                </td>
                            </template>
                            
                            <template x-if="editingDevice != {{ $device->id }}">
                                <td>{{ $device->brand->name ?? 'N/A' }}</td>
                            </template>
                            <template x-if="editingDevice == {{ $device->id }}">
                                <td>
                                    <select name="brand_id" x-model="device.brand_id" class="inline-edit" @click.stop>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </template>
                            
                            <template x-if="editingDevice != {{ $device->id }}">
                                <td>{{ $device->cpu->name ?? 'N/A' }}</td>
                            </template>
                            <template x-if="editingDevice == {{ $device->id }}">
                                <td>
                                    <select name="cpu_id" x-model="device.cpu_id" class="inline-edit" @click.stop>
                                        @foreach ($cpus as $cpu)
                                            <option value="{{ $cpu->id }}">{{ $cpu->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </template>
                            
                            <template x-if="editingDevice != {{ $device->id }}">
                                <td>{{ $device->productType->name ?? 'N/A' }}</td>
                            </template>
                            <template x-if="editingDevice == {{ $device->id }}">
                                <td>
                                    <select name="product_type_id" x-model="device.product_type_id" class="inline-edit" @click.stop>
                                        @foreach ($productTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </template>
                            
                            <td>
                                <template x-if="editingDevice != {{ $device->id }}">
                                    <div>
                                        <button class="btn-small" @click="startEditingDevice({{ $device->id }})">Edit</button>
                                        <form action="{{ route('hardware.action') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="delete_device">
                                            <input type="hidden" name="id" value="{{ $device->id }}">
                                            <button type="submit" class="btn-small danger" onclick="return confirm('Are you sure?')" @click.stop>Delete</button>
                                        </form>
                                    </div>
                                </template>
                                <template x-if="editingDevice == {{ $device->id }}">
                                    <div>
                                        <form action="{{ route('hardware.action') }}" method="POST" class="inline" @click.stop>
                                            @csrf
                                            <input type="hidden" name="action" value="update_device">
                                            <input type="hidden" name="id" value="{{ $device->id }}">
                                            <input type="hidden" name="name" :value="device.name">
                                            <input type="hidden" name="ram_gb" :value="device.ram_gb">
                                            <input type="hidden" name="storage_gb" :value="device.storage_gb">
                                            <input type="hidden" name="brand_id" :value="device.brand_id">
                                            <input type="hidden" name="cpu_id" :value="device.cpu_id">
                                            <input type="hidden" name="product_type_id" :value="device.product_type_id">
                                            <button type="submit" class="btn-small success" @click.stop>Save</button>
                                        </form>
                                        <button class="btn-small" @click.stop="cancelEditing()">Cancel</button>
                                    </div>
                                </template>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $devices->appends(['assets' => $assets->currentPage(), 'cpus' => $cpus->currentPage(), 'tab' => 'devices'])->links() }}
        </div>

        <!-- CPUs Tab -->
        <div x-show="activeTab === 'cpus'" class="tab-content">
            <h3>Manage CPUs</h3>
            
            <div class="create-form">
                <h4>Add New CPU</h4>
                <form action="{{ route('hardware.action') }}" method="POST" class="inline-form">
                    @csrf
                    <input type="hidden" name="action" value="add_cpu">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="CPU Name" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="base_clock_speed_ghz" placeholder="Base Clock Speed (GHz)" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="cores" placeholder="Number of Cores" required>
                    </div>
                    <div class="form-group">
                        <select name="brand_id" required>
                            <option value="" disabled selected>Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn">Add CPU</button>
                </form>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>@sortablelink('name', 'Name', null, ['tab' => 'cpus'])</th>
                        <th>@sortablelink('base_clock_speed_hz', 'Clock Speed', null, ['tab' => 'cpus'])</th>
                        <th>@sortablelink('cores', 'Cores', null, ['tab' => 'cpus'])</th>
                        <th>Brand</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cpus as $cpu)
                        <tr 
                            x-data="{ 
                                cpu: {
                                    id: {{ $cpu->id }},
                                    name: '{{ $cpu->name }}',
                                    base_clock_speed_ghz: {{ number_format($cpu->base_clock_speed_hz / 1000000000, 2) }},
                                    cores: {{ $cpu->cores }},
                                    brand_id: {{ $cpu->brand->id ?? 'null' }}
                                }
                            }"
                            @click="editingCpu != {{ $cpu->id }} && startEditingCpu({{ $cpu->id }})"
                            :class="{ 'editing': editingCpu == {{ $cpu->id }} }"
                        >
                            <template x-if="editingCpu != {{ $cpu->id }}">
                                <td>{{ $cpu->name }}</td>
                            </template>
                            <template x-if="editingCpu == {{ $cpu->id }}">
                                <td>
                                    <input type="text" name="name" x-model="cpu.name" class="inline-edit" @click.stop>
                                </td>
                            </template>
                            
                            <template x-if="editingCpu != {{ $cpu->id }}">
                                <td>{{ number_format($cpu->base_clock_speed_hz / 1000000000, 2) }} GHz</td>
                            </template>
                            <template x-if="editingCpu == {{ $cpu->id }}">
                                <td>
                                    <input type="number" name="base_clock_speed_ghz" x-model="cpu.base_clock_speed_ghz" step="0.01" class="inline-edit" @click.stop>
                                </td>
                            </template>
                            
                            <template x-if="editingCpu != {{ $cpu->id }}">
                                <td>{{ $cpu->cores }}</td>
                            </template>
                            <template x-if="editingCpu == {{ $cpu->id }}">
                                <td>
                                    <input type="number" name="cores" x-model="cpu.cores" class="inline-edit" @click.stop>
                                </td>
                            </template>
                            
                            <template x-if="editingCpu != {{ $cpu->id }}">
                                <td>{{ $cpu->brand->name ?? 'N/A' }}</td>
                            </template>
                            <template x-if="editingCpu == {{ $cpu->id }}">
                                <td>
                                    <select name="brand_id" x-model="cpu.brand_id" class="inline-edit" @click.stop>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </template>
                            
                            <td>
                                <template x-if="editingCpu != {{ $cpu->id }}">
                                    <div>
                                        <button class="btn-small" @click="startEditingCpu({{ $cpu->id }})">Edit</button>
                                        <form action="{{ route('hardware.action') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="delete_cpu">
                                            <input type="hidden" name="id" value="{{ $cpu->id }}">
                                            <button type="submit" class="btn-small danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </template>
                                <template x-if="editingCpu == {{ $cpu->id }}">
                                    <div>
                                        <form action="{{ route('hardware.action') }}" method="POST" class="inline" @click.stop>
                                            @csrf
                                            <input type="hidden" name="action" value="update_cpu">
                                            <input type="hidden" name="id" value="{{ $cpu->id }}">
                                            <input type="hidden" name="name" :value="cpu.name">
                                            <input type="hidden" name="base_clock_speed_ghz" :value="cpu.base_clock_speed_ghz">
                                            <input type="hidden" name="cores" :value="cpu.cores">
                                            <input type="hidden" name="brand_id" :value="cpu.brand_id">
                                            <button type="submit" class="btn-small success" @click.stop>Save</button>
                                        </form>
                                        <button class="btn-small" @click.stop="cancelEditing()">Cancel</button>
                                    </div>
                                </template>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $cpus->appends(['assets' => $assets->currentPage(), 'devices' => $devices->currentPage(), 'tab' => 'cpus'])->links() }}
        </div>

        <!-- Other Tab for Colours & Brands -->
        <div x-show="activeTab === 'other'" class="tab-content">
            <div class="two-column-grid">
                <div class="grid-item">
                    <h3>Manage Colours</h3>
                    
                    <div class="create-form">
                        <h4>Add New Colour</h4>
                        <form action="{{ route('hardware.action') }}" method="POST" class="inline-form">
                            @csrf
                            <input type="hidden" name="action" value="add_colour">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Colour Name" required>
                            </div>
                            <button type="submit" class="btn">Add Colour</button>
                        </form>
                    </div>
                    
                    <ul class="item-list">
                        @foreach ($colours as $colour)
                            <li>
                                {{ $colour->name }}
                                <form action="{{ route('hardware.action') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="delete_colour">
                                    <input type="hidden" name="id" value="{{ $colour->id }}">
                                    <button type="submit" class="btn-small danger" onclick="return confirm('Are you sure you want to delete this colour?')">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="grid-item">
                    <h3>Manage Brands</h3>
                    
                    <div class="create-form">
                        <h4>Add New Brand</h4>
                        <form action="{{ route('hardware.action') }}" method="POST" class="inline-form">
                            @csrf
                            <input type="hidden" name="action" value="add_brand">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Brand Name" required>
                            </div>
                            <button type="submit" class="btn">Add Brand</button>
                        </form>
                    </div>
                    
                    <ul class="item-list">
                        @foreach ($brands as $brand)
                            <li>
                                {{ $brand->name }}
                                <form action="{{ route('hardware.action') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="delete_brand">
                                    <input type="hidden" name="id" value="{{ $brand->id }}">
                                    <button type="submit" class="btn-small danger" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    @if (session('success'))
        <div class="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add JavaScript for pagination links -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle pagination links to preserve tab
            document.body.addEventListener('click', function(e) {
                // Find closest pagination link
                const paginationLink = e.target.closest('.pagination a');
                
                if (paginationLink) {
                    e.preventDefault();
                    // Get current tab from URL or Alpine.js state
                    const urlParams = new URLSearchParams(window.location.search);
                    const currentTab = urlParams.get('tab') || 'assets';
                    
                    // Get link URL and add tab parameter
                    let url = new URL(paginationLink.href);
                    url.searchParams.set('tab', currentTab);
                    
                    // Navigate to new URL
                    window.location.href = url.toString();
                }
            });
            
            // Handle sortable links to preserve tab
            document.body.addEventListener('click', function(e) {
                // We need to be more specific about which links to capture
                // Check both for links with sort parameter and links with the sortable class
                const target = e.target.closest('a[href*="sort="], a.sortable');
                
                if (target && target.href) {
                    e.preventDefault();
                    // Get current tab from URL or Alpine.js state
                    const urlParams = new URLSearchParams(window.location.search);
                    const currentTab = urlParams.get('tab') || 'assets';
                    
                    try {
                        // Get link URL and add tab parameter
                        let url = new URL(target.href);
                        url.searchParams.set('tab', currentTab);
                        
                        // Navigate to new URL
                        window.location.href = url.toString();
                    } catch (error) {
                        console.error("Error processing sortable link:", error);
                    }
                }
            });
        });
    </script>
</x-layout>