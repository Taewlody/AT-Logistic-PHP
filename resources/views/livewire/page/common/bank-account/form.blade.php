<div>

    <livewire:component.page-heading title_main="Common Data" title_sub="Bank Account" breadcrumb_title="Common Data"
        breadcrumb_page="Bank Account" breadcrumb_page_title="Bank Account Form" />

    <div class="container-fluid">
        <!-- Body-->

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save">
                    <div class="form-group  row">
                        <label class="col-form-label">
                            <h3>Bank Account info</h3>
                        </label>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Bank Name</label>
                        <div class="col-md-2">
                            <input type="hidden" name="accountCode" id="accountCode"
                                wire:model="data.accountCode">
                            <input type="text" name="accountName" id="accountName" class="form-control "
                                wire:model="data.accountName" @disabled($action != 'create' && $action != 'edit')>

                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">initials Name</label>
                        <div class="col-sm-8">
                            <input name="accountNicname" type="text" class="form-control "
                                wire:model="data.accountNicname" id="accountNicname"
                                @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"> Account ID</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control " name="accountID" autocomplete="off"
                                wire:model="data.accountID" id="accountID" @disabled($action != 'create' && $action != 'edit')>
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
                            <a name="back" class="btn btn-white" type="button" href="{{ route('bank-account') }}"
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
