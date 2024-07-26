<div>
    <livewire:component.page-heading title_main="Customer" title_sub="ลูกค้า" breadcrumb_title="Common Data"
        breadcrumb_page="Customer" breadcrumb_page_title="Customer Form" />

    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="submit" onkeydown="return event.key != 'Enter';">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Customer info</h3>
                        </label>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Customer Code</label>
                        <div class="col-md-2">
                            <input type="text" name="cusCode" id="cusCode" class="form-control"
                                wire:model="data.cusCode" @disabled($action != 'create') readonly>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Business Type</label>
                        <div class="col-md-2">
                            <livewire:element.select2 wire:model='data.businessType' name="Business Type" :options="Service::BusinessTypeSelecter()"
                                itemKey="id" itemValue="name" :disabled="$action != 'create' && $action != 'edit'">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Customer Name <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="custNameTH" id="custNameTH" wire:model="data.custNameTH"
                                autocomplete="empty" placeholder="Name (TH)" class="form-control"
                                @disabled($action != 'create' && $action != 'edit')>
                                @error('data.custNameTH')
                                    <div class="text-danger m-2">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="custNameEN" id="custNameEN" wire:model="data.custNameEN"
                                placeholder="Name (EN)" class="form-control" @disabled($action != 'create' && $action != 'edit')>
                                @error('data.custNameEN')
                                    <div class="text-danger m-2">{{ $message }}</div>
                                @enderror
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
                            <input type="text" class="form-control" name="zipCode" autocomplete="empty"
                                wire:model="data.zipCode" id="zipCode" @disabled($action != 'create' && $action != 'edit')>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Country <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <livewire:element.select2 wire:model='data.countryCode' name="Country" :options="Service::CountrySelecter()"
                                itemKey="countryCode" itemValue="countryNameEN" :disabled="$action != 'create' && $action != 'edit'">
                                @error('data.countryCode')
                                    <div class="text-danger m-2">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tax ID</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="taxID" autocomplete="empty"
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
                        <label class="col-sm-2 col-form-label">Credit (Day)</label>
                        <div class="col-md-2">
                            <livewire:element.select2 wire:model='data.creditDay' name="creditDay" :options="Service::CreditTermSelecter()"
                                itemKey="creditCode" itemValue="creditName" :disabled="$action != 'create' && $action != 'edit'">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sale</label>
                        <div class="col-md-2">
                            <livewire:element.select2 wire:model='data.salemanID' name="Sale" :options="Service::SalemanSelecter()"
                                itemKey="usercode" itemValue="empName" :disabled="$action != 'create' && $action != 'edit'">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">User</label>
                        <div class="col-md-2">
                            <livewire:element.select2 wire:model='data.usercode' name="User" :options="Service::UserSelecter(Role::CUSTOMER)"
                                itemKey="userCode" itemValue="username" :disabled="$action != 'create' && $action != 'edit'">
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label class="col-form-label">
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
                                <label>{{ $data->createBy->username ?? '' }} {{ $data->createTime ?? '' }}</label>
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
                                href="{{ route('customer') }}"><i class="fa fa-reply"></i> Back</a>
                            @if ($action == 'create' || $action == 'edit')
                                <button name="save" id="save" class="btn btn-primary"
                                    type="submit"><i class="fa fa-save"></i> Save</button>
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