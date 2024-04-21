<div>
    <div class="form-group row">
        <div class="col-md-1">
            <label class="col-form-label" style="padding-top: 5px;">Type</label>
        </div>
        <div class="col-md-2">
            <select name="containerTypeHeader" class="select2_single form-control select2" id="containerTypeHeader"
                style="width: 100%" wire:model.change="typeContainer">
                <option value="">- select -</option>
                @foreach (Service::ContainerTypeSelecter() as $containerType)
                <option value="{{ $containerType->containertypeCode }}">
                    {{ $containerType->containertypeName }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <label class="col-form-label" style="padding-top: 5px;">Size</label>
        </div>
        <div class="col-md-2">
            <select name="containerSizeHeader" id="containerSizeHeader" class="select2_single form-control select2"
                style="width: 100%" wire:model.change="sizeContainer">
                <option value="">- select -</option>
                @foreach (Service::ContainerSizeSelecter() as $containerSize)
                <option value="{{ $containerSize->containersizeCode }}">
                    {{ $containerSize->containersizeName }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <label class="col-form-label" style="padding-top: 5px;">จำนวน</label>
                
        </div>
        <div class="col-md-2">
            <input name="containQty" type="number" class="form-control" id="containQty"
                wire:model.live.debounce.500ms="quantityContainer">
                
        </div>
        <div class="col" style="display: flex; align-items: flex-end;">
            <button class="btn btn-primary" type="button" wire:click="addContainer">
                <i class="fa fa-plus"></i>Add
            </button>
        </div>
        @error('typeContainer') <span class="text-danger">{{ $message }}</span> @enderror
        @error('sizeContainer') <span class="text-danger">{{ $message }}</span> @enderror
        @error('quantityContainer')
            <div class="text-danger m-2">{{ $message }}</div>
        @enderror
    </div>
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
                    <tr id="tr{{ $loop->iteration }}" wire:key="container-field-{{ $container->items }}">
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <select class="select2_single form-control select2"
                                wire:key="containerType-field-{{$container->items}}"
                                wire:model.live.change="value.{{ $loop->index }}.containerType"
                                style="width: 100%">
                                <option value="">- select -</option>
                                @foreach (Service::ContainerTypeSelecter() as $containerType)
                                <option value="{{ $containerType->containertypeCode }}">
                                    {{ $containerType->containertypeName }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="select2_single form-control select2" style="width: 100%"
                                wire:key="containerSize-field-{{$container->items}}"
                                wire:model.live.change="value.{{ $loop->index }}.containerSize">
                                <option value="">- select -</option>
                                @foreach (Service::ContainerSizeSelecter() as $containerSize)
                                <option value="{{ $containerSize->containersizeCode }}">
                                    {{ $containerSize->containersizeName }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" wire:key="containerNo-field-{{$container->items}}"
                                wire:model.live.debounce.500ms="value.{{ $loop->index }}.containerNo">
                        </td>
                        <td class="center">
                            <input type="text" class="form-control"
                                wire:key="containerSealNo-field-{{$container->items}}"
                                wire:model.live.debounce.500ms="value.{{ $loop->index }}.containerSealNo">
                        </td>
                        <td class="center">
                            <input type="number" class="form-control" wire:key="containerGW-field-{{$container->items}}"
                                wire:model.live.debounce.500ms="value.{{ $loop->index }}.containerGW">
                        </td>
                        <td class="center">
                            <select name="containerGW_unit[]" class="select2_single form-control select2"
                                style="width: 100%" wire:key="containerGW-unit-field-{{$container->items}}"
                                wire:model.live.change="value.{{ $loop->index }}.containerGW_unit">
                                <option value="">- select -</option>
                                @foreach (Service::UnitContainerSelecter() as $unit)
                                <option value="{{ $unit->unitCode }}">
                                    {{ $unit->unitName }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="center">
                            <input type="text" class="form-control" wire:key="containerNW-field-{{$container->items}}"
                                wire:model.live.debounce.500ms="value.{{ $loop->index }}.containerNW">
                        </td>
                        <td class="center">
                            <select class="select2_single form-control select2" style="width: 100%"
                                wire:key="containerNW-Unit-field-{{$container->items}}"
                                wire:model.change="value.{{ $loop->index }}.containerNW_Unit">
                                <option value="">- select -</option>
                                @foreach (Service::UnitContainerSelecter() as $unit)
                                <option value="{{ $unit->unitCode }}">
                                    {{ $unit->unitName }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="center">
                            <input type="number" class="form-control"
                                wire:key="containerTareweight-Unit-field-{{$container->items}}"
                                wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.containerTareweight">
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