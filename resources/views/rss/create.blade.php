<x-layout>
    <div class="container">
        <h1 class="page-title">Add New RSS Feed</h1>
        
        <div class="create-form">
            <form action="{{ route('feeds.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name">Feed Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="url">Feed URL</label>
                    <input type="url" id="url" name="url" value="{{ old('url') }}" required>
                    @error('url')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="category">Category (optional)</label>
                    <input type="text" id="category" name="category" value="{{ old('category') }}">
                    @error('category')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn">Add Feed</button>
                <a href="{{ route('feeds.index') }}" class="btn-small ml-2">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>