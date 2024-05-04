<div>
    
    <div class="form-group">
        <div class="table-responsive">
            <table id="table_container" class="table" width="100%">
                <thead>
                    <tr>
                        <th style="width:5%">No.</th>
                        <th style="width:10%">Container Type</th>
                        <th style="width:10%">Size</th>
                        <th style="width:10%">Container No.</th>
                        <th style="width:10%">Seal No.</th>
                        <th style="width:10%">Gross Weight</th>
                        <th style="width:10%">GW.Unit</th>
                        <th style="width:10%"> Net Weight</th>
                        <th style="width:10%">NW.Unit</th>
                        <th style="width:10%">Tare Weight</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($value as $container)
                    <tr id="tr{{ $loop->iteration }}" wire:key="container-{{$loop->index}}">
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <livewire:element.select2 :key="$loop->index" wire:model.defer="value.{{ $loop->index }}.containerType"
                                :options="Service::ContainerTypeSelecter()" itemKey="containertypeCode"
                                itemValue="containertypeName"/>
                        </td>
                        <td>
                            <livewire:element.select2 :key="$loop->index" wire:model.defer="value.{{ $loop->index }}.containerSize"
                                :options="Service::ContainerSizeSelecter()" itemKey="containersizeCode"
                                itemValue="containersizeName"/>
                        </td>
                        <td>
                            <input type="text" class="form-control"
                                wire:model.lazy.debounce.700ms="value.{{ $loop->index }}.containerNo">
                        </td>
                        <td class="center">
                            <input type="text" class="form-control"
                                wire:model.lazy.debounce.700ms="value.{{ $loop->index }}.containerSealNo">
                        </td>
                        <td class="center">
                            <input type="number" class="form-control"
                                wire:model.number.lazy.debounce.700ms="value.{{ $loop->index }}.containerGW">
                        </td>
                        <td class="center">
                            <livewire:element.select2 :key="$loop->index" wire:model.defer="value.{{ $loop->index }}.containerGW_unit"
                                :options="Service::UnitContainerSelecter()" itemKey="unitCode"
                                itemValue="unitName"/>
                        </td>
                        <td class="center">
                            <input type="text" class="form-control" wire:key="containerNW-field-{{$loop->index}}"
                                wire:model.lazy.debounce.700ms="value.{{ $loop->index }}.containerNW">
                        </td>
                        <td class="center">
                            <livewire:element.select2 :key="$loop->index" wire:model.defer="value.{{ $loop->index }}.containerNW_Unit"
                                :options="Service::UnitContainerSelecter()" itemKey="unitCode"
                                itemValue="unitName"/>
                        </td>
                        <td class="center">
                            <input type="number" class="form-control"
                                wire:key="containerTareweight-Unit-field-{{$loop->index}}"
                                wire:model.number.lazy.debounce.700ms="value.{{ $loop->index }}.containerTareweight">
                        </td>
                        <td class="center">
                            <button type="button" class="btn-danger btn btn-xs"
                                wire:click="$parent.removeContainer('{{ $loop->index }}')">Remove</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>