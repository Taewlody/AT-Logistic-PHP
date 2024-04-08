<div>
    <div class="form-group  row">
        <label class="col-sm-2 col-form-label">Customer</label>
        <div class="col-md-10">
            <select name="cusCode" class="select2_single form-control select2"
                id="cusCode" wire:model.live.change="value.cusCode"
                @disabled($action != 'create' && $action != 'edit')>
                <option value="">- select -</option>
                @foreach (Service::CustomerSelecter() as $customer)
                    <option value="{{ $customer->cusCode }}">
                        {{ $customer->custNameEN }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group  row">
        <label class="col-sm-2 col-form-label">Sales</label>
        <div class="col-md-10">
            <select name="saleman" class="select2_single form-control select2"
                id="saleman" wire:model.change="value.saleman"
                @disabled($action != 'create' && $action != 'edit')>
                <option value="">- select -</option>
                @foreach (Service::SalemanSelecter() as $saleman)
                    <option value="{{ $saleman->usercode }}">{{ $saleman->empName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Contact</label>
        <div class="col-md-10">
            <input type="text" name="cusContact" class="form-control"
                id="cusContact" wire:model.live.debounce.500ms="value.cusContact"
                @disabled($action != 'create' && $action != 'edit')>
        </div>
    </div>
    <div class="form-group  row">
        <label class="col-sm-2 col-form-label">Agent</label>
        <div class="col-md-10">
            <select name="agentCode" class="select2_single form-control select2"
                id="agentCode" wire:model.change="value.agentCode"
                @disabled($action != 'create' && $action != 'edit')>
                <option value="">- select -</option>
                @foreach (Service::SupplierSelecter() as $supplier)
                    <option value="{{ $supplier->supCode }}">
                        {{ $supplier->supNameTH }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Contact</label>
        <div class="col-md-10">
            <input type="text" name="agentContact" class="form-control"
                id="agentContact" wire:model.live.debounce.500ms="value.agentContact"
                @disabled($action != 'create' && $action != 'edit')>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Feeder</label>
        <div class="col-md-5">
            <select name="feeder" class="select2_single form-control select2"
                id="feeder" wire:model.change="value.feeder" @disabled($action != 'create' && $action != 'edit')>
                <option value="">- select -</option>
                @foreach (Service::FeederSelecter() as $feeder)
                    <option value="{{ $feeder->fCode }}">{{ $feeder->fName }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <label class="col-form-label" style="padding-top: 5px;">VOY</label>
        </div>
        <div class="col-md-4">
            <input type="text" name="feederVOY" class="form-control"
                id="feederVOY" wire:model.live.debounce.500ms="value.feederVOY"
                @disabled($action != 'create' && $action != 'edit')>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Vessel</label>
        <div class="col-md-5">
            <select name="vessel" class="select2_single form-control select2"
                id="vessel" wire:model.change="value.vessel" @disabled($action != 'create' && $action != 'edit')>
                <option value="">- select -</option>
                @foreach (Service::FeederSelecter() as $feeder)
                    <option value="{{ $feeder->fCode }}">{{ $feeder->fName }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <label class="col-form-label" style="padding-top: 5px;">VOY</label>
        </div>
        <div class="col-md-4">
            <input type="text" name="vesselVOY" class="form-control"
                id="vesselVOY" wire:model.live.debounce.500ms="value.vesselVOY"
                @disabled($action != 'create' && $action != 'edit')>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Note</label>
        <div class="col-md-10">
            <textarea name="note" rows="4" class="form-control" id="note" wire:model.live.debounce.500ms="value.note"
                @disabled($action != 'create' && $action != 'edit')></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Internal Note</label>
        <div class="col-md-10">
            <textarea name="internal_note" rows="4" class="form-control" id="internal_note" wire:model.live.debounce.500ms="value.internal_note"
                @disabled($action != 'create' && $action != 'edit')></textarea>
        </div>
    </div>
</div>
