<div>

    <livewire:component.page-heading title_main="Trailer Booking" title_sub="ใบจองหัวราก" breadcrumb_title="Marketing"
        breadcrumb_page="Trailer Booking" breadcrumb_page_title="Trailer Booking Form" />
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">

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
                                        <div class="col-md-4">
                                            <input type="text" name="documentID" id="documentID" class="form-control"
                                                wire:model="data.documentID" readonly>
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Document Date</label>
                                        <div class="col-md-4">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="date" name="documentDate" class="form-control"
                                                    wire:model="data.documentDate">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Customer</label>
                                        <div class="col-md-9">
                                            <select class="select2_single form-control select2" name="cusCode"
                                                wire:model="data.cusCode">
                                                <option value="">Select Customer</option>
                                                @foreach (Service::CustomerSelecter() as $customer)
                                                    <option value="{{ $customer->cusCode }}">{{ $customer->custNameEN }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Feeder</label>
                                        <div class="col-md-9">
                                            <select name="feeder" class="select2_single form-control select2"
                                                id="feeder" wire:model="data.feeder">
                                                <option value="">Select Feeder</option>
                                                @foreach (Service::FeederSelecter() as $feeder)
                                                    <option value="{{ $feeder->fCode }}">{{ $feeder->fName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Agent</label>
                                        <div class="col-md-9">
                                            <select name="agentCode" class="select2_single form-control select2"
                                                id="agentCode" wire:model="data.agent">
                                                <option value="">Select Agent</option>
                                                @foreach (Service::SupplierSelecter() as $supplier)
                                                    <option value="{{ $supplier->supCode }}">{{ $supplier->supNameTH }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Ref. JobNo.</label>
                                        <div class="col-md-9">
                                            <select class="select2_single form-control select2" name="ref_jobID"
                                                id="ref_jobID" wire:model="data.ref_jobID">
                                                <option value="">Select Ref. JobNo.</option>
                                                @foreach (Service::JobOrderSelecter() as $refJob)
                                                    <option value="{{ $refJob->documentID }}">{{ $refJob->documentID }}</option>
                                                @endforeach
                                            </select>
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
                                            <select class="select2_single form-control select2" name="tocompany"
                                                wire:model="data.tocompany">
                                                <option value="">Select Company</option>
                                                @foreach (Service::SupplierSelecter() as $supplier)
                                                    <option value="{{ $supplier->supCode }}">{{ $supplier->supNameTH }}
                                                    </option>
                                                @endforeach
                                            </select>
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



                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h2>Action</h2>
                        </div>
                        <div class="ibox-content">

                            @if ($action != 'create')
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Create By</label>
                                    <div class="col-sm-10">
                                        <label>{{ $data->createBy->username }} {{ $data->createTime ?? '' }}</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Update By</label>
                                    <div class="col-sm-10">
                                        <label>{{ $data->editBy->username }} {{ $data->editTime ?? '' }}</label>
                                    </div>
                                </div>
                            @endif

                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">

                                <div class="col-sm-10 col-sm-offset-2">


                                    <button name="save" id="save" class="btn btn-primary" type="button" wire:click='save'
                                        @disabled($data->documentstatus == 'A')>
                                        <i class="fa fa-save"></i> Save</button>
                                    <button name="approve" id="approve" class="btn btn-success " type="button" wire:click='approve'
                                        @disabled($data->documentstatus == 'A' || $data->documentID != null)>
                                        <i class="fa fa-check"></i> Approve</button>


                                    <button class="btn btn-white " type="button" onclick=""><i
                                            class="fa fa-print"></i>
                                        Print</button>
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
