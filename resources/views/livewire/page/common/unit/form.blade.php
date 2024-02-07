<div>

    <livewire:component.page-heading title_main="Unit" title_sub="หน่วยนับ" breadcrumb_title="Common Data"
        breadcrumb_page="Unit" breadcrumb_page_title="Unit Form" />

    <div class="wrapper wrapper-content animated fadeInRight">
        <!-- Body-->

        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <form class="form-body" wire:submit="save">
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">
                                    <h3>Unit info</h3>
                                </label>

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label"> Code</label>
                                <div class="col-md-2">
                                    <input name="unitCode" type="text" class="form-control " id="unitCode"
                                        wire:model="data.unitCode" autocomplete="off" @disabled($action != 'create')>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label"> Name</label>
                                <div class="col-sm-8">
                                    <input name="unitName" type="text" class="form-control "
                                        wire:model="data.unitName" id="unitName" autocomplete="empty"
                                        @disabled($action != 'create' && $action != 'edit')>
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
                                    <a name="back" class="btn btn-white" type="button"
                                        href="{{ url()->previous() }}" wire.loading.attr="disabled">
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
    </div>
</div>
