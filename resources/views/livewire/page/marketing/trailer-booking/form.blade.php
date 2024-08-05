<div>

    <livewire:component.page-heading title_main="Trailer Booking" title_sub="ใบจองหัวราก" breadcrumb_title="Marketing"
        breadcrumb_page="Trailer Booking" breadcrumb_page_title="Trailer Booking Form" />
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper" wire:target='submit,approve'>
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="submit" onkeydown="return event.key != 'Enter';">

            {{-- <input type="hidden" name="jobID" id="jobID" value="<?php echo $jobID; ?>"> --}}
            <div class="row">

                <div class="col-lg-6">
                    <div id="accordion-1" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingDocument">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseDocument" aria-expanded="true"
                                        aria-controls="collapseDocument">
                                        Document
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseDocument" role="tabpanel" class="collapse show"
                                aria-labelledby="headingDocument" data-bs-parent="#accordion-1">
                                <div class="card-body">
                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Document No.</label>
                                        <div class="col-md-9">
                                            <input type="text" name="documentID" id="documentID" class="form-control"
                                                wire:model="data.documentID" readonly>
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Document Date</label>
                                        <div class="col-md-9">
                                                <input type="date" name="documentDate" class="form-control"
                                                    wire:model="data.documentDate">
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Customer</label>
                                        <div class="col-md-9">
                                            {{-- <select class="select2_single form-control select2" name="cusCode"
                                                wire:model="data.cusCode">
                                                <option value="">Select Customer</option>
                                                @foreach (Service::CustomerSelecter() as $customer)
                                                    <option value="{{ $customer->cusCode }}">{{ $customer->custNameEN }}
                                                    </option>
                                                @endforeach
                                            </select> --}}
                                            <livewire:element.select2 wire:model='data.cusCode'
                                                name="cusCode" :options="Service::CustomerSelecter()"
                                                itemKey="cusCode" itemValue="custNameEN" 
                                                :searchable="true">
                                        </div>
                                    </div>

                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Feeder</label>
                                        <div class="col-md-9">
                                            <livewire:element.select2 wire:model='data.feeder'
                                                name="feeder" :hasNan="true" :options="Service::FeederSelecter()"
                                                itemKey="fCode" itemValue="fName" 
                                                :searchable="true">
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Agent</label>
                                        <div class="col-md-9">
                                            <livewire:element.select2 wire:model='data.agent'
                                                name="agent" 
                                                :hasNan="true" :options="Service::SupplierSelecter()"
                                                itemKey="supCode" itemValue="supNameTH" 
                                                :searchable="true">
                                        </div>
                                    </div>

                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Ref. JobNo.</label>
                                        <div class="col-md-9">
                                            <livewire:element.select2 wire:model='data.ref_jobID'
                                            name="ref_jobID" :options="Service::JobOrderSelecter(false)"
                                            itemKey="documentID" itemValue="documentID"
                                            :searchable="true" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Section 2 --}}
                <div class="col-lg-6">
                    <div id="accordion-2" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingDetail">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseDetail" aria-expanded="true"
                                        aria-controls="collapseDetail">
                                        Detail
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseDetail" role="tabpanel" class="collapse show"
                                aria-labelledby="headingDetail" data-bs-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">ถึงบริษัท</label>
                                        <div class="col-md-5">
                                            {{-- <select class="select2_single form-control select2" name="tocompany"
                                                wire:model="data.tocompany">
                                                <option value="">Select Company</option>
                                                @foreach (Service::SupplierSelecter() as $supplier)
                                                    <option value="{{ $supplier->supCode }}">{{ $supplier->supNameTH }}
                                                    </option>
                                                @endforeach
                                            </select> --}}
                                            <livewire:element.select2 wire:model='data.tocompany'
                                                name="tocompany" :options="Service::SupplierSelecter()"
                                                itemKey="supCode" itemValue="supNameTH" 
                                                :searchable="true">
                                        </div>

                                        <label class="col-sm-1 col-form-label">คุณ</label>
                                        <div class="col-md-3">
                                            <input type="text" name="companyContact" class="form-control"
                                                wire:model="data.companyContact">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">ผู้สั่งงาน</label>
                                        <div class="col-md-9">
                                            <input type="text" name="work_order" class="form-control"
                                                wire:model="data.work_order">
                                        </div>
                                    </div>

                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">รายละเอียด</label>
                                        <div class="col-md-9">
                                            <textarea rows="3" class="form-control" name="description" wire:model="data.description">
                                        </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">สถานที่โหลด</label>
                                        <div class="col-md-9">
                                            <input type="text" name="loadplace" class="form-control"
                                                wire:model="data.loadplace">
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">วันที่บรรจุ</label>
                                        <div class="col-md-4">
                                            <input type="text" name="packagingDate" class="form-control"
                                                wire:model="data.packagingDate">
                                        </div>
                                        <label class="col-sm-2 col-form-label">ผู้ติดต่อ</label>
                                        <div class="col-md-3">
                                            <input type="text" name="contact" class="form-control"
                                                wire:model="data.contact">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-12 mt-2">
                    <div class="card">
                        <div class="card-header">
                            <h3>Action</h3>
                        </div>
                        <div class="card-body">

                            @if ($action != 'create')
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Create By</label>
                                    <div class="col-sm-10">
                                        <label>{{ $createBy->username ?? '' }} {{ $data->createTime ?? '' }}</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Update By</label>
                                    <div class="col-sm-10">
                                        <label>{{ $editBy->username ?? '' }} {{ $data->editTime ?? '' }}</label>
                                    </div>
                                </div>
                            @endif

                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">

                                <div class="col-sm-10 col-sm-offset-2">
                                    <a name="back" class="btn btn-white" type="button" href="{{ route('trailer-booking') }}"
                                    wire.loading.attr="disabled">
                                        <i class="fa fa-reply"></i> Back</a>
                                        
                                    @if($action !== 'view' && $data && $data->documentstatus !== 'A')

                                    <button name="save" id="save" class="btn btn-primary" type="submit">
                                        <i class="fa fa-save"></i> Save</button>
                                    @if(Auth::user()->hasRole('admin'))
                                    <button name="approve" id="approve" class="btn btn-success " type="button" wire:click='approve'>
                                        <i class="fa fa-check"></i> Approve</button>
                                    @endif
                                    @elseif($data->documentstatus === 'A')
                                        <button name="Update" id="Update" class="btn btn-secondary" wire:click="update"
                                            type="button"><i class="fa fa-check"></i> Update</button>
                                    @endif

                                    @if($data->documentID != null ||$data->documentID != '')
                                        <a class="btn btn-primary " target="_blank"
                                            href="{{'/api/print/trailer_booking_pdf/'.$data->documentID}}"
                                            ><i class="fa fa-print"></i> Print</a>
                                    @endif

                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </form>
    </div>
</div>
@push('modal')
<livewire:modal.modal-alert />
@endpush