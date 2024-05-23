<div>

    <livewire:component.page-heading title_main="Payment Voucher" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Account"
        breadcrumb_page="Payment Voucher" breadcrumb_page_title="Payment Voucher Form" />

    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper" wire:target='submit,approve'>
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="submit" onkeydown="return event.key != 'Enter';">
            <fieldset @disabled($formMode == FormMode::DISABLED || $formMode == FormMode::READONLY)>
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

                                            <input type="date" name="documentDate" class="form-control"
                                                wire:model="data.documentDate">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label"><span class="col-form-label"
                                                style="padding-top: 5px;">จ่ายให้/Paid
                                                To</span> <span class="text-danger">*</span></label>
                                        <div class="col-md-4">
                                            <livewire:element.select2 wire:model="data.supCode" name="supCode"
                                                :searchable="true" :options="Service::SupplierSelecter()"
                                                itemKey="supCode" itemValue="supNameEN" />
                                            @error('data.supCode')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Ref. JobNo.</label>
                                        </div>
                                        <div class="col-md-4">
                                            <livewire:element.select2 wire:model="data.refJobNo" name="refJobNo" :searchable="true"
                                                :options="Service::JobOrderSelecter(false)" itemKey="documentID" 
                                                itemValue="documentID"/>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Note</label>
                                        <div class="col-md-10">
                                            <textarea name="note" rows="4" class="form-control"></textarea>
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
                            <div class="card-header" id="headingPayment">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsePayment" aria-expanded="true"
                                        aria-controls="collapsePayment">
                                        Payment
                                    </a>
                                </h2>
                            </div>

                            <div id="collapsePayment" role="tabpanel" class="collapse show"
                                aria-labelledby="headingPayment" data-bs-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">
                                            <span class="col-form-label" style="padding-top: 5px;">ชื่อบัญชี</span> <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <select name="accountCode" id="accountCode"
                                                class="select2_single form-control select2" style="width: 100%"
                                                wire:model="data.accountCode">
                                                <option value="">- Select -</option>
                                                @foreach (Service::AccountSelecter() as $account)
                                                <option value="{{ $account->accountCode }}">
                                                    {{ $account->accountName }}
                                                @endforeach
                                            </select>
                                            @error('data.accountCode')
                                                <div class="text-danger m-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">โดย By <span class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <div class="i-checks">
                                                <input type="radio" id="chsh" value="c" name="payType"
                                                    wire:model="data.payType">
                                                <label for="chsh">เงินสด Cash </label>
                                                <input type="radio" id="bank" value="b" name="payType"
                                                    wire:model="data.payType">
                                                <label for="bank">เช็คธนาคาร Bank </label>

                                            </div>
                                            <div class="i-checks">
                                                <input type="radio" id="other" value="o" name="payType"
                                                    wire:model="data.payType">
                                                <label for="other">อื่นๆ Other </label>
                                                @if ($data->other == 'o')
                                                <input type="text" name="payTypeOther" id="payTypeOther"
                                                    class="form-control col-sm-6" wire:model="data.payTypeOther">
                                                @endif
                                            </div>
                                            @error('data.payType')
                                                <div class="text-danger m-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">สาขา Branch</label>
                                        <div class="col-md-10">
                                            <input type="text" name="branch" id="branch" class="form-control"
                                                wire:model="data.branch">
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">เลขที่เช็ค Cheque</label>
                                        <div class="col-md-4">
                                            <input type="text" name="chequeNo" id="chequeNo" class="form-control"
                                                wire:model="data.chequeNo">
                                        </div>


                                        <div class="col-md-2">
                                            <label class="col-form-label" style="padding-top: 5px;">Due Date <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" name="dueDate" class="form-control"
                                                wire:model="data.dueDate">
                                            @error('data.dueDate')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                            @enderror
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
                                            <livewire:element.select2 wire:model.live='chargeCode' id="chargeCode" :options="Service::ChargesSelecter()" itemKey="chargeCode" itemValue="chargeName" :searchable="true">
                                        </div>
                                        <div class="col-md-2" style="padding-left: 0px;">
                                            <button class="btn btn-primary " type="button" name="addPayment" @disabled($chargeCode=='')
                                                wire:click="addPayment" id="addPayment"><i
                                                 class="fa fa-plus"></i>
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="table-responsive" id="containner_charge">
                                            <table class="table" width="100%" id="table_charge">
                                                <thead>
                                                    <tr>
                                                        <th style="width:10%">เลขที่บิล No.</th>
                                                        <th style="width:35%">รายการ Particulars</th>
                                                        <th style="width:10%">จำนวนเงิน Amount</th>
                                                        <th style="width:5%; min-width: 80px;">Tax </th>
                                                        <th style="width:5%; min-width: 120px;">Tax รวม</th>
                                                        <th style="width:5%; min-width: 80px;">Vat</th>
                                                        <th style="width:5%; min-width: 120px;">Grand Total</th>
                                                        <th style="width:5%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payments as $item)
                                                    <tr class='gradeX' wire:key="item-field-{{ $item->autoid }}">
                                                        <td>
                                                            <input type='text' class='form-control'
                                                                wire:model.live.debounce.500ms="payments.{{ $loop->index }}.invNo">
                                                        </td>
                                                        <td>
                                                            <input type='text' class='form-control'
                                                                wire:model.live.debounce.500ms="payments.{{ $loop->index }}.chartDetail">
                                                        </td>
                                                        <td class='center'>
                                                            <input type='number' class='form-control'
                                                                wire:change="calPrice"
                                                                wire:model.live.debounce.500ms.number="payments.{{ $loop->index }}.amount">
                                                        </td>

                                                        <td class='center'>
                                                            <select class="form-control valid"
                                                                wire:model.change='payments.{{ $loop->index }}.tax'
                                                                wire:change='changeTax($event.target.value, {{$loop->index}})'>
                                                                <option value="0">0%</option>
                                                                <option value="1">1%</option>
                                                                <option value="3">3%</option>
                                                            </select>
                                                        </td>
                                                        <td class='center'>
                                                            <input type="text" class="form-control"
                                                                wire:model="payments.{{ $loop->index }}.taxamount"
                                                                readonly>
                                                        </td>
                                                        <td class='center'>
                                                            <select class="form-control valid"
                                                                wire:model.change='payments.{{ $loop->index }}.vat'
                                                                wire:change='changeVat($event.target.value, {{$loop->index}})'>
                                                                <option value="0">0%</option>
                                                                <option value="7">7%</option>
                                                            </select>
                                                        </td>
                                                        <td class='center'>
                                                            <input type="text" class="form-control"
                                                                wire:model="payments.{{ $loop->index }}.GrandTotal"
                                                                readonly>
                                                        </td>
                                                        <td class='center'>
                                                            <button type='button' class='btn-white btn btn-xs' wire:click='removePayment({{ $loop->index }})'>Remove</button>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                                <tfoot>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-7 col-form-label"> remark
                                                <textarea rows="3" name="remark" class="form-control"></textarea>
                                            </label>
                                            <div class="col-lg-5">
                                                <table class="table invoice-total">
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>TOTAL :</strong></td>
                                                            <td style="min-width: 150px; max-width: 200px;">
                                                                <input name="sumTotal" id="sumTotal"
                                                                    class='form-control'
                                                                    value="{{ Service::MoneyFormat($priceSum->total) }}"
                                                                    readonly>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Tax 1% :</strong></td>
                                                            <td><input type="number" name="tax1" id="tax1"
                                                                    class='form-control'
                                                                    wire:keyup.debounce.700ms='calTax1($event.target.value)'
                                                                    value="{{ Service::MoneyFormat($priceSum->tax1) }}"
                                                                    required @readonly(!Auth::user()->hasRole('admin'))>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Tax 3% :</strong></td>
                                                            <td><input type="number" name="tax3" id="tax3"
                                                                    class='form-control'
                                                                    wire:keyup.debounce.700ms='calTax3($event.target.value)'
                                                                    value="{{ Service::MoneyFormat($priceSum->tax3) }}"
                                                                    required @readonly(!Auth::user()->hasRole('admin'))>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Vat Total : </strong></td>
                                                            <td><input name="tax7" id="tax7" class='form-control'
                                                                    value="{{ Service::MoneyFormat($priceSum->vatTotal) }}"
                                                                    required readonly></td>
                                                        </tr>



                                                        <tr>
                                                            <td><strong>GRAND TOTAL:</strong></td>
                                                            <td style="text-align: left"><span id="showgrandTotal">{{
                                                                    Service::MoneyFormat($priceSum->grandTotal)
                                                                    }}</span>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>นำไปคิดภาษีซื้อ :</strong></td>
                                                            <td style="text-align: left"><label
                                                                    class="checkbox-inline i-checks">
                                                                    <input type="checkbox" name="purchasevat"
                                                                        id="purchasevat"
                                                                        wire:model.boolean='data.purchasevat'>
                                                                </label></td>
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

                {{-- Section 4 --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-4" class="default-according">
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
                                aria-labelledby="headingAttachment" data-bs-parent="#accordion-4" wire:ignore.self>
                                <div class="card-body">
                                    <div class="form-group">
                                        <table class="table" width="100%" name="table_attach" id="table_attach">
                                            <thead>
                                                <tr>
                                                    <th style="width:10%">document</th>
                                                    <th style="width:30%">Detail</th>
                                                    <th style="width:50%">File Name</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attachs as $attach)
                                                {{-- {{dd($attach);}} --}}
                                                <tr class='gradeX'>
                                                    <td>{{ $attach->documentID }}</td>
                                                    <td>
                                                        <input type='text' class='form-control'
                                                            wire:model.live.debounce.500ms='attachs.{{$loop->index}}.fileDetail'>
                                                    </td>
                                                    <td>
                                                        <input type='text' class='form-control'
                                                            wire:model.live.debounce.500ms='attachs.{{$loop->index}}.fileName'
                                                            @disabled($attach->items != null)>
                                                    </td>
                                                    <td class='center'>
                                                        {{-- <a class='btn-white btn btn-xs' href=''
                                                            target='_blank'>View</a> --}}
                                                        <a href='/api/blobfile/{{$attach->fileName}}'
                                                            target="_blank">View</a>
                                                        {{-- </button> --}}
                                                        &nbsp;
                                                        <button type='button' class='btn-white btn btn-xs'
                                                            wire:click='removeFile({{$loop->index}})'>Remove</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                        <div class="form-group row">
                                            <div id="container_attach" class="fileinput fileinput-new"
                                                data-provides="fileinput">
                                                <span class="btn btn-primary btn-file">
                                                    <span class="fileinput-new">Select file</span>
                                                    <input type="file" wire:model.change='file'>
                                                    @error('file')
                                                    <div class="text-danger m-2">{{ $message }}</div>
                                                    @enderror
                                                </span>
                                                <span class="fileinput-filename"></span>
                                                <button type="button" wire:click='removePreFile'
                                                    class="close fileinput-exists" data-dismiss="fileinput" style="float: none; border: none;
                                                background: transparent;" @disabled(!$file)>&times;</button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">Action</label>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary " type="button" wire:click="uploadFile"
                                                    @disabled(!$file)>
                                                    <i class="fa fa-save"></i> Upload File</button>
                                                @error('supCodeEmpty')
                                                <div class="text-danger m-2">{{ $message }}</div>
                                                @enderror
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
                                    <a name="back" class="btn btn-white" type="button"
                                        href="{{ route('account-payment-voucher') }}" wire.loading.attr="disabled">
                                        <i class="fa fa-reply"></i> Back</a>
                                    @if($data->documentstatus == 'P')
                                    <button name="Save" id="Save" class="btn btn-success" type="submit"><i
                                            class="fa fa-save"></i> Save</button>
                                    @endif
                                    <button name="Approve" id="Approve" class="btn btn-primary" type="button"
                                        wire:click='approve'><i class="fa fa-check"></i> Approve</button>
                                    @if($data->documentID!=null||$data->documentID!='')
                                    <a class="btn" target="_blank"
                                        href="/api/print/payment_voucher_pdf/{{$data->documentID}}"><i
                                            class="fa fa-print"></i> Print</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </fieldset>
        </form>
    </div>

</div>
@push('modal')
<livewire:modal.modal-alert />
@endpush

{{-- @script
<script>
    Livewire.hook('component.init', ({component, cleanup}) => {
        // $('#tax1').mask("#,##0.00" , {reverse: true});
        // $('#tax3').mask("#,##0.00" , {reverse: true});
    })
    Livewire.on('cal-update', function() {
            // const formatter = new Intl.NumberFormat('th-TH', {
            //     style: 'currency',
            //     currency: 'THB',
            //     currencyDisplay: "code",
            //     minimumFractionDigits: 2,
            //     });
            //     console.log($wire.priceSum);
            // if($('#tax1').val() == ''){
            //     $('#tax1').val(0.00);
            // }
            // if($('#tax3').val() == ''){
            //     $('#tax3').val(0.00);
            // }
            // $('#tax1').val($wire.priceSum.tax1);
            // $('#tax3').val($wire.priceSum.tax3);
        });
</script>
@endscript --}}