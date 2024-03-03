<div>
    <livewire:component.page-heading title_main="Charges" title_sub="ค่าใช้จ่าย" breadcrumb_title="Common Data"
        breadcrumb_page="Charges" breadcrumb_page_title="Charges Form" />

    <div class="container-fluid">
        <!-- Body-->

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Charges info</h3>
                        </label>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Charges Code</label>
                        <div class="col-md-2">
                            <input type="text" name="chargeCode" id="chargeCode" class="form-control"
                                readonly wire:model="data.chargeCode" @disabled($action != 'create')>
                        </div>
                    </div>



                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Charges Name</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="chargeName"
                                id="chargeName" wire:model="data.chargeName" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Charges Type</label>
                        <div class="col-md-2">
                            <select class="select2_single form-control select2" id="typeCode" name="typeCode" wire:model="data.typeCode" @disabled($action != 'create' && $action != 'edit')>
                                <option value="">- select -</option>
                                @foreach ($ChargesTypeList as $ChargesType)
                                    <option value="{{ $ChargesType->typeCode }}">{{ $ChargesType->typeName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Input tax</label>
                        <div class="col-sm-10">
                            <input id="radio-Yes" type="radio" wire:model.boolean="data.purchaseVat"
                                value="true" @disabled($action != 'create' && $action != 'edit')>
                            <label for="radio-Yes" class="checkbox-inline i-checks">Yes </label>

                            <input id="radio-No" type="radio" wire:model.boolean="data.purchaseVat"
                                value="false" @disabled($action != 'create' && $action != 'edit')>
                            <label for="radio-No" class="i-checks">No</label>
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
                            <a name="back" class="btn btn-white" type="button" href="{{ route('charges') }}"
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
