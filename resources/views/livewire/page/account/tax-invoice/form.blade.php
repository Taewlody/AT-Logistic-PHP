<div>

  <livewire:component.page-heading title_main="Tax Invoice" title_sub="ใบกำกับภาษี" title_sub="ใบกำกับภาษี"
    breadcrumb_title="Account" breadcrumb_page="Tax Invoice" breadcrumb_page_title="Tax Invoice Form" />

  <div class="wrapper wrapper-content animated fadeInRight">

    {{-- loading --}}
    <div wire:loading.flex class="loader-wrapper" wire:target='save,approve'>
      <div class="loader"></div>
    </div>

    <form class="form-body" wire:submit="save">
      <div class="row">

        {{-- Section 1 --}}
        <div class="col-lg-6 mb-2">
          <div id="accordion-1" class="default-according">
            <div class="card">
              <div class="card-header" id="headingDocument">
                <h2 class="mb-0">
                  <a role="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseDocument"
                    aria-expanded="true" aria-controls="collapseDocument">
                    Document
                  </a>
                </h2>
              </div>

              <div id="collapseDocument" role="tabpanel" class="collapse show" aria-labelledby="headingDocument"
                data-bs-parent="#accordion-1">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-lg-2 col-form-label"><span class="col-form-label"
                        style="padding-top: 5px;">Document</span> No.</label>
                    <div class="col-md-4">
                      <input type="text" name="documentIDx" id="documentIDx" class="form-control"
                        wire:model="data.documentIDx">
                    </div>
                    <div class="col-md-2">
                      <label class="col-form-label" style="padding-top: 5px;">Document
                        Date</label>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group date"> <span class="input-group-addon"><i
                            class="fa fa-calendar"></i></span>
                        <input type="text" name="documentDate" class="form-control" wire:model="data.documentDate">
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-lg-2 col-form-label"><span class="col-form-label"
                        style="padding-top: 5px;">Customer</span></label>
                    <div class="col-md-9">
                      <select name="cusCode" class="select2_single form-control select2" id="cusCode"
                        wire:model="data.cusCode">
                        <option value="">Select Customer</option>
                        @foreach (Service::CustomerSelecter() as $cus)
                        <option value="{{ $cus->cusCode }}">{{ $cus->custNameEN }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="col-lg-2 col-form-label"><span class="col-form-label"
                        style="padding-top: 5px;">Tax</span></label>
                    <div class="col-md-9">
                      <input type="text" name="taxID" class="form-control" id="taxID" wire:model="data.taxID">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-2 col-form-label"><span class="col-form-label"
                        style="padding-top: 5px;">Address</span></label>
                    <div class="col-md-9">
                      <textarea rows="2" id="cus_address" name="cus_address" class="form-control"
                        wire:model="data.cus_address"></textarea>
                    </div>
                  </div>




                  <div class="form-group row">
                    <label class="col-lg-2 col-form-label"><span class="col-form-label"
                        style="padding-top: 5px;">Note</span></label>
                    <div class="col-md-9">
                      <textarea rows="2" id="note" name="note" class="form-control" wire:model="data.note"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        {{-- Section 2 --}}
        <div class="col-lg-6 mb-2">
          <div id="accordion-2" class="default-according">
            <div class="card">
              <div class="card-header" id="headingPayment">
                <h2 class="mb-0">
                  <a role="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapsePayment"
                    aria-expanded="true" aria-controls="collapsePayment">
                    Payment
                  </a>
                </h2>
              </div>

              <div id="collapsePayment" role="tabpanel" class="collapse show" aria-labelledby="headingPayment"
                data-bs-parent="#accordion-2">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><span class="col-form-label"
                        style="padding-top: 5px;">ชื่อบัญชี</span></label>
                    <div class="col-md-9">
                      <select name="accountCode" id="accountCode" class="select2_single form-control select2"
                        wire:model="data.accountCode" style="width: 100%">
                        <option value="">Select Account</option>
                        @foreach (Service::AccountSelecter() as $account)
                        <option value="{{ $account->accountCode }}">{{ $account->accountName }}</option>
                        @endforeach
                      </select>

                    </div>


                  </div>



                  <div class="form-group  row">
                    <label class="col-sm-3 col-form-label">โดย By</label>
                    <div class="col-md-9">
                      <div class="i-checks">
                        <input type="radio" id="chsh" value="c" name="payType" wire:model="data.payType">
                        <label for="chsh">เงินสด Cash </label>
                        <input type="radio" id="bank" value="b" name="payType" wire:model="data.payType">
                        <label for="bank">เช็คธนาคาร สาขา </label>

                      </div>
                      <div class="i-checks">
                        <input type="radio" id="other" value="o" name="payType" wire:model="data.payType">
                        <label for="other">อื่นๆ Other </label>
                        @if ($data->payType == 'o')
                        <input type="text" name="payTypeOther" id="payTypeOther" class="form-control col-sm-6"
                          wire:model="data.payTypeOther">
                        @endif
                      </div>

                    </div>
                  </div>


                  <div class="form-group  row">
                    <label class="col-sm-3 col-form-label">ธนาคาร สาขา</label>
                    <div class="col-md-3">
                      <input type="text" name="branch" id="branch" class="form-control" wire:model="data.branch">
                    </div>
                    <label class="col-sm-2 col-form-label">เลขที่เช็ค</label>
                    <div class="col-md-3">
                      <input type="text" name="chequeNo" id="chequeNo" class="form-control" Wire:model="data.chequeNo">
                    </div>
                  </div>




                  <div class="form-group  row">


                    <div class="col-md-3">
                      <label class="col-form-label" style="padding-top: 5px;"> Date</label>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group date"> <span class="input-group-addon"><i
                            class="fa fa-calendar"></i></span>
                        <input type="text" name="dueDate" class="form-control" wire:model="data.dueDate">
                      </div>
                    </div>

                    <div class="col-md-2">
                      <label class="col-form-label" style="padding-top: 5px;"> ยอดรวม</label>
                    </div>
                    <div class="col-md-3">
                      <input type="text" name="dueTime" class="form-control" wire:model="data.dueTime">
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
              <div class="card-header" id="headingInvoice">
                <h2 class="mb-0">
                  <a role="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseInvoice"
                    aria-expanded="true" aria-controls="collapseInvoice">
                    Invoice Ref.
                  </a>
                </h2>
              </div>

              <div id="collapseInvoice" role="tabpanel" class="collapse show" aria-labelledby="headingInvoice"
                data-bs-parent="#accordion-3">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-md-6">
                      <select class="select2_single form-control select2" style="width: 100%;" id="chargeCode"
                        wire:model.change="chargeCode">
                        <option value="">- select -</option>
                        @foreach (Service::ChargesSelecter() as $charge)
                        <option value="{{ $charge->chargeCode }}">
                          {{ $charge->chargeName }}
                        </option>
                        @endforeach

                      </select>
                    </div>
                    <div class="col-md-2" style="padding-left: 0px;">
                      <button class="btn btn-white " type="button" name="addPayment" wire:click="addPayment"
                        @disabled($chargeCode=='' ) id="addPayment"><i class="fa fa-plus"></i>
                        Add</button>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="table-responsive" id="containner_charge">
                      <table class="table" width="100%" id="table_charge">
                        <thead>
                          <tr>
                            <th style="width:10%">invNo.</th>
                            <th style="width:50%">Detail</th>
                            <th style="width:10%">Cost</th>
                            <th style="width:10%">Receive</th>
                            <th style="width:10%">Bill of receipt</th>
                            <!-- <th style="width:5%">Action</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($payments as $item)
                          <tr class='gradeX' wire:key="item-field-{{ $item->items }}">
                            <td>
                              <input type='text' readonly class='form-control'
                              wire:model.live.debounce.500ms="payments.{{ $loop->index }}.invNo"></td>
                            </td>
                            <td>
                              <input type='text' class='form-control'
                              wire:model.live.debounce.500ms="payments.{{ $loop->index }}.detail">
                            </td>
                            <td class='center'>
                              <input type='number'
                                class='form-control' wire:model.live.debounce.500ms.number="payments.{{ $loop->index }}.chargesCost">
                              </td>
                            <td class='center'>
                              <input type='number'
                                class='form-control' wire:model.live.debounce.500ms.number="payments.{{ $loop->index }}.chargesReceive">
                              </td>
                            <td class='center'>
                              <input type='number'
                                class='form-control' wire:model.live.debounce.500ms.number="payments.{{ $loop->index }}.chargesbillReceive">
                              </td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td style="width:5%"></td>
                            <td style="width:50%"></td>
                            <td style="width:10%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span id="total_cost">
                                {{$payments->sum('chargesCost')}}
                              </span></td>
                            <td style="width:5%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span id="total_receive">
                                {{$payments->sum('chargesReceive')}}
                              </span></td>
                            <td style="width:5%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span id="total_Bill_of_receipt">
                                {{$payments->sum('chargesbillReceive')}}
                              </span></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-6 col-form-label"> remark
                        <textarea rows="8" name="remark" class="form-control" wire:model="data.remark"></textarea>
                      </label>
                      <div class="col-lg-6">
                        <table class="table invoice-total">
                          <tbody>
                            <tr>
                              <td><strong>Vat 7% :</strong></td>
                              <td><span id="tax">
                                  {{$data->total_vat}}
                                </span></td>
                            </tr>
                            <tr>
                              <td><strong>TOTAL :</strong></td>
                              <td><span id="total">
                                  {{$data->total_amt}}
                                </span></td>
                            </tr>
                            <tr>
                              <td><strong>WH TAX 3% :</strong></td>
                              <td><span id="wh_tax3">
                                  {{$data->tax3}}
                                </span></td>
                            </tr>
                            <tr>
                              <td><strong>WH TAX 1% :</strong></td>
                              <td><span id="wh_tax1">
                                  {{$data->tax1}}
                                </span></td>
                            </tr>
                            <tr>
                              <td><strong>ลูกค้าสำรองจ่าย :</strong></td>
                              <td><input name="cus_paid" id="cus_paid" class="form-control" wire:model="data.cus_paid"
                                  @disabled(true)></td>
                            </tr>
                            <tr>
                              <td><strong>NET PAD:</strong></td>
                              <td><span id="net_pad">
                                  {{$data->total_netamt}}
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
                  <a name="back" class="btn btn-white" type="button" href="{{ route('tax-invoice') }}" wire.loading.attr="disabled">
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
                        <a class="btn" target="_blank" href="{{'/api/print/tax_invoice_pdf/'.$data->documentID}}"><i class="fa fa-print"></i>
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