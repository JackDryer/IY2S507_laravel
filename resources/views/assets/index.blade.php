<x-layout>
    <h2>Loanable assets</h2>
    <ul>
        @foreach ($assets as  $asset)
        <li>
            <x-card href="/assets/{{$asset['id']}}" :highlight="true">
            <h3>{{ $asset["name"] }}</h3>
            </x-card>
        </li>
        @endforeach
    </ul> 
</x-layout>