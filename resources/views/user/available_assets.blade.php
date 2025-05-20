<x-layout>
    <div class="container mx-auto py-6 px-4">
        <h2 class="text-2xl font-bold mb-6">Loanable Assets</h2>
        
        <!-- Filter Component -->
        <x-asset-filter-form :productTypes="$productTypes" :brands="$brands" :filters="$filters" />
        
        <!-- Results Count -->
        <div class="mb-4 text-sm text-gray-400">
            Showing {{ $assets->count() }} of {{ $assets->total() }} available assets
        </div>
        
        <!-- Assets Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700 border border-gray-700 rounded-lg overflow-hidden">
                <x-asset-table-headings />
                @foreach ($assets as $asset)
                    <x-expandable-asset :asset="$asset">
                        <form action="{{route('user.request_asset')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$asset->id}}">
                            <td class="justify-center"> 
                                <button class="px-3 py-1 rounded-md btn block mx-auto" @click.stop="open">Request</button>
                            </td>
                        </form>
                    </x-expandable-asset>
                @endforeach
            </table>
        </div>
        
        <!-- No Results Message -->
        @if($assets->count() === 0)
            <div class="text-center py-6">
                <p class="text-lg text-gray-400">No matching assets found.</p>
                @if(array_filter($filters))
                    <p class="mt-2 text-sm text-gray-500">Try adjusting your filters or <a href="{{ route('user.available_assets') }}" class="text-blue-500 hover:underline">clear all filters</a>.</p>
                @endif
            </div>
        @endif
        
        <!-- Pagination -->
        <div class="mt-6">
            {!! $assets->appends(\Request::except('page'))->render() !!}
        </div>
    </div>
</x-layout>