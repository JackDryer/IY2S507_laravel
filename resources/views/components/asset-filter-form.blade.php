<div class="mb-6 p-4 bg-slate-700 rounded-lg shadow" x-data="{ showFilters: {{ count(array_filter(request()->only(['device_type', 'brand', 'min_ram', 'min_storage']))) > 0 ? 'true' : 'false' }} }">
    <div class="flex justify-between items-center mb-2">
        <h3 class="text-lg font-medium">Filter Assets</h3>
        <button @click="showFilters = !showFilters" class="text-sm font-medium text-blue-500 hover:text-blue-700">
            <span x-show="!showFilters">Show Filters</span>
            <span x-show="showFilters">Hide Filters</span>
        </button>
    </div>
    
    <form x-show="showFilters" 
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-95"
          x-transition:enter-end="opacity-100 transform scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-95"
          action="{{ route('user.available_assets') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Device Type Filter -->
        <div>
            <label for="device_type" class="block text-sm font-medium mb-1">Device Type</label>
            <select id="device_type" name="device_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <option value="">All Types</option>
                @foreach($productTypes as $type)
                    <option value="{{ $type->id }}" {{ $filters['device_type'] ?? '' == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Brand Filter -->
        <div>
            <label for="brand" class="block text-sm font-medium mb-1">Brand</label>
            <select id="brand" name="brand" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $filters['brand'] ?? '' == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Minimum RAM Filter -->
        <div>
            <label for="min_ram" class="block text-sm font-medium mb-1">Minimum RAM (GB)</label>
            <select id="min_ram" name="min_ram" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <option value="">Any RAM</option>
                @foreach([4, 8, 16, 32, 64] as $ram)
                    <option value="{{ $ram }}" {{ $filters['min_ram'] ?? '' == $ram ? 'selected' : '' }}>
                        {{ $ram }} GB+
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Minimum Storage Filter -->
        <div>
            <label for="min_storage" class="block text-sm font-medium mb-1">Minimum Storage (GB)</label>
            <select id="min_storage" name="min_storage" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <option value="">Any Storage</option>
                @foreach([128, 256, 512, 1024, 2048] as $storage)
                    <option value="{{ $storage }}" {{ $filters['min_storage'] ?? '' == $storage ? 'selected' : '' }}>
                        {{ $storage }} GB+
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Filter Buttons -->
        <div class="md:col-span-2 lg:col-span-4 flex justify-end space-x-2 mt-2">
            <a href="{{ route('user.available_assets') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Clear
            </a>
            <button type="submit" class="px-4 py-2 bg-amber-500 border border-transparent rounded-md text-sm font-medium text-black shadow-sm hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Apply Filters
            </button>
        </div>
    </form>
    
    <!-- Active Filters Summary -->
    <div x-show="showFilters" class="mt-3 flex flex-wrap gap-2">
        @if(isset($filters['device_type']) && $filters['device_type'])
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                Type: {{ $productTypes->where('id', $filters['device_type'])->first()->name }}
            </span>
        @endif
        
        @if(isset($filters['brand']) && $filters['brand'])
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                Brand: {{ $brands->where('id', $filters['brand'])->first()->name }}
            </span>
        @endif
        
        @if(isset($filters['min_ram']) && $filters['min_ram'])
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                RAM: {{ $filters['min_ram'] }}GB+
            </span>
        @endif
        
        @if(isset($filters['min_storage']) && $filters['min_storage'])
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                Storage: {{ $filters['min_storage'] }}GB+
            </span>
        @endif
    </div>
</div>