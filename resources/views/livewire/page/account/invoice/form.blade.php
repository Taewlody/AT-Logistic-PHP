<div>

    <livewire:component.page-heading title_main="Invoice" title_sub="ใบแจ้งหนี้" title_sub="ใบสำคัญจ่าย"
        breadcrumb_title="Account" breadcrumb_page="Invoice" breadcrumb_page_title="Invoice Form" />

    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper" wire:target='save,approve'>
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
                                                @foreach (Service::CreditTermSelecter() as $creditTerm)
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
                                                @foreach (Service::TransportTypeSelecter() as $freight)
                                                    <option value="{{ $freight->transportCode }}">
                                                        {{ $freight->transportName }}
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
                                                @foreach (Service::JobOrderSelecter() as $job)
                                                    <option value="{{ $job->documentID }}">
                                                        {{ $job->documentID }}
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
                                            @foreach (Service::SalemanSelecter() as $saleman)
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
                                            @foreach (Service::CustomerSelecter() as $customer)
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
                                            @foreach (Service::SupplierSelecter() as $supplier)
                                                <option value="{{ $supplier->supCode }}">
                                                    {{ $supplier->supNameTH }}
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
                                aria-labelledby="headingDetail" data-bs-parent="#accordion-3" wire:ignore.self>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <select class="select2_single form-control select2" style="width: 100%;"
                                                id="chargeCode" wire:model.change="chargeCode">
                                                <option value="">- select -</option>
                                                @foreach (Service::ChargesSelecter() as $charge)
                                                    <option value="{{ $charge->chargeCode }}">
                                                        {{ $charge->chargeName }}
                                                    </option>
                                                @endforeach
                                
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="padding-left: 0px;">
                                            <button class="btn btn-white " type="button" name="addPayment" wire:click="addPayment" @disabled($chargeCode == '')
                                                id="addPayment"><i class="fa fa-plus"></i>
                                                Add</button>
                                        </div>
                                    </div>
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
                                                    @foreach ($payments as $item)
                                                        <tr class='gradeX'
                                                            wire:key="item-field-{{ $item->items }}">

                                                            <td>
                                                                {{ $loop->iteration }}
                                                              </td>
                                                              <td>
                                                                <input type='text' class='form-control'
                                                                    wire:model.live.debounce.500ms='payments.{{$loop->index}}.detail'>
                                                              </td>
                                                              <td class='center'>
                                                                <input type='number' class='form-control'
                                                                    wire:model.live.debounce.500ms.number='payments.{{$loop->index}}.chargesCost'>
                                                              </td>
                                                              <td class='center'>
                                                                <input type='number' class='form-control'
                                                                    wire:model.live.debounce.500ms.number='payments.{{$loop->index}}.chargesReceive'>
                                                              </td>
                                                              <td class='center'>
                                                                <input type='number' class='form-control'
                                                                    wire:model.live.debounce.500ms.number='payments.{{$loop->index}}.chargesbillReceive'>
                                                              </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="center"><span>{{$payments->sum('chargesCost')}}</span></td>
                                                        <td class="center"><span>{{$payments->sum('chargesReceive')}}</span></td>
                                                        <td class="center"><span>{{$payments->sum('chargesbillReceive')}}</span></td>
                                                    </tr>

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
                                                     <td><strong>Vat 7% :</strong></td>
                                                              
                                                     <td><span id="tax">{{$this->data->total_vat}}</span></td>
                                                   </tr>
                                                   <tr>
                                                     <td><strong>TOTAL :</strong></td>
                                                     <td><span id="total">{{$this->data->total_amt}}</span></td>
                                                   </tr>
                                             
                                                   <tr>
                                                     <td><strong>WH TAX 3% :</strong></td>
                                                     <td><span id="wh_tax3">{{$this->data->tax3}}</span></td>
                                                   </tr>
                                                   <tr>
                                                     <td><strong>WH TAX 1% :</strong></td>
                                                     <td><span id="wh_tax1">{{$this->data->tax1}}</span></td>
                                                   </tr>
                                                   <tr>
                                                     <td><strong>NET PAD:</strong></td>
                                                     <td><span id="net_pad">{{$this->data->total_netamt}}</span></td>
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
                    <div class="card">
                        <div class="card-header">
                            <h3>Action</h3>
                        </div>
                        <div class="card-body">
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
                                    <a name="back" class="btn btn-white" type="button" href="{{ route('invoice') }}" wire.loading.attr="disabled">
                                        <i class="fa fa-reply"></i> Back</a>

                                        @if($data->documentstatus != 'A')
                                        <button name="save" id="save" class="btn  btn-success" type="button"
                                            wire:click='save' @disabled($data->documentstatus != 'A')>
                                            <i class="fa fa-save"></i> Save</button>
                                        @endif
                                        <button name="approve" id="approve" class="btn btn-primary" type="button"
                                            @disabled($data->documentstatus == 'A')>
                                            <i class="fa fa-check"></i> Approve</button>
                                        @if($data->documentID != null && $data->documentID != '')
                                            <a class="btn" target="_blank" href="{{'/api/print/invoice_pdf/'.$data->documentID}}"><i class="fa fa-print"></i>
                                                Print</a>
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
