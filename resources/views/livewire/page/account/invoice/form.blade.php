<div>

    <livewire:component.page-heading title_main="Invoice" title_sub="ใบแจ้งหนี้" title_sub="ใบสำคัญจ่าย"
        breadcrumb_title="Account" breadcrumb_page="Invoice" breadcrumb_page_title="Invoice Form" />

    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">
            <div class="row">

                {{-- Section 1 --}}
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
                                        <label class="col-lg-2 col-form-label"><span class="col-form-label"
                                                style="padding-top: 5px;">Document</span> No.</label>
                                        <div class="col-md-4">
                                            <input type="text" name="documentID" id="documentID" class="form-control"
                                                wire:model="data.documentID" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Document
                                                Date</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span><input type="text"
                                                    name="documentDate" class="form-control" wire:model="data.documentDate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Credit Term</label>
                                        <div class="col-md-4">
                                            <select name="creditTerm" class="select2_single form-control select2"
                                                id="creditTerm" wire:model="data.creditTerm">
                                                <option value="">- Select -</option>
                                                @foreach ($creditTermList as $creditTerm)
                                                    <option value="{{ $creditTerm->creditCode }}">
                                                        {{ $creditTerm->creditName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Your Ref.No</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="your_RefNo" class="form-control"
                                                wire:model="data.your_RefNo">
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Bound</label>
                                        <div class="col-md-4">
                                            <select class="select2_single form-control select2" name="bound" wire:model="data.bound">
                                                <option value="1" >IN BOUND</option>
                                                <option value="2" >OUT BOUND</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Commodity </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="commodity" class="form-control"
                                                wire:model="data.commodity">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">On Board</label>
                                        <div class="col-md-4">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span><input type="text"
                                                    name="on_board" class="form-control" wire:model="data.on_board">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Freight</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="freight" class="select2_single form-control select2" wire:model="data.freight"
                                                id="freight">
                                                <option value="">- Select -</option>
                                                @foreach ($TransportTypeList as $freight)
                                                    <option value="{{ $freight->freightCode }}">
                                                        {{ $freight->freightName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Qty. / Measurement</label>
                                        <div class="col-md-4">
                                            <input type="text" name="qty_measurement" class="form-control"
                                                wire:model="data.qty_measurement">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">B/L No</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="bl_No" class="form-control"
                                                wire:model="data.bl_No">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Ref. JOB NO</label>
                                        <div class="col-md-4">
                                            <select class="select2_single form-control select2" name="ref_jobID"
                                                id="ref_jobID" wire:model="data.ref_jobID">
                                                <option value="">- Select -</option>
                                                @foreach ($jobList as $job)
                                                    <option value="{{ $job->jobID }}">
                                                        {{ $job->jobID }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-lg-2 col-form-label">Origin / Destination</label>
                                        <div class="col-md-4">
                                            <input type="text" name="origin_desc" class="form-control"
                                               wire:model="data.origin_desc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2 --}}
                <div class="col-lg-5 mb-2">
                    <div id="accordion-2" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingSale">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSale" aria-expanded="true"
                                        aria-controls="collapseSale">
                                        Sale / Customer / Carrier
                                    </a>
                                </h2>
                            </div>

                            <div id="collapseSale" role="tabpanel" class="collapse show"
                                aria-labelledby="headingSale" data-bs-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Sales</label>
                                        <div class="col-md-4">
                                          <select name="saleman" class="select2_single form-control select2" id="saleman" wire:model="data.saleman">
                                            <option value="">- Select -</option>
                                            @foreach ($salemanList as $saleman)
                                                <option value="{{ $saleman->usercode }}">
                                                    {{ $saleman->empName }}
                                                </option>
                                                
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Customer</label>
                                        <div class="col-md-10">
                                          <select name="cusCode" class="select2_single form-control select2" id="cusCode" wire:model="data.cusCode">
                                            <option value="">- Select -</option>
                                            @foreach ($customerList as $customer)
                                                <option value="{{ $customer->cusCode }}">
                                                    {{ $customer->custNameEN }}
                                                </option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Address</label>
                                        <div class="col-md-10">
                                          <textarea class="form-control" name="cus_address" wire:model="cus_address"
                                            id="cus_address"></textarea>
                                        </div>
                                      </div>
                                      <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Carrier</label>
                                        <div class="col-md-10">
                                          <select name="carrier" class="select2_single form-control select2" id="carrier" wire:model="data.carrier">
                                            <option value="">- Select -</option>
                                            @foreach ($supplierList as $supplier)
                                                <option value="{{ $supplier->supCode }}">
                                                    {{ $supplier->supNameEN }}
                                                </option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row" style="margin-bottom: 29px;">
                                        <label class="col-lg-2 col-form-label">Note</label>
                                        <div class="col-md-10">
                                          <textarea name="note" class="form-control" wire:model="data.note"></textarea>
                                        </div>
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
                                aria-labelledby="headingDetail" data-bs-parent="#accordion-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="table-responsive" id="containner_charge">
                                            <table class="table" width="100%" id="table_charge">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">No.</th>
                                                        <th style="width:50%">Detail</th>
                                                        <th style="width:10%">Cost</th>
                                                        <th style="width:10%">Receive</th>
                                                        <th style="width:10%">Bill of receipt</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data->items as $item)
                                                        <tr class='gradeX'
                                                            wire:model="item-field-{{ $data->items }}">

                                                            <td>
                                                                {{ $loop->iteration }}
                                                              </td>
                                                              <td>
                                                                {{ $item->detail }}
                                                              </td>
                                                              <td class='center'>
                                                                {{ $item->chargesCost }}
                                                              </td>
                                                              <td class='center'>
                                                                {{ $item->chargesReceive }}
                                                              </td>
                                                              <td class='center'>
                                                                {{ $item->chargesbillReceive }}
                                                              </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                                <tfoot>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label"> remark
                                                <textarea rows="3" name="remark" class="form-control" wire:model="data.remark"></textarea>
                                            </label>
                                            <div class="col-lg-6">
                                                <table class="table invoice-total">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:5%"></td>
                                                            <td style="width:50%"></td>
                                                            <td style="width:10%" align="left"><span id="total_cost">
                                                                {{$data->total_cost}}
                                                              </span></td>
                                                            <td style="width:5%" align="left"><span id="total_receive">
                                                                {{$data->total_receive}}
                                                              </span></td>
                                                            <td style="width:5%" align="left"><span id="total_Bill_of_receipt">
                                                                {{$data->total_Bill_of_receipt}}
                                                              </span></td>
                                      
                                      
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
        </form>
    </div>

</div>
