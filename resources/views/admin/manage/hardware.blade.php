<x-layout>
    <h2>Hardware Management</h2>

    <div x-data="{ 
        activeTab: '{{ request()->query('tab', 'assets') }}',
        switchTab(tab) {
            this.activeTab = tab;
            // Update URL without page reload
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tab);
            history.pushState({}, '', url);
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
                        <tr>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->serial_number }}</td>
                            <td>{{ $asset->colour->name ?? 'N/A' }}</td>
                            <td>{{ $asset->device->name ?? 'N/A' }}</td>
                            <td>
                                <!-- For deleting assets -->
                                <form action="{{ route('hardware.action') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="delete_asset">
                                    <input type="hidden" name="id" value="{{ $asset->id }}">
                                    <button type="submit" class="btn-small danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr>
                            <td>{{ $device->name }}</td>
                            <td>{{ number_format($device->ram_bytes / 1073741824, 2) }} GB</td>
                            <td>{{ number_format($device->storage_bytes / 1073741824, 2) }} GB</td>
                            <td>{{ $device->brand->name ?? 'N/A' }}</td>
                            <td>{{ $device->cpu->name ?? 'N/A' }}</td>
                            <td>{{ $device->productType->name ?? 'N/A' }}</td>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cpus as $cpu)
                        <tr>
                            <td>{{ $cpu->name }}</td>
                            <td>{{ number_format($cpu->base_clock_speed_hz / 1000000000, 2) }} GHz</td>
                            <td>{{ $cpu->cores }}</td>
                            <td>{{ $cpu->brand->name ?? 'N/A' }}</td>
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
                            <li>{{ $colour->name }}</li>
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
                            <li>{{ $brand->name }}</li>
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
                // Find closest sortable link
                const sortLink = e.target.closest('a[data-sortable]');
                
                if (sortLink) {
                    e.preventDefault();
                    
                    // Get current tab from URL or Alpine.js state
                    const urlParams = new URLSearchParams(window.location.search);
                    const currentTab = urlParams.get('tab') || 'assets';
                    
                    // Get link URL and add tab parameter
                    let url = new URL(sortLink.href);
                    url.searchParams.set('tab', currentTab);
                    
                    // Navigate to new URL
                    window.location.href = url.toString();
                }
            });
        });
    </script>
</x-layout>