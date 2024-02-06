<div>

    <livewire:component.page-heading title_main="Saleman" title_sub="พนักงานขาย" breadcrumb_title="Common Data"
        breadcrumb_page="Saleman" breadcrumb_page_title="Saleman Form" />

    <div class="wrapper wrapper-content animated fadeInRight">
        <!-- Body-->

        {{-- loading --}}
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
                                    <h3>Saleman info</h3>
                                </label>

                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Employee Code</label>
                                <div class="col-md-2">
                                    <input type="text" name="empCode" id="empCode" autocomplete="empty"
                                        class="form-control" wire:model="data.empCode" @disabled($action != 'create')>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="empName" id="empName"
                                        autocomplete="empty" wire:model="data.empName" @disabled($action != 'create' && $action != 'edit')>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Surname</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="empSurname" id="empSurname"
                                        autocomplete="empty" wire:model="data.empSurname" @disabled($action != 'create' && $action != 'edit')>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mobile</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                        autocomplete="empty" wire:model="data.mobile" @disabled($action != 'create' && $action != 'edit')>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">E-Mail</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="email" id="email"
                                        autocomplete="empty" wire.model="data.email" @disabled($action != 'create' && $action != 'edit')>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        autocomplete="off" wire:model="data.phone" @disabled($action != 'create' && $action != 'edit')>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Refer User ID</label>
                                <div class="col-md-3">
                                    <select class="select2_single form-control select2" name="usercode" id="usercode"
                                        wire:model="data.usercode" @disabled($action != 'create' && $action != 'edit')>
                                        <option value="">Select User</option>
                                        @foreach ($userList as $user)
                                            <option value="{{ $user->usercode }}">{{ $user->username }}</option>
                                        @endforeach
                                    </select>
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
                            <a name="back" class="btn btn-white" type="button" href="{{ route('saleman') }}"
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
</div>
</div>
