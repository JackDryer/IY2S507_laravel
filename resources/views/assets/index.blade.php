<x-layout>
    <h2>Loanable assets</h2>
    <ul>
        @foreach ($assets as  $asset)
        <li>
            <div class = "list-item">
            <h3>{{ $asset->name }}</h3>
            <p>{{$asset->colour->colour}} {{$asset->device->name}} </p>

            <div>
        </li>
        @endforeach
    </ul>
    {{$assets->links()}} 
</x-layout>