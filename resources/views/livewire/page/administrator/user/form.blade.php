<div>

    <livewire:component.page-heading title_main="User" title_sub="ผู้ใช้งาน" breadcrumb_title="Common Data"
        breadcrumb_page="User" breadcrumb_page_title="User Form" />

    <div class="container-fluid">

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox ">
                                <div class="ibox-content">
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">
                                            <h3><a>User</a> info</h3>
                                        </label>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label"><a>User</a> Code</label>
                                        <div class="col-md-2">
                                            <input type="text" name="usercode" id="usercode" wire:model="data.usercode"
                                            @readonly($action != 'create') class="form-control">
                                        </div>
                                    </div>

                                    {{-- <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-2">
                                            <input type="password" name="userpass" id="userpass" value="<?php echo $userpass; ?>"
                                                class="form-control">

                                            <input type="hidden" name="checkPass" id="checkPass" value="<?php echo $userpass; ?>">
                                        </div>
                                    </div> --}}

                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="username" id="username" class="form-control"
                                                wire:model="data.username">
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Surname</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="surname" id="surname" class="form-control" wire:model="data.surname">
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">User Type</label>
                                        <div class="col-sm-2">
                                            <select class="select2_single form-control select2" name="userTypecode" wire:model="data.userTypecode"
                                                id="userTypecode" @disabled($action != 'create' && $action != 'edit' && Auth::user()->UserType->userTypecode != '1')>
                                                <option value="">Select User Type</option>
                                                @foreach ($userTypeList as $userType)
                                                    <option value="{{ $userType->userTypecode }}">{{ $userType->userTypeName }}</option>
                                                @endforeach
                                            </select>
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
                                                <label>{{ $data->createBy->username ?? '' }}
                                                    {{ $data->createTime ?? '' }}</label>
                                            </div>
                                        </div>

                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">Update By</label>
                                            <div class="col-sm-10">
                                                <label>{{ $data->editBy->username ?? '' }} {{ $data->editTime ?? '' }}</label>
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
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
