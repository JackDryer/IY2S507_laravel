<x-layout>
    <h2>Loanable assets</h2>
    <ul>
        @foreach ($assets as  $asset)
        <li>
            <x-card href="/assets/{{$asset['id']}}" :highlight="true">
                <div>
            <h3>{{ $asset }}</h3>
            <p>{{$asset->requests}}</p>
            <div>
            </x-card>
        </li>
        @endforeach
    </ul>
    {{$assets->links()}} 
</x-layout>