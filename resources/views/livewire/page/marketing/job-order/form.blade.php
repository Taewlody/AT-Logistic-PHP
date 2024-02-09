<div>
    <livewire:component.page-heading title_main="Job Orders" title_sub="ใบสั่งงาน" breadcrumb_title="Marketing"
        breadcrumb_page="Job Orders" breadcrumb_page_title="Job Orders Form" />

    {{-- loading --}}
    <div wire:loading.block class="loader-wrapper">
        <div class="loader"></div>
    </div>

    <form class="form-body" wire:submit="save">
        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">

                {{-- Section 1_1 --}}
                <div class="col-lg-7 mb-2">
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
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Document No.</label>
                                        <div class="col-md-4">
                                            <input name="documentID" {!! $action == 'create' ? "type='hidden'" : "type='text'" !!} class="form-control"
                                                id="documentID" wire:model="data.documentID" readonly>
                                        </div>
                                        <input type="hidden" name="invoiceNo" id="invoiceNo"
                                            wire:model="data.invoiceNo">



                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Document
                                                Date</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" name="documentDate" class="form-control"
                                                    wire:model="data.documentDate" @disabled($action != 'create' && $action != 'edit')>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Bound</label>
                                        <div class="col-md-4">
                                            <select name="bound" class="select2_single form-control select2"
                                                id="bound" wire:model="data.bound" @disabled($action != 'create' && $action != 'edit')>
                                                <option value="1">IN BOUND</option>
                                                <option value="2">OUT BOUND</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Freight</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="freight" class="select2_single form-control select2"
                                                id="freight" wire:model="data.freight" @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($transportTypeList as $transportType)
                                                    <option value="{{ $transportType->transportCode }}">
                                                        {{ $transportType->transportName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Port of Loading</label>
                                        <div class="col-md-4">
                                            <select name="port_of_landing" class="select2_single form-control select2"
                                                id="port_of_landing" wire:model="data.port_of_landing"
                                                @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($portList as $port)
                                                    <option value="{{ $port->portCode }}">{{ $port->portNameTH }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Port of
                                                Discharge
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="port_of_discharge" class="select2_single form-control select2"
                                                id="port_of_discharge" wire:model="data.port_of_discharge"
                                                @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($portList as $port)
                                                    <option value="{{ $port->portCode }}">{{ $port->portNameTH }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">M B/L</label>
                                        <div class="col-md-4">
                                            <input type="text" name="mbl" class="form-control" id="mbl"
                                                wire:model="data.mbl" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">H B/L</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="hbl" class="form-control" id="hbl"
                                                wire:model="data.hbl" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">C/O</label>
                                        <div class="col-md-4">
                                            <input type="text" name="co" class="form-control" id="co"
                                                wire:model="data.co" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Paper Less
                                                Code</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="paperless" class="form-control"
                                                id="paperless" wire:model="data.paperless"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Bill of lading</label>
                                        <div class="col-md-4">
                                            <input type="text" name="bill_of_landing" class="form-control"
                                                id="bill_of_landing" wire:model="data.bill_of_landing"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <label class="col-lg-2 col-form-label">Import Entry</label>
                                        <div class="col-md-4">
                                            <input type="text" name="import_entry" class="form-control"
                                                id="import_entry" wire.model="data.import_entry"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                    </div>
                                    <div class="form-group row date">
                                        <label class="col-lg-2 col-form-label">ETD</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date"> <span class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span>
                                                <input type="text" name="etdDate" id="etdDate"
                                                    class="form-control" wire:model="data.etdDate"
                                                    @disabled($action != 'create' && $action != 'edit')>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">ETA</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="input-group date"> <span class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span>
                                                <input name="etaDate" id="etaDate" type="text"
                                                    class="form-control" wire.model="data.etaDate"
                                                    @disabled($action != 'create' && $action != 'edit')>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row date">
                                        <label class="col-lg-2 col-form-label">Closing Date</label>
                                        <div class="col-lg-4">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input name="closingDate" type="text" class="form-control"
                                                    id="closingDate" wire:model="data.closingDate"
                                                    @disabled($action != 'create' && $action != 'edit')>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Time</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <input name="closingTime" type="text" class="form-control"
                                                    id="closingTime" wire.model="data.closingTime"
                                                    @disabled($action != 'create' && $action != 'edit')>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">INV No.</label>
                                        <div class="col-md-4">
                                            <input type="text" name="invNo" class="form-control" id="invNo"
                                                wire:model="data.invNo" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Bill</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="bill" class="form-control" id="bill"
                                                wire:model="data.bill" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Booking No.</label>
                                        <div class="col-md-4">
                                            <input type="text" name="bookingNo" class="form-control"
                                                id="bookingNo" wire:model="data.bookingNo"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Delivery
                                                Type</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="deliveryType" class="select2_single form-control select2"
                                                id="deliveryType" wire:model="data.deliveryType"
                                                @disabled($action != 'create' && $action != 'edit')>
                                                <option value="FCL">FCL</option>
                                                <option value="LCL">LCL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">FOB AT</label>
                                        <div class="col-md-4">
                                            <select name="fob" class="select2_single form-control select2"
                                                id="fob" wire:model="data.fob" @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($placeList as $place)
                                                    <option value="{{ $place->pCode }}">{{ $place->pName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Place of
                                                receive
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="place_receive" class="select2_single form-control select2"
                                                id="place_receive" wire:model="data.place_receive"
                                                @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($placeList as $place)
                                                    <option value="{{ $place->pCode }}">{{ $place->pName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Free Time</label>
                                        <div class="col-md-4">
                                            <input type="number" name="freetime" class="form-control"
                                                id="freetime" wire:model="data.freetime"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">
                                                <span
                                                    id="textboundType">{{ $data->bound == '1' ? 'IN BOUND' : 'OUT BOUND' }}</span>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input name="freetimeEXP" id="freetimeEXP" type="text"
                                                    wire:model="data.freetimeEXP" class="form-control"
                                                    @disabled($action != 'create' && $action != 'edit')>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 1_2 --}}
                <div class="col-lg-5 mb-2">
                    <div id="accordion-2" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingSale">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSale" aria-expanded="true"
                                        aria-controls="collapseSale">
                                        Sale / Customer / Agent / Feeder
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseSale" role="tabpanel" class="collapse show"
                                aria-labelledby="headingSale" data-bs-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Customer</label>
                                        <div class="col-md-10">
                                            <select name="cusCode" class="select2_single form-control select2"
                                                id="cusCode" wire:model="data.cusCode"
                                                @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($customerList as $customer)
                                                    <option value="{{ $customer->cusCode }}">{{ $customer->cusName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Sales</label>
                                        <div class="col-md-10">
                                            <select name="saleman" class="select2_single form-control select2"
                                                id="saleman" wire:model="data.saleman"
                                                @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($salemanList as $saleman)
                                                    <option value="{{ $saleman->usercode }}">{{ $saleman->empName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            {{-- <input name="saleman" type="text" required class="form-control" id="saleman" placeholder=""
                                                value="<?php echo $saleman; ?>" readonly="readonly"> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Contact</label>
                                        <div class="col-md-10">
                                            <input type="text" name="cusContact" class="form-control"
                                                id="cusContact" wire:model="data.cusContact"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Agent</label>
                                        <div class="col-md-10">
                                            <select name="agentCode" class="select2_single form-control select2"
                                                id="agentCode" wire:model="data.agentCode"
                                                @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($supplierList as $supplier)
                                                    <option value="{{ $supplier->supCode }}">
                                                        {{ $supplier->supNameTH }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Contact</label>
                                        <div class="col-md-10">
                                            <input type="text" name="agentContact" class="form-control"
                                                id="agentContact" wire:model="data.agentContact"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Feeder</label>
                                        <div class="col-md-5">
                                            <select name="feeder" class="select2_single form-control select2"
                                                id="feeder" wire:model="data.feeder" @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($feederList as $feeder)
                                                    <option value="{{ $feeder->fCode }}">{{ $feeder->fName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="col-form-label" style="padding-top: 5px;">VOY</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="feederVOY" class="form-control"
                                                id="feederVOY" wire:model="data.feederVOY"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Vessel</label>
                                        <div class="col-md-5">
                                            <select name="vessel" class="select2_single form-control select2"
                                                id="vessel" wire:model="data.vessel" @disabled($action != 'create' && $action != 'edit')>
                                                <option value="">- select -</option>
                                                @foreach ($feederList as $feeder)
                                                    <option value="{{ $feeder->fCode }}">{{ $feeder->fName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="col-form-label" style="padding-top: 5px;">VOY</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="vesselVOY" class="form-control"
                                                id="vesselVOY" wire:model="data.vesselVOY"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Note</label>
                                        <div class="col-md-10">
                                            <textarea name="note" rows="4" class="form-control" id="note" wire:model="data.note"
                                                @disabled($action != 'create' && $action != 'edit')></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label"></label>
                                        <div class="col-md-10"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 3 --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-3" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingLocation">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseLocation" aria-expanded="true"
                                        aria-controls="collapseLocation">
                                        Location
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseLocation" role="tabpanel" class="collapse"
                                aria-labelledby="headingLocation" data-bs-parent="#accordion-3">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Stuffing</label>
                                        <div class="col-md-3">
                                            <input type="text" name="stu_location" class="form-control"
                                                placeholder="location" id="stu_location"
                                                wire:model="data.stu_location" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="stu_contact" type="text" class="form-control"
                                                id="stu_contact" placeholder="Contact Person" autocomplete="empty"
                                                wire:model="data.stu_contact" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="stu_mobile" class="form-control"
                                                placeholder="Mobile" id="stu_mobile" wire:model="data.stu_mobile"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" name="stu_date" class="form-control"
                                                    wire:model="data.stu_date" @disabled($action != 'create' && $action != 'edit')>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">CY</label>
                                        <div class="col-md-3">
                                            <input type="text" name="cy_location" class="form-control"
                                                placeholder="location" id="cy_location" wire:model="data.cy_location"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="cy_contact" class="form-control"
                                                placeholder="Contact Person" id="cy_contact" autocomplete="empty"
                                                wire:model="data.cy_contact" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="cy_mobile" class="form-control"
                                                placeholder="Mobile" id="cy_mobile" wire:model="data.cy_mobile"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar "></i>
                                                </span>
                                                <input type="text" name="cy_date" id="cy_date"
                                                    class="form-control" wire:model="data.cy_date"
                                                    @disabled($action != 'create' && $action != 'edit')>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">RTN</label>
                                        <div class="col-md-3">
                                            <input type="text" name="rtn_location" class="form-control"
                                                placeholder="location" id="rtn_location"
                                                wire:model="data.rtn_location" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="rtn_contact" class="form-control"
                                                placeholder="Contact Person" id="rtn_contact" autocomplete="empty"
                                                wire:model="data.rtn_contact" @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="rtn_mobile" class="form-control"
                                                placeholder="Mobile" id="rtn_mobile" wire:model="data.rtn_mobile"
                                                @disabled($action != 'create' && $action != 'edit')>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group date"> <span class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span>
                                                <input type="text" name="rtn_date" id="rtn_date"
                                                    class="form-control" wire:model="data.rtn_date"
                                                    @disabled($action != 'create' && $action != 'edit')>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 4 --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-4" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingContainers">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseContainers" aria-expanded="true"
                                        aria-controls="collapseContainers">
                                        Containers
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseContainers" role="tabpanel" class="collapse"
                                aria-labelledby="headingContainers" data-bs-parent="#accordion-4">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Type</label>
                                            <select name="containerTypeHeader"
                                                class="select2_single form-control select2" id="containerTypeHeader"
                                                style="width: 100%" wire:model="typeContainer">
                                                <option value="">- select -</option>
                                                @foreach ($containerTypeList as $containerType)
                                                    <option value="{{ $containerType->containertypeCode }}">
                                                        {{ $containerType->containertypeName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Size</label>
                                            <select name="containerSizeHeader" id="containerSizeHeader"
                                                class="select2_single form-control select2" style="width: 100%"
                                                wire:model="sizeContainer">
                                                <option value="">- select -</option>
                                                @foreach ($containerSizeList as $containerSize)
                                                    <option value="{{ $containerSize->containersizeCode }}">
                                                        {{ $containerSize->containersizeName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="col-form-label" style="padding-top: 5px;">จำนวน</label>
                                            <input name="containQty" type="number" class="form-control"
                                                id="containQty" wire:model="quantityContainer">
                                        </div>
                                        <div class="col-md-1" style="display: flex; align-items: flex-end;">
                                            <button name="btnAddQT" id="btnAddQT" class="btn btn-white"
                                                type="button" wire:click="addContainer">
                                                <i class="fa fa-plus"></i>Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="table_container" class="table" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">No.</th>
                                                        <th style="width:10%">Container Type</th>
                                                        <th style="width:10%">Size</th>
                                                        <th style="width:10%">Container No.</th>
                                                        <th style="width:10%">Seal No.</th>
                                                        <th style="width:10%">Gross Weight</th>
                                                        <th style="width:10%">GW.Unit</th>
                                                        <th style="width:10%"> Net Weight</th>
                                                        <th style="width:10%">NW.Unit</th>
                                                        <th style="width:10%">Tare Weight</th>
                                                        <th style="width:10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data->containerList as $container)
                                                        <tr id="tr{{ $loop->iteration }}"
                                                            wire:key="container-field-{{ $container->items }}">
                                                            <td>
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>
                                                                <select class="select2_single form-control select2"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerType"
                                                                    style="width: 100%">
                                                                    <option value="">- select -</option>
                                                                    @foreach ($containerTypeList as $containerType)
                                                                        <option
                                                                            value="{{ $containerType->containertypeCode }}">
                                                                            {{ $containerType->containertypeName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="select2_single form-control select2"
                                                                    style="width: 100%"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerSize">
                                                                    <option value="">- select -</option>
                                                                    @foreach ($containerSizeList as $containerSize)
                                                                        <option
                                                                            value="{{ $containerSize->containersizeCode }}">
                                                                            {{ $containerSize->containersizeName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerNo">
                                                            </td>
                                                            <td class="center">
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerSealNo">
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerSealNo">
                                                            </td>
                                                            <td class="center">
                                                                <select name="containerGW_unit[]"
                                                                    class="select2_single form-control select2"
                                                                    style="width: 100%"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerGW_unit">
                                                                    <option value="">- select -</option>
                                                                    @foreach ($containerUnitList as $unit)
                                                                        <option value="{{ $unit->unitCode }}">
                                                                            {{ $unit->unitName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="center">
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerNW">
                                                            </td>
                                                            <td class="center">
                                                                <select class="select2_single form-control select2"
                                                                    style="width: 100%"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerNW_Unit">
                                                                    <option value="">- select -</option>
                                                                    @foreach ($containerUnitList as $unit)
                                                                        <option value="{{ $unit->unitCode }}">
                                                                            {{ $unit->unitName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="center">
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.container_list.{{ $loop->index }}.containerTareweight">
                                                            </td>
                                                            <td class="center">
                                                                <button type="button" class="btn-white btn btn-xs"
                                                                    wire:click="containerRemove('{{ $container->items }}')">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 5 --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-5" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingPackaged">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsePackaged" aria-expanded="true"
                                        aria-controls="collapsePackaged">
                                        Packaged Size
                                    </a>
                                </h2>
                            </div>
                            <div id="collapsePackaged" role="tabpanel" class="collapse"
                                aria-labelledby="headingPackaged" data-bs-parent="#accordion-5">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table dataTables" width="100%" id="table_packed">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">No.</th>
                                                        <th style="width:10%">Width (cm)</th>
                                                        <th style="width:10%">Length (cm)</th>
                                                        <th style="width:10%">Height (cm)</th>
                                                        <th style="width:10%">Quantity Package</th>
                                                        <th style="width:10%">Weight/Package</th>
                                                        <th style="width:10%">Unit Weight</th>
                                                        <th style="width:10%">Total (CBM)</th>
                                                        <th style="width:10%">Total Weight</th>
                                                        <th style="width:10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data->packedList as $packed)
                                                        <tr class="gradeX"
                                                            wire:key="packed-field-{{ $packed->items }}">
                                                            <td>
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td><span class="center">
                                                                    <input type="number" class="form-control"
                                                                        wire:model="data.packed_list.{{ $loop->index }}.packaed_width">
                                                                    {{-- onchange="return FN_CalPacked('<?php echo $i; ?>');"> --}}
                                                                </span></td>
                                                            <td><span class="center">
                                                                    <input type="number" class="form-control"
                                                                        wire:model="data.packed_list.{{ $loop->index }}.packaed_length">
                                                                    {{-- onchange="return FN_CalPacked('<?php echo $i; ?>');"> --}}
                                                                    {{-- value="<?php echo $r['packaed_length']; ?>"
                                                                    id="packaed_length<?php echo $i; ?>"
                                                                    onchange="return FN_CalPacked('<?php echo $i; ?>');"> --}}
                                                                </span></td>
                                                            <td><input type="number" class="form-control"
                                                                    wire:model="data.packed_list.{{ $loop->index }}.packaed_height">
                                                                {{-- value="<?php echo $r['packaed_height']; ?>"
                                                                id="packaed_height<?php echo $i; ?>"
                                                                onchange="return FN_CalPacked('<?php echo $i; ?>');"> --}}
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control"
                                                                    wire:model="data.packed_list.{{ $loop->index }}.packaed_qty">
                                                                {{-- value="<?php echo $r['packaed_qty']; ?>"
                                                                id="packaed_qty<?php echo $i; ?>"
                                                                onchange="return FN_CalPacked('<?php echo $i; ?>');"> --}}
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control"
                                                                    wire:model="data.packed_list.{{ $loop->index }}.packaed_weight">
                                                                {{-- value="<?php echo $r['packaed_weight']; ?>"
                                                                id="packaed_weight<?php echo $i; ?>"
                                                                onchange="return FN_CalPacked('<?php echo $i; ?>');"> --}}
                                                            </td>
                                                            <td class="center">
                                                                <select class="select2_single form-control select2"
                                                                    style="width: 100%"
                                                                    wire:model="data.packed_list.{{ $loop->index }}.packaed_unit">
                                                                    {{-- id="packaed_unit<?php echo $i; ?>"
                                                                onchange="return FN_CalPacked('<?php echo $i; ?>');"> --}}
                                                                    <option value="">- select -</option>
                                                                    @foreach ($containerUnitList as $unit)
                                                                        <option value="{{ $unit->unitCode }}">
                                                                            {{ $unit->unitName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control"
                                                                    wire:model="data.packed_list.{{ $loop->index }}.packaed_totalCBM">
                                                                {{-- value="<?php echo n2(0); ?>"
                                                                id="packaed_totalCBM<?php echo $i; ?>"> --}}
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control"
                                                                    wire:model="data.packed_list.{{ $loop->index }}.packaed_totalWeight">
                                                                {{-- value="<?php echo n2($r['packaed_totalWeight']); ?>"
                                                                id="packaed_totalWeight<?php echo $i; ?>"> --}}
                                                            </td>
                                                            <td class="center">
                                                                <button type="button" class="btn-white btn btn-xs"
                                                                    wire:click="removePacked('{{ $packed->items }}')">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <a class="btn btn-white btn-xs" id="addpacked">
                                            <i class="fa fa-plus "></i>
                                            Add New Row
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 6 --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-6" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingGoods">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseGoods" aria-expanded="true"
                                        aria-controls="collapseGoods">
                                        Goods / สินค้า
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseGoods" role="tabpanel" class="collapse" aria-labelledby="headingGoods"
                                data-bs-parent="#accordion-6">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table" width="100%" id="table_product">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">No.</th>
                                                        <th style="width:10%">No of Package</th>
                                                        <th style="width:10%">Description</th>
                                                        <th style="width:10%">Weight</th>
                                                        <th style="width:10%">Unit</th>
                                                        <th style="width:10%">Size</th>
                                                        <th style="width:10%">Kind of package</th>
                                                        <th style="width:10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data->goodsList as $goods)
                                                        <tr class="gradeX"
                                                            wire:key="goods-field-{{ $goods->items }}">
                                                            <td>
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.goods_list.{{ $loop->index }}.goodNo">
                                                                {{-- value="<?php echo $r['goodNo']; ?>"
                                                                id="goodNo<?php echo $i; ?>"> --}}
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.goods_list.{{ $loop->index }}.goodDec">
                                                                {{-- value="<?php echo $r['goodDec']; ?>"
                                                                id="goodDec<?php echo $i; ?>"> --}}
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    wire:model="data.goods_list.{{ $loop->index }}.goodWeight">
                                                                {{-- value="<?php echo $r['goodWeight']; ?>"
                                                                id="goodWeight<?php echo $i; ?>"> --}}
                                                            </td>
                                                            <td>
                                                                <select class="select2_single form-control select2"
                                                                    style="width: 100%"
                                                                    wire:model="data.goods_list.{{ $loop->index }}.goodUnit">
                                                                    {{-- id="good_unit<?php echo $i; ?>"> --}}
                                                                    <option value="">- select -</option>
                                                                    @foreach ($containerUnitList as $unit)
                                                                        <option value="{{ $unit->unitCode }}">
                                                                            {{ $unit->unitName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="center">
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.goods_list.{{ $loop->index }}.goodSize">
                                                                {{-- value="<?php echo $r['goodSize']; ?>"
                                                                id="goodSize<?php echo $i; ?>"> --}}
                                                            </td>
                                                            <td class="center">
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.goods_list.{{ $loop->index }}.goodKind">
                                                                {{-- value="<?php echo $r['goodKind']; ?>"
                                                                id="goodKind<?php echo $i; ?>"> --}}
                                                            </td>
                                                            <td class="center">
                                                                <button type="button" class="btn-white btn btn-xs"
                                                                    wire:click="removeGoods('{{ $goods->items }}')">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <button type="button" class="btn btn-white btn-xs" id="addproduct">
                                            <i class="fa fa-plus "> </i>
                                            Add New Row
                                        </button>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Total Number of Package (in
                                            words)</label>
                                        <div class="col-md-4">
                                            <input type="text" name="good_total_num_package" class="form-control"
                                                wire:model="data.good_total_num_package">
                                        </div>
                                        <div class="col-md-1">
                                            <label style="padding-top: 5px;">Commodity</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="good_commodity" class="form-control"
                                                wire:model="data.good_commodity">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 7 --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-7" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingCharges">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseCharges" aria-expanded="true"
                                        aria-controls="collapseCharges">
                                        Charges / ค่าใช้จ่าย
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseCharges" role="tabpanel" class="collapse"
                                aria-labelledby="headingCharges" data-bs-parent="#accordion-7">
                                <div class="card-body">
                                    {{-- <div class="form-group  row">
                                        <div class="col-md-6">
                                            <select class="select2_single form-control select2" style="width: 100%;"
                                                id="chargeCode">
                                                <?php $db->s_charge(''); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="padding-left: 0px;">
                                            <button class="btn btn-white " type="button" name="addCharge"
                                                id="addCharge"><i class="fa fa-plus"></i>
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="table-responsive" id="containner_charge">
                                            <table class="table" width="100%" id="table_charge">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">No.</th>
                                                        <th style="width:10%">Detail</th>
                                                        <th style="width:10%">Price</th>
                                                        <th style="width:10%">Volum</th>
                                                        <th style="width:10%">Exchange</th>
                                                        <th style="width:10%">Cost</th>
                                                        <th style="width:10%">Receive</th>
                                                        <th style="width:10%">Bill of receipt</th>
                                                        <th style="width:5%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                              $rowIdx = 1;
                                              if ($acton != 'add' && $acton != 'copy') {
                                                $sql = "
                                                SELECT * from 
                                                (SELECT
                                                j.comCode,
                                                j.ref_paymentCode,
                                                j.chargeCode,
                                                j.detail as chartDetail,
                                                j.chargesCost,
                                                j.chargesReceive,
                                                j.chargesbillReceive
                                                FROM
                                                joborder_charge AS j
                                                WHERE j.comCode='$db->comCode' AND j.documentID='$documentID' 
                                                UNION ALL
                                                SELECT
                                                i.comCode,
                                                i.documentID as ref_paymentCode,
                                                i.chargeCode,
                                                i.chartDetail,
                                                i.amount as chargesCost,
                                                0 as chargesReceive,
                                                0 as chargesbillReceive
                                                FROM  $db->dbname.payment_voucher AS m
                                                INNER JOIN $db->dbname.payment_voucher_items AS i ON m.comCode = i.comCode AND m.documentID = i.documentID
                                                WHERE m.comCode='$db->comCode' AND m.refJobNo='$documentID' AND m.documentstatus='A'
                                                UNION ALL
                                                SELECT
                                                pm.comCode,
                                                pm.documentID AS ref_paymentCode,
                                                pd.chargeCode,
                                                pd.chartDetail,
                                                pd.amount as chargesCost,
                                                0 as chargesReceive,
                                                0 as chargesbillReceive
                                                FROM $db->dbname.petty_cash AS pm
                                                INNER JOIN $db->dbname.petty_cash_items AS pd ON pm.comCode = pd.comCode AND pm.documentID = pd.documentID
                                                WHERE pm.comCode='$db->comCode' AND pm.refJobNo='$documentID' AND pm.documentstatus='A'
                                                UNION ALL
                                                SELECT
                                                pm.comCode,
                                                pm.documentID AS ref_paymentCode,
                                                pd.chargeCode,
                                                pd.chartDetail,
                                                pd.amount as chargesCost,
                                                0 as chargesReceive,
                                                0 as chargesbillReceive
                                                FROM $db->dbname.petty_cashshiping AS pm
                                                INNER JOIN $db->dbname.petty_cashshiping_items AS pd ON pm.comCode = pd.comCode AND pm.documentID = pd.documentID
                                                WHERE pm.comCode='$db->comCode' AND pm.refJobNo='$documentID' AND pm.documentstatus='A'
                                                UNION ALL
                                                SELECT
                                                pm.comCode,
                                                pm.documentID AS ref_paymentCode,
                                                pd.chargeCode,
                                                pd.chartDetail,
                                                pd.amount as chargesCost,
                                                0 as chargesReceive,
                                                0 as chargesbillReceive
                                                FROM $db->dbname.shiping_payment_voucher AS pm
                                                INNER JOIN $db->dbname.shiping_payment_voucher_items AS pd ON pm.comCode = pd.comCode AND pm.documentID = pd.documentID
                                                WHERE pm.comCode='$db->comCode' AND pm.refJobNo='$documentID' AND pm.documentstatus='A'
                          
                                                ) as t
                                                GROUP BY  t.comCode,t.chargeCode,t.ref_paymentCode,t.chartDetail    ";
                          
                          
                                                $result = $db->query($sql);
                                                $i = 1;
                          
                                                while ($r = mysqli_fetch_array($result)) {
                                                  ?>
                                                    <tr class='gradeX' id='trCharge<?php echo $rowIdx; ?>'>
                                                        <td>
                                                            <?php echo $rowIdx; ?>
                                                            <input type="hidden" name="chargeitems[]"
                                                                value="<?php echo $r['chargeCode']; ?>"
                                                                id="chargeitems<?php echo $rowIdx; ?>">
                                                            <input type="hidden" name="ref_paymentCode[]"
                                                                value="<?php echo $r['ref_paymentCode']; ?>"
                                                                id="ref_paymentCode<?php echo $rowIdx; ?>">
                                                        </td>
                                                        <td><input type="text" name="chargesDetail[]"
                                                                class="form-control" value="<?php echo $r['chartDetail']; ?>"
                                                                id="chargesDetail<?php echo $rowIdx; ?>"></td>
                                                        <td class="center"><input type="number"
                                                                name="price<?php echo $rowIdx; ?>"
                                                                onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)"
                                                                class="form-control full" value="1"
                                                                id="price<?php echo $rowIdx; ?>"></td>
                                                        <td class="center"><input type="number"
                                                                name="volum<?php echo $rowIdx; ?>"
                                                                onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)"
                                                                class="form-control full" value="1"
                                                                id="volum<?php echo $rowIdx; ?>"></td>
                                                        <td class="center"><input type="number"
                                                                name="exchange<?php echo $rowIdx; ?>"
                                                                onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)"
                                                                class="form-control full" value="1"
                                                                id="exchange<?php echo $rowIdx; ?>"></td>
                                                        <td class="center"><input type="number" name="chargesCost[]"
                                                                <?php if ($r['ref_paymentCode'] != '') {
                                                                    echo 'readonly';
                                                                }
                                                                ?> onkeyup="call_price()"
                                                                class="form-control full" value="<?php echo $r['chargesCost']; ?>"
                                                                id="chargesCost<?php echo $rowIdx; ?>"></td>
                                                        <td class="center"><input type="number"
                                                                name="chargesReceive[]" onkeyup="call_price()"
                                                                class="form-control full" value="<?php echo $r['chargesReceive']; ?>"
                                                                id="chargesReceive<?php echo $rowIdx; ?>"></td>
                                                        <td class="center"><input type="number"
                                                                name="chargesbillReceive[]" onkeyup="call_price()"
                                                                class="form-control full" value="<?php echo $r['chargesbillReceive']; ?>"
                                                                id="chargesbillReceive<?php echo $rowIdx; ?>"></td>
                                                        <td class='center'><button type='button'
                                                                class='btn-white btn btn-xs'
                                                                onClick='return FN_Remove_Table("Charge<?php echo $rowIdx; ?>")'>Remove</button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                  $rowIdx++;
                                                }
                          
                                              }
                          
                          
                                              $sqlContrainner = " SELECT 
                                            GROUP_CONCAT(t.qty) as ct
                                            from(
                                            SELECT
                                            concat(count(s.containersizeName),'x',(s.containersizeName))as qty
                                            FROM
                                            joborder_container AS j
                                            INNER JOIN common_containertype AS c ON j.comCode = c.comCode AND j.containerType = c.containertypeCode
                                            INNER JOIN common_containersize AS s ON j.comCode = s.comCode AND j.containerSize = s.containersizeCode
                                            WHERE j.documentID='$documentID'  and j.documentID<>'' 
                                            GROUP BY containersizeCode) as t ";
                                              $rcon = $db->fetch($sqlContrainner);
                          
                                              $sqlpacked = " 
                                            SELECT
                                            concat(round(sum(j.packaed_totalCBM),2),' CBM') as qtyCBM
                                            FROM
                                            joborder_packed AS j
                                            WHERE j.documentID='$documentID' and j.documentID<>'' ";
                                              $rpacked = $db->fetch($sqlpacked);
                          
                                              if ($rcon['ct'] != "") {
                                                $showCBM = $rcon['ct'];
                                              } else {
                          
                                                $showCBM = $rpacked['qtyCBM'];
                                              }
                          
                          
                                              ?>
                                                    <input type="hidden" name="rowIdx" id="rowIdx"
                                                        value="<?php echo $rowIdx; ?>">
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <td style="width:5%"></td>
                                                        <td style="width:50%;"><strong>Volum :
                                                                <?php echo $showCBM; ?>
                                                            </strong></td>
                                                        <td style="width:10%">&nbsp;</td>
                                                        <td style="width:10%">&nbsp;</td>
                                                        <td style="width:10%"><span
                                                                style="width:50%; text-align: right;">Vat 7%</span>
                                                        </td>
                                                        <td style="width:10%"><input type="hidden"
                                                                name="vat_total_chargesCost" readonly
                                                                class="form-control" value=""
                                                                id="vat_total_chargesCost"></td>
                                                        <td style="width:10%"><input type="text"
                                                                name="vat_total_chargesReceive" readonly
                                                                class="form-control" value=""
                                                                id="vat_total_chargesReceive"></td>
                                                        <td style="width:10%"><input type="hidden"
                                                                name="vat_total_chargesbillReceive" readonly
                                                                class="form-control" value=""
                                                                id="vat_total_chargesbillReceive"></td>
                                                        <td style="width:5%"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:5%"></td>
                                                        <td style="width:50%; text-align: right;">&nbsp;</td>
                                                        <td style="width:10%">&nbsp;</td>
                                                        <td style="width:10%">&nbsp;</td>
                                                        <td style="width:10%"><span
                                                                style="width:50%; text-align: right;">Toal 7%</span>
                                                        </td>
                                                        <td style="width:10%"><input type="text"
                                                                name="total_chargesCost" readonly class="form-control"
                                                                value="" id="total_chargesCost"></td>
                                                        <td style="width:10%"><input type="text"
                                                                name="total_chargesReceive" readonly
                                                                class="form-control" value=""
                                                                id="total_chargesReceive">
                                                            <input type="hidden"
                                                                name="total_chargesReceive_beforevat" readonly
                                                                class="form-control" value=""
                                                                id="total_chargesReceive_beforevat">
                                                        </td>
                                                        <td style="width:10%"><input type="text"
                                                                name="total_chargesbillReceive" readonly
                                                                class="form-control" value=""
                                                                id="total_chargesbillReceive"></td>
                                                        <td style="width:5%"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <table class="table invoice-total">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>รวม  :</strong></td>
                                                        <td><span id="total">0</span>
                                                            <input type="hidden" id="h_total" name="h_total"
                                                                value="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>ค่าบริการ Tax (3%) :</strong></td>
                                                        <td><span id="tax3">0</span>
                                                            <input type="hidden" id="h_tax3" name="h_tax3"
                                                                value="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>ค่าขนส่ง Tax (1%) :</strong></td>
                                                        <td><span id="tax1">0</span>
                                                            <input type="hidden" id="h_tax1" name="h_tax1"
                                                                value="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>รวม :</strong></td>
                                                        <td><span id="grand_total">0</span>
                                                            <input type="hidden" id="h_grand_total"
                                                                name="h_grand_total" value="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>ลูกค้าสำรองจ่าย</strong></td>
                                                        <?php
                                                        $sql = "SELECT
                                                                                                      sum(av.sumTotal) as sumTotal
                                                                                                      FROM
                                                                                                      advance_payment AS av
                                                                                                      WHERE av.refJobNo='$documentID' and av.documentstatus='A' ";
                                                        $result = $db->fetch($sql);
                                                        $h_cus_paid = $result['sumTotal'];
                                                        ?>
                                                        <td><span id="cus_paid">
                                                                <?php echo n2($h_cus_paid); ?>
                                                            </span>
                                                            <input type="hidden" id="h_cus_paid" name="h_cus_paid"
                                                                value="<?php echo n2($h_cus_paid); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>คงเหลือจ่ายจริง</strong></td>
                                                        <td><span id="net_pad">0</span>
                                                            <input type="hidden" id="h_net_pad" name="h_net_pad"
                                                                value="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 8 --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-8" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingCustomerPayment">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseCustomerPayment" aria-expanded="true"
                                        aria-controls="collapseCustomerPayment">
                                        ลูกค้าสำรองจ่าย
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseCustomerPayment" role="tabpanel" class="collapse"
                                aria-labelledby="headingCustomerPayment" data-bs-parent="#accordion-8">
                                <div class="card-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 9 --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-9" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingAttachment">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseAttachment" aria-expanded="true"
                                        aria-controls="collapseAttachment">
                                        Attach File / ไฟล์แนบ
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseAttachment" role="tabpanel" class="collapse"
                                aria-labelledby="headingAttachment" data-bs-parent="#accordion-9">
                                <div class="card-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
