<div>
    <livewire:component.page-heading title_main="Port" title_sub="ท่าเรือ" breadcrumb_title="Common Data"
        breadcrumb_page="Port" breadcrumb_page_title="Port Form" />

    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="submit" onkeydown="return event.key != 'Enter';">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Port info</h3>
                        </label>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label"> Code <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <input name="portCode" type="text" class="form-control " id="portCode"
                                autocomplete="off" wire:model="data.portCode"  @disabled($action != 'create') readonly>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label"> Name (TH) <span class="text-danger">*</span></label>
                        <div class="col-sm-8"><input name="portNameTH" type="text" class="form-control "
                                id="portNameTH" autocomplete="empty" wire:model="data.portNameTH" @disabled($action != 'create' && $action != 'edit') required></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"> Name (EN) <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control " name="portNameEN" autocomplete="empty"
                                id="portNameEN" wire:model="data.portNameEN" @disabled($action != 'create' && $action != 'edit') required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Country <span class="text-danger">*</span></label>
                        <div class="col-md-4">

                            <livewire:element.select2 wire:model='data.countryCode' name="Country" :options="Service::CountrySelecter()"
                                itemKey="countryCode" itemValue="countryNameTH" :disabled="$action != 'create' && $action != 'edit'">
                                @error('data.countryCode')
                                    <div class="text-danger m-2">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                                <input id="activeRadio" type="radio" name="isActive" value="true" wire:model.boolean="data.isActive" @disabled($action != 'create' && $action != 'edit')>
                                <label for="activeRadio" class="checkbox-inline i-checks">Active </label>   
                            
                                <input id="inactiveRadio" type="radio" name="isActive" value="false" wire:model.boolean="data.isActive" @disabled($action != 'create' && $action != 'edit')>
                                <label for="inactiveRadio" class="i-checks">Inactive</label>
                        </div>
                    </div>
                    @if($action != 'create')
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Create By</label>
                        <div class="col-sm-10">
                            <label>{{ $data->createBy->username }} {{$data->createTime ?? ''}}</label>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Update By</label>
                        <div class="col-sm-10">
                            <label>{{ $data->editBy->username }} {{$data->editTime ?? ''}}</label>
                        </div>
                    </div>
                    @endif
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a name="back" class="btn btn-white" type="button"
                                    href="{{route('port')}}"><i class="fa fa-reply"></i> Back</a>
                                @if ($action == 'create' || $action == 'edit')
                                    <button name="save" id="save" class="btn btn-primary" type="submit"><i
                                            class="fa fa-save"></i> Save</button>
                                @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('modal')
<livewire:modal.modal-alert />
@endpush