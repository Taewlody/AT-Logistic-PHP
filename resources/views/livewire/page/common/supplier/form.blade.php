<div>
    <livewire:component.page-heading title_main="Supplier" title_sub="ผู้จำหน่าย" breadcrumb_title="Common Data"
        breadcrumb_page="Supplier" breadcrumb_page_title="Supplier Form" />

    <div class="container-fluid">

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save" onkeydown="return event.key != 'Enter';">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Supplier info</h3>
                        </label>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Code</label>
                        <div class="col-md-2">
                            <input type="text" name="supCode" id="supCode" class="form-control"
                                wire:model="data.supCode" @disabled($action != 'create')>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Business Type</label>
                        <div class="col-md-2">
                            <select class="select2_single form-control select2" name="businessType"
                                wire:model="data.businessType" id="businessType" @disabled($action != 'create' && $action != 'edit')>
                                <option value="1">Corporation</option>
                                <option value="2">individual</option>
                            </select>


                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Supplier Name</label>
                        <div class="col-md-4">
                            <input type="text" name="custNameTH" id="custNameTH" wire:model="data.supNameTH"
                                autocomplete="empty" placeholder="Name (TH)" class="form-control"
                                @disabled($action != 'create' && $action != 'edit')>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="custNameEN" id="custNameEN" wire:model="data.supNameEN"
                                placeholder="Name (EN)" class="form-control" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Branch Code</label>
                        <div class="col-md-2">
                            <input type="text" name="branchCode" id="branchCode" wire:model="data.branchCode"
                                autocomplete="empty" class="form-control" @disabled($action != 'create' && $action != 'edit')>
                        </div>

                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Branch Name</label>



                        <div class="col-md-4">
                            <input type="text" name="branchTH" id="branchTH" autocomplete="empty"
                                wire:model="data.branchTH" placeholder="Branch (TH)" class="form-control"
                                @disabled($action != 'create' && $action != 'edit')>
                        </div>


                        <div class="col-md-4">
                            <input type="text" name="branchEN" id="branchEN" autocomplete="empty"
                                wire:model="data.branchEN" placeholder="Branch (EN)" class="form-control"
                                @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input name="addressTH" type="text" class="form-control" id="addressTH"
                                wire:model="data.addressTH" autocomplete="empty" placeholder="Address (TH)"
                                @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <input name="addressEN" type="text" class="form-control" id="addressEN"
                                wire:model="data.addressEN" autocomplete="empty" placeholder="Address (EN)"
                                @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Zip Code</label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="zipCode" autocomplete="empty"
                                wire:model="data.zipCode" id="zipCode" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Country</label>
                        <div class="col-md-2">
                            <select class="select2_single form-control select2" name="countryCode"
                                wire:model="data.countryCode" id="countryCode" @disabled($action != 'create' && $action != 'edit')>
                                <option value="">- select -</option>
                                @foreach ($countryList as $country)
                                    <option value="{{ $country->countryCode }}">{{ $country->countryNameTH }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tax ID</label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="taxID" autocomplete="empty"
                                wire:model="data.taxID" id="taxID" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Fax</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="fax" autocomplete="empty"
                                wire:model="data.fax" id="fax" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="tel" autocomplete="empty"
                                wire:model="data.tel" id="tel" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="mobile" autocomplete="empty"
                                wire:model="data.mobile" id="mobile" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">User</label>
                        <div class="col-md-2">
                            <livewire:element.select2 wire:model='data.usercode' name="User" :options="Service::UserSelecter(Role::SUPPLIER)"
                                itemKey="userCode" itemValue="username" :disabled="$action != 'create' && $action != 'edit'">
                        </div>
                    </div>


                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Contact Person info</h3>
                        </label>
                        <div class="col-md-2"> </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Contact Name</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="contactName"
                                wire:model="data.contactName" autocomplete="empty" id="contactName"
                                @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="contactMobile"
                                wire:model="data.contactMobile" autocomplete="empty" id="contactMobile"
                                @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">E-Mail</label>
                        <div class="col-md-2">
                            <input type="email" class="form-control" name="contactEmail"
                                wire:model="data.contactEmail" autocomplete="empty" id="contactEmail"
                                @disabled($action != 'create' && $action != 'edit')>
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
                                href="{{ route('supplier') }}" wire.loading.attr="disabled">
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
