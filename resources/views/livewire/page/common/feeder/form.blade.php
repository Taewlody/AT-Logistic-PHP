<div>

    <livewire:component.page-heading title_main="Feeder" title_sub="ชื่อเรือ" breadcrumb_title="Common Data"
        breadcrumb_page="Feeder" breadcrumb_page_title="Feeder Form" />

    <div class="container-fluid">
        <!-- Body-->

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper">
            <div class="loader"></div>
        </div>
        <div>
            @if (session()->has('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save" onkeydown="return event.key != 'Enter';">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Unit info</h3>
                        </label>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label"> Code</label>
                        <div class="col-md-2">
                            <input name="fCode" type="text" class="form-control " id="fCode" readonly
                                autocomplete="off" wire:model="data.fCode" @disabled($action != 'create')>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label"> Name <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input name="fName" type="text" class="form-control " id="fName"
                                autocomplete="empty" wire:model="data.fName" @disabled($action != 'create' && $action != 'edit') required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <input id="radio-active" type="radio" wire:model.boolean="data.isActive"
                                value="true" @disabled($action != 'create' && $action != 'edit')>
                            <label for="radio-active" class="checkbox-inline i-checks">Active </label>

                            <input id="radio-inactive" type="radio" wire:model.boolean="data.isActive"
                                value="false" @disabled($action != 'create' && $action != 'edit')>
                            <label for="radio-inactive" class="i-checks">Inactive</label>
                        </div>
                    </div>

                    @if ($action != 'create')
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Create By</label>
                            <div class="col-sm-10">
                                <label>{{ $data->createBy->username }} {{ $data->createTime ?? '' }}</label>
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Update By</label>
                            <div class="col-sm-10">
                                <label>{{ $data->editBy->username }} {{ $data->editTime ?? '' }}</label>
                            </div>
                        </div>
                    @endif
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a name="back" class="btn btn-white" type="button" href="{{ route('feeder') }}"
                                wire.loading.attr="disabled">
                                <i class="fa fa-reply"></i> Back
                            </a>
                            @if ($action == 'create' || $action == 'edit')
                                <button name="save" id="save" class="btn btn-primary"
                                    wire.loading.attr="disabled" type="submit">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
