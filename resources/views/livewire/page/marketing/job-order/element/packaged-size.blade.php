<div>
    <div class="form-group">
        <div class="table-responsive">
            <table class="table dataTables" width="100%" id="table_packed">
                <thead>
                    <tr>
                        <th style="width:5%">No.</th>
                        <th style="width:10%">Width (cm)</th>
                        <th style="width:10%">Length (cm)</th>
                        <th style="width:10%">Height (cm)</th>
                        <th style="width:10%">Quantity Package</th>
                        <th style="width:10%">Weight/Package</th>
                        <th style="width:10%">Unit Weight</th>
                        <th style="width:10%">Total (CBM)</th>
                        <th style="width:10%">Total Weight</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($value as $packed)
                        <tr class="gradeX"
                            wire:key="packed-field-{{ $packed->items }}">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td><span class="center">
                                    <input type="number" class="form-control"
                                        wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.packaed_width">
                                    
                                </span></td>
                            <td><span class="center">
                                    <input type="number" class="form-control"
                                        wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.packaed_length">
                                </span></td>
                            <td><input type="number" class="form-control"
                                    wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.packaed_height">
                            </td>
                            <td class="center">
                                <input type="number" class="form-control"
                                    wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.packaed_qty">
                            </td>
                            <td class="center">
                                <input type="number" class="form-control"
                                    wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.packaed_weight">
                            </td>
                            <td class="center">
                                <select class="select2_single form-control select2"
                                    style="width: 100%"
                                    wire:model.change="value.{{ $loop->index }}.packaed_unit">
                                    {{-- id="packaed_unit<?php echo $i; ?>"
                                onchange="return FN_CalPacked('<?php echo $i; ?>');">  --}}
                                    <option value="">- select -</option>
                                    @foreach (Service::UnitContainerSelecter() as $unit)
                                        <option value="{{ $unit->unitCode }}">
                                            {{ $unit->unitName }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="center">
                                <input type="number" class="form-control" step="0.01"
                                    wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.packaed_totalCBM">
                            </td>
                            <td class="center">
                                <input type="number" class="form-control"
                                    wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.packaed_totalWeight">
                            </td>
                            <td class="center">
                                <button type="button" class="btn-danger btn btn-xs"
                                    wire:click="$parent.removeRowPacked('{{ $loop->index }}')">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a class="btn btn-primary btn-xs mt-3" id="addpacked" wire:click="$parent.addRowPacked">
            <i class="fa fa-plus "></i>
            Add New Row
        </a>

    </div>
</div>
