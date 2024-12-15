{{-- @push('css')
    <style>
        .form-body input[type='text']:disabled {
            border: none;
            background: none;
            color: black;
            padding: 0;
        }
        .form-body input[type='radio']:disabled{
            visibility: hidden;
        }
        .form-body input[type='radio']:disabled + label {
            visibility: hidden;
        }
        /* .form-body input[type='radio']:disabled:checked {
            visibility: hidden;
        } */
    </style>
@endpush --}}

<div>
    <livewire:component.page-heading title_main="Country" title_sub="ประเทศ" breadcrumb_title="Common Data"
        breadcrumb_page="Country" breadcrumb_page_title="Country Form" />

    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save" onkeydown="return event.key != 'Enter';">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Country info</h3>
                        </label>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"> Code <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" wire:model="data.countryCode" required
                                @disabled($action != 'create')>
                        </div>
                    </div>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label"> Name (EN)</label>
                        <div class="col-sm-8"><input name="countryNameTH" type="text" class="form-control "
                                id="countryNameTH" wire:model="data.countryNameTH" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"> Name (TH)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control " name="countryNameEN" autocomplete="off"
                                id="countryNameEN" wire:model="data.countryNameEN" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <input id="radio-active" type="radio" wire:model.boolean="data.isActive" value="true" @disabled($action != 'create' && $action != 'edit')>
                            <label for="radio-active" class="checkbox-inline i-checks">Active </label>

                            <input id="radio-inactive" type="radio" wire:model.boolean="data.isActive" value="false" @disabled($action != 'create' && $action != 'edit')>
                            <label for="radio-inactive" class="i-checks">Inactive</label>

                        </div>
                    </div>
                    @if($action != 'create')
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Create By</label>
                        <div class="col-sm-10">
                            <label>{{ $data->createBy->username ?? '' }} 
                                {{-- {{$data->createTime ?? ''}} --}}
                                {{ ($data->createTime && $data->createTime !== '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($data->createTime)->addHours(7)->format('Y-m-d H:i:s') : ' '}}
                            </label>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Update By</label>
                        <div class="col-sm-10">
                            <label>{{ $data->editBy->username ?? '' }} {{ ($data->editTime && $data->editTime !== '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($data->editTime)->addHours(7)->format('Y-m-d H:i:s') : ' '}}</label>
                        </div>
                    </div>
                    @endif
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a name="back" class="btn btn-white" type="button"
                                href="{{route('country')}}"><i class="fa fa-reply"></i> Back</a>
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
