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
                                    <div class="form-group  row">
                                        <div class="col-md-6">
                                            <select class="select2_single form-control select2" style="width: 100%;"
                                                id="chargeCode" wire:model="chargeCode">
                                                <option value="">- select -</option>
                                                @foreach ($chargesList as $charge)
                                                    <option value="{{ $charge->chargeCode }}">
                                                        {{ $charge->chargeName }}
                                                    </option>
                                                @endforeach

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
                                                    @foreach ($data->charge as $charge)
                                                        <tr class='gradeX'
                                                            wire:key="charge-field-{{ $charge->item }}">
                                                            <td>
                                                                {{ $loop->iteration }}
                                                                <input type="hidden"
                                                                    wire:model="data.charge.{{ $loop->index }}.chargeCode">
                                                                <input type="hidden"
                                                                    wire:model="data.charge.{{ $loop->index }}.ref_paymentCode">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    wire:model="data.charge.{{ $loop->index }}.detail">
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control full"
                                                                    {{-- name="price<?php echo $rowIdx; ?>"
                                                                onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)"
                                                                class="form-control full" value="1"
                                                                id="price<?php echo $rowIdx; ?>"> --}}
                                                                    wire:model="data.charge.{{ $loop->index }}.price">
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control full"
                                                                    {{-- name="volum<?php echo $rowIdx; ?>"
                                                                onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)"
                                                                class="form-control full" value="1"
                                                                id="volum<?php echo $rowIdx; ?>"> --}}
                                                                    wire:model="data.charge.{{ $loop->index }}.volum">
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control full"
                                                                    {{-- name="exchange<?php echo $rowIdx; ?>"
                                                                onkeyup="call_price(),call_exchange(<?php echo $rowIdx; ?>)"
                                                                class="form-control full" value="1"
                                                                id="exchange<?php echo $rowIdx; ?>"> --}}
                                                                    wire:model="data.charge.{{ $loop->index }}.exchange">
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control full"
                                                                    {{-- name="chargesCost[]"
                                                                <?php if ($r['ref_paymentCode'] != '') {
                                                                    echo 'readonly';
                                                                }
                                                                ?> onkeyup="call_price()"
                                                                class="form-control full" value="<?php echo $r['chargesCost']; ?>"
                                                                id="chargesCost<?php echo $rowIdx; ?>"> --}}
                                                                    wire:model="data.charge.{{ $loop->index }}.chargesCost">
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control full"
                                                                    {{-- name="chargesReceive[]" onkeyup="call_price()"
                                                                class="form-control full" value="<?php echo $r['chargesReceive']; ?>"
                                                                id="chargesReceive<?php echo $rowIdx; ?>"> --}}
                                                                    wire:model="data.charge.{{ $loop->index }}.chargesReceive">
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control full"
                                                                    {{-- name="chargesbillReceive[]" onkeyup="call_price()"
                                                                class="form-control full" value="<?php echo $r['chargesbillReceive']; ?>"
                                                                id="chargesbillReceive<?php echo $rowIdx; ?>"> --}}
                                                                    wire:model="data.charge.{{ $loop->index }}.chargesbillReceive">
                                                            </td>
                                                            <td class='center'><button type='button'
                                                                    class='btn-white btn btn-xs'
                                                                    wire:click="removeCharge('{{ $charge->items }}')">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                                <tfoot>
                                                    {{-- <tr>
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
                                                    </tr> --}}
                                                </tfoot>
                                            </table>
                                            <table class="table invoice-total">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>รวม :</strong></td>
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
                                                        <td><span id="cus_paid">
                                                                {{-- <?php echo n2($h_cus_paid); ?> --}}
                                                            </span>
                                                            {{-- <input type="hidden" id="h_cus_paid" name="h_cus_paid"
                                                                value="<?php echo n2($h_cus_paid); ?>"> --}}
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
                                    </div>
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
                                    <div class="form-group">
                                        <table class="table" width="100%" name="table_cash" id="table_cash">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">No.</th>
                                                    <th style="width:10%">documentID</th>
                                                    <th style="width:30%">detail</th>
                                                    <th style="width:20%">Amount</th>
                                                    <th style="width:10%">View</th>
                                                    <th style="width:10%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- <td><?php echo $i; ?></td>
                                            <td><a href="advance_payment_form?action=edit&documentID=<?php echo $r['documentID']; ?>" target="_blank"><?php echo $r['documentID']; ?></a></td>
                                            <td><?php echo $r['chartDetail']; ?></td>
                                            <td><?php echo $r['amount']; ?></td>
                                            <td><?php if($r['fileName']!=''){?>
                                              <a href="customer_path/<?php echo $r['cusCode']; ?>/<?php echo $r['fileName']; ?>" target="_blank">View</a>
                                              <?php }else{?>
                                              No File
                                              <?php }?></td>
                                            <td><span class="label label-<?php echo $isActiveStype; ?>"><?php echo $r['status_name']; ?></span></td> --}}
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
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
                                    <div class="form-group">
                                        <table class="table" width="100%" name="table_attach" id="table_attach">
                                            <thead>
                                                <tr>
                                                    <th style="width:10%">document</th>
                                                    <th style="width:50%">File Name</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- <?php
                                            $sql = "SELECT
                                              t.items,
                                              t.comCode,
                                              t.documentID,
                                              t.cusCode,
                                              t.fileDetail,
                                              t.fileName
                                              FROM
                                              joborder_attach AS t
                                              WHERE t.comCode='$db->comCode' AND t.documentID='$documentID' ";
                                            $result = $db->query( $sql );
                                            $i_container = 1;
                                            $i = 99;
                            
                                            if ( $acton != 'add' && $acton != 'copy' ) {
                                              while ( $r = mysqli_fetch_array( $result ) ) {
                            
                                                ?>
                                            <tr class='gradeX' id='tr<?php echo $i; ?>'>
                                              <td><?php echo $r['documentID']; ?></td>
                                              <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'>
                                                <input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                                              <td class='center'><a class='btn-white btn btn-xs' href='customer_path/<?php echo $r['cusCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                                                </button>
                                                &nbsp;
                                                <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                                            </tr>
                                            <?php $i++; } } ?>
                                            <?php
                            
                                            $sql = "SELECT
                                              t.documentID,
                                              f.supCode,
                                              t.refJobNo,
                                              f.fileDetail,
                                              f.fileName
                                              FROM
                                              payment_voucher AS t
                                              INNER JOIN payment_voucher_attach AS f ON t.comCode = f.comCode AND t.documentID = f.documentID
                                              WHERE t.comCode='$db->comCode' AND t.refJobNo='$documentID' AND t.documentstatus='A' ";
                                            $result = $db->query( $sql );
                                            if ( $acton != 'add' && $acton != 'copy' ) {
                                              while ( $r = mysqli_fetch_array( $result ) ) {
                            
                                                ?>
                                            <tr class='gradeX' id='tr<?php echo $i; ?>'>
                                              <td><?php echo $r['documentID']; ?></td>
                                              <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'>
                                                <input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                                              <td class='center'><a class='btn-white btn btn-xs' href='supplier_path/<?php echo $r['supCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                                                </button>
                                                &nbsp;
                                                <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                                            </tr>
                                            <?php $i++; }} ?>
                                            <?php
                                            $sql = "SELECT
                                              t.documentID,
                                              f.cusCode,
                                              t.refJobNo,
                                              f.fileDetail,
                                              f.fileName
                                              FROM
                                              advance_payment AS t
                                              INNER JOIN advance_payment_attach AS f ON t.comCode = f.comCode AND t.documentID = f.documentID
                                              WHERE t.comCode='$db->comCode' AND t.refJobNo='$documentID' AND t.documentstatus='A'  ";
                                            $result = $db->query( $sql );
                                            if ( $acton != 'add' && $acton != 'copy' ) {
                                              while ( $r = mysqli_fetch_array( $result ) ) {
                            
                                                ?>
                                            <tr class='gradeX' id='tr<?php echo $i; ?>'>
                                              <td><?php echo $r['documentID']; ?></td>
                                              <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'>
                                                <input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                                              <td class='center'><a class='btn-white btn btn-xs' href='customer_path/<?php echo $r['cusCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                                                </button>
                                                &nbsp;
                                                <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                                            </tr>
                                            <?php $i++; }} ?>
                                            <?php
                                            $sql = "SELECT
                                              t.documentID,
                                              f.cusCode,
                                              t.refJobNo,
                                              f.fileDetail,
                                              f.fileName
                                              FROM
                                              deposit AS t
                                              INNER JOIN deposit_attach AS f ON t.comCode = f.comCode AND t.documentID = f.documentID
                                              WHERE t.comCode='$db->comCode' AND t.refJobNo='$documentID' AND t.documentstatus='A'  ";
                                            $result = $db->query( $sql );
                                            if ( $acton != 'add' && $acton != 'copy' ) {
                                              while ( $r = mysqli_fetch_array( $result ) ) {
                            
                                                ?>
                                            <tr class='gradeX' id='tr<?php echo $i; ?>'>
                                              <td><?php echo $r['documentID']; ?></td>
                                              <td><input type='hidden' name='imgKey[]'  value='"+obj.fileName+"' id='imgKey<?php echo $i; ?>'>
                                                <input type='text' name='fileName[]' class='form-control' value='<?php echo $r['fileDetail']; ?>' id='fileName<?php echo $i; ?>'></td>
                                              <td class='center'><a class='btn-white btn btn-xs' href='customer_path/<?php echo $r['cusCode'] . '/' . $r['fileName']; ?>' target='_blank'>View</a>
                                                </button>
                                                &nbsp;
                                                <button type='button' class='btn-white btn btn-xs' onClick='return FN_Remove_Table("<?php echo $i; ?>")'>Remove</button></td>
                                            </tr>
                                            <?php $i++; }} ?> --}}
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">File Name</label>
                                            <div class="col-md-4">
                                                <input type="text" name="attach_name" class="form-control"
                                                    id="attach_name">
                                            </div>
                                            <div id="container_attach" class="fileinput fileinput-new"
                                                data-provides="fileinput"> <span
                                                    class="btn btn-primary btn-file"><span
                                                        class="fileinput-new">Select file</span><span
                                                        class="fileinput-exists">Change</span>
                                                    <input type="file" name="attach_file" id="attach_file">
                                                </span> <span class="fileinput-filename"></span> <a href="#"
                                                    class="close fileinput-exists" data-dismiss="fileinput"
                                                    style="float: none">&times;</a> </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">Action</label>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary " type="button" name="btnUpload"
                                                    id="btnUpload"><i class="fa fa-save"></i> Upload File</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section Action --}}
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
                                    <button name="back" class="btn btn-white" type="button"
                                        onclick="window.location='job'"><i class="fa fa-reply"></i> Back</button>

                                    <button name="Approve" id="Approve" class="btn btn-primary" type="button"><i
                                            class="fa fa-save"></i> Approve</button>
                                    <button class="btn btn-white " type="button" onclick=""><i
                                            class="fa fa-print"></i> Job</button>
                                    <button class="btn btn-white " type="button" onclick=""><i
                                            class="fa fa-print"></i> Booking confirm</button>
                                    <button class="btn btn-white " type="button" onclick=""><i
                                            class="fa fa-print"></i> Trailer booking</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
