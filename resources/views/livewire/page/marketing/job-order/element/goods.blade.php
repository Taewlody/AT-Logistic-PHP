<div>
    <div class="form-group">
        <div class="table-responsive">
            <table class="table" width="100%" id="table_product">
                <thead>
                    <tr>
                        <th style="width:5%">No.</th>
                        <th style="width:10%">No of Package</th>
                        <th style="width:10%">Description</th>
                        <th style="width:10%">Weight</th>
                        <th style="width:10%">Unit</th>
                        <th style="width:10%">Size</th>
                        <th style="width:10%">Kind of package</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($value as $goods)
                        <tr class="gradeX"
                            wire:key="goods-field-{{ $goods->items }}">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <input type="text" class="form-control"
                                    wire:model.live.debounce.500ms="value.{{ $loop->index }}.goodNo">
                            </td>
                            <td>
                                <input type="text" class="form-control"
                                    wire:model.live.debounce.500ms="value.{{ $loop->index }}.goodDec">
                            </td>
                            <td>
                                <input type="number" class="form-control"
                                    wire:model.live.debounce.500ms.number="value.{{ $loop->index }}.goodWeight">
                            </td>
                            <td>
                                <select class="select2_single form-control select2"
                                    style="width: 100%"
                                    wire:model.change="value.{{ $loop->index }}.goodUnit">
                                    <option value="">- select -</option>
                                    @foreach (Service::UnitContainerSelecter() as $unit)
                                        <option value="{{ $unit->unitCode }}">
                                            {{ $unit->unitName }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="center">
                                <input type="text" class="form-control"
                                    wire:model.live.debounce.500ms="value.{{ $loop->index }}.goodSize">
                                
                            </td>
                            <td class="center">
                                <input type="text" class="form-control"
                                    wire:model.live.debounce.500ms="value.{{ $loop->index }}.goodKind">
                                
                            </td>
                            <td class="center">
                                <button type="button" class="btn-white btn btn-xs"
                                    wire:click="$parent.removeGoods('{{ $loop->index }}')">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
        <button type="button" class="btn btn-white btn-xs" id="addproduct" wire:click="$parent.addGoods">
            <i class="fa fa-plus "> </i>
            Add New Row
        </button>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Total Number of Package (in
            words)</label>
        <div class="col-md-4">
            <input type="text" name="good_total_num_package" class="form-control"
                wire:model.live.debounce.500ms="good_total_num_package">
        </div>
        <div class="col-md-1">
            <label style="padding-top: 5px;">Commodity</label>
        </div>
        <div class="col-md-4">
            <input type="text" name="good_commodity" class="form-control" 
                wire:model.live.debounce.500ms="good_commodity">
        </div>
    </div>
</div>
