<div>

    <livewire:component.page-heading title_main="Charges Type" title_sub="ประเภทค่าใช้จ่าย" breadcrumb_title="Common Data"
        breadcrumb_page="Charges Type" breadcrumb_page_title="Charges Type Form" />

    <div class="container-fluid">
        <!-- Body-->

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save" onkeydown="return event.key != 'Enter';">
                    <div class="form-group  row">
                        <label class="col-form-label">
                            <h3>Charges Type info</h3>
                        </label>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Charges Type Code</label>
                        <div class="col-md-2">
                            <input type="text" name="typeCode" id="typeCode" class="form-control"
                                wire:model="data.typeCode" @disabled($action != 'create') readonly>
                        </div>
                    </div>



                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Charges Type Name <span class="text-danger">*</span></label>

                        <div class="col-sm-10">
                            <input type="text" name="typeName" id="typeName" wire:model="data.typeName"
                                class="form-control" @disabled($action != 'create' && $action != 'edit') required>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label"> Type <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <select class="select2_single form-control select2" name="vatType" id="vatType"
                                wire:model="data.vatType" @disabled($action != 'create' && $action != 'edit')required>
                                <option value="">- select -</option>
                                @foreach ($vatTypeList as $vatType)
                                    <option value="{{ $vatType->typeCode }}">{{ $vatType->typeName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Amount (%) <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="amount" id="amount"
                                wire:model="data.amount" autocomplete="empty" @disabled($action != 'create' && $action != 'edit') required>
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
                                <label>{{ $data->createBy->username ?? '' }} {{($data->createTime && $data->createTime !== '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($data->createTime)->addHours(7)->format('Y-m-d H:i:s') : ' '}}</label>
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
                            <a name="back" class="btn btn-white" type="button" href="{{ route('charges-type') }}"
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
