<tbody  x-data="{ open: false,cpuopen:false }">
    <tr @click="open = !open" class = "cursor-pointer">
        <td><h3>{{ $asset->name }}</h3></td>
        <td>{{$asset->colour->name}}</td>
        <td>{{$asset->device->name}}</td>
        @if($slot->isNotEmpty())
            {{$slot}}
        @endif
    </tr>
    <tr x-show="open" x-transition>
        <td colspan="3" class = "py-4 pl-6 pr-12">
            <table>
                <tr>
                    <td><b>Brand</b></td>
                    <td>{{$asset->device->brand->name}} 
                        {{--<span style = "float: right">
                            @sortablelink('device.brand', '⇵') // THIS DOES NOT WORK as its more than one level of sorting :(
                        </span>--}}
                    </td>
                </tr>
                <tr>
                    <td><b>RAM</b></td>
                    <td>{{$asset->device->ram_bytes/1_000_000_000}} GB</td>
                </tr>
                <tr>
                    <td><b>Storage</b></td>
                    <td>{{$asset->device->storage_bytes/1_000_000_000}} GB</td>
                </tr>
                <tr @click="cpuopen = !cpuopen" class = "cursor-pointer">
                    <td><b>CPU</b></td>
                    <td>{{$asset->device->cpu->name}}</td>
                </tr>
                <tr x-show="cpuopen" x-transition>
                   <td colspan="2" class = "py-4 pl-6 pr-12"> 
                        <table>
                            <tr>
                                <td><b>Brand</b></td>
                                <td>{{$asset->device->cpu->brand->name}}</td>
                            </tr>
                            <tr>
                                <td><b>Cores</b></td>
                                <td>{{$asset->device->cpu->cores}}</td>    
                            </tr>
                            <tr>
                                <td><b>Clock Speed</b></td>
                                <td>{{$asset->device->cpu->base_clock_speed_hz/1_000_000_000}} GHz</td>    
                            </tr>
                        </table>
                   </td>
                </tr>
                <tr>
                    <td><b>Type</b></td>
                    <td>{{$asset->device->productType->name}}</td>
                </tr>
            </table>
        </td>
    </tr>
</tbody>