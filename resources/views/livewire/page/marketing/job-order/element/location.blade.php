<div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Stuffing</label>
        <div class="col-md-3">
            <input type="text" name="stu_location" class="form-control"
                placeholder="location" id="stu_location"
                wire:model.live.debounce.500ms="value.stu_location" @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-3">
            <input name="stu_contact" type="text" class="form-control"
                id="stu_contact" placeholder="Contact Person" autocomplete="empty"
                wire:model.live.debounce.500ms="value.stu_contact" @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-2">
            <input type="text" name="stu_mobile" class="form-control"
                placeholder="Mobile" id="stu_mobile" wire:model.live.debounce.500ms="value.stu_mobile"
                @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-2">
            <div class="input-group date">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <input type="date" name="stu_date" class="form-control"
                    wire:model.live.debounce.500ms="value.stu_date" @disabled($action != 'create' && $action != 'edit')>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">CY</label>
        <div class="col-md-3">
            <input type="text" name="cy_location" class="form-control"
                placeholder="location" id="cy_location" wire:model.live.debounce.500ms="value.cy_location"
                @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-3">
            <input type="text" name="cy_contact" class="form-control"
                placeholder="Contact Person" id="cy_contact" autocomplete="empty"
                wire:model.live.debounce.500ms="value.cy_contact" @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-2">
            <input type="text" name="cy_mobile" class="form-control"
                placeholder="Mobile" id="cy_mobile" wire:model.live.debounce.500ms="value.cy_mobile"
                @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-2">
            <div class="input-group date">
                <span class="input-group-addon">
                    <i class="fa fa-calendar "></i>
                </span>
                <input type="date" name="cy_date" id="cy_date"
                    class="form-control" wire:model.live.debounce.500ms="value.cy_date"
                    @disabled($action != 'create' && $action != 'edit')>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label">RTN
            @if(($value->cy_location ?? "") != "" || ($value->cy_contact ?? "") != "" || ($value->cy_mobile ?? "") != "" || $value->cy_date ?? "" != "")
            <button type="button" class="ml-2 btn btn-sm btn-primary" wire:click="$parent.copyCyToRtn" 
            @disabled($value->cy_location == $value->rtn_location && $value->cy_contact == $value->rtn_contact && $value->cy_mobile == $value->rtnmobile && $value->cy_date == $value->rtn_date )>Copy CY</button>
            @endif
        </label>
        <div class="col-md-3">
            <input type="text" name="rtn_location" class="form-control"
                placeholder="location" id="rtn_location"
                wire:model.live.debounce.500ms="value.rtn_location" @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-3">
            <input type="text" name="rtn_contact" class="form-control"
                placeholder="Contact Person" id="rtn_contact" autocomplete="empty"
                wire:model.live.debounce.500ms="value.rtn_contact" @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-2">
            <input type="text" name="rtn_mobile" class="form-control"
                placeholder="Mobile" id="rtn_mobile" wire:model.live.debounce.500ms="value.rtn_mobile"
                @disabled($action != 'create' && $action != 'edit')>
        </div>
        <div class="col-md-2">
            <div class="input-group date"> <span class="input-group-addon"><i
                        class="fa fa-calendar"></i></span>
                <input type="date" name="rtn_date" id="rtn_date"
                    class="form-control" wire:model.live.debounce.500ms="value.rtn_date"
                    @disabled($action != 'create' && $action != 'edit')>
            </div>
        </div>
    </div>
</div>
