<div>

    <livewire:component.page-heading title_main="Petty Cash" title_sub="เงินสดย่อย" breadcrumb_title="Shipping"
        breadcrumb_page="Petty Cash" breadcrumb_page_title="Petty Cash Form" />

    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper" wire:target='save,approve'>
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">
            <div class="row">

                {{-- Section 1 --}}
                <div class="col-lg-12 mb-2">
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
                                        <label class="col-sm-1 col-form-label">Document No.</label>
                                        <div class="col-md-4">
                                            <input type="text" name="documentID" id="documentID" class="form-control"
                                                wire:model="data.documentID" readonly>
                                        </div>
                                        <label class="col-sm-1 col-form-label">Document Date</label>
                                        <div class="col-md-2">
                                            <div class="input-group date"> <span class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span>
                                                <input type="date" name="documentDate" class="form-control"
                                                    wire:model="data.documentDate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group  row">
                                        <label class="col-sm-1 col-form-label">จ่ายให้/Paid To</label>
                                        <div class="col-md-4">
                                            <select name="supCode" class="select2_single form-control select2"
                                                id="supCode" wire:model="data.supCode">
                                                <option value="">-- Select --</option>
                                                @foreach (Service::SupplierSelecter() as $supplier)
                                                    <option value="{{ $supplier->supCode }}">{{ $supplier->supNameTH }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-1 col-form-label">Ref. JobNo.</label>
                                        <div class="col-md-2">
                                            <select class="select2_single form-control select2" name="refJobNo"
                                                id="refJobNo" wire:model="data.refJobNo">
                                                <option value="">-- Select --</option>
                                                @foreach (Service::JobOrderSelecter() as $job)
                                                    <option value="{{ $job->documentID }}">{{ $job->documentID }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group  row">
                                        <label class="col-sm-1 col-form-label">Address</label>
                                        <div class="col-md-4">
                                            <input type="text" name="cusCode" class="form-control">
                                        </div>

                                        <label class="col-sm-1 col-form-label">วันชำระ</label>
                                        <div class="col-md-2">
                                            <div class="input-group date"> <span class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span>
                                                <input type="date" name="dueDate" class="form-control">
                                                    {{-- wire:model="data.dueDate"> --}}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2 --}}
                <div class="col-lg-12 mb-2">
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
                                        <div class="col-md-6">
                                            <select class="select2_single form-control select2" style="width: 100%;"
                                                id="chargeCode" wire:model="chargeCode">
                                                <option value="">-- Select --</option>
                                                @foreach (Service::ChargesSelecter() as $charge)
                                                    <option value="{{ $charge->chargeCode }}">{{ $charge->chargeName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="padding-left: 0px;">
                                            <button class="btn btn-white " type="button" wire:click='addPayment'><i class="fa fa-plus"></i> Add</button>
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
                                                        <th style="width:5%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payments as $item)
                                                    <tr class='gradeX'
                                                            wire:key="item-field-{{ $item->autoid }}">

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
                                                                    wire:model.live.debounce.500ms.number="payments.{{ $loop->index }}.amount">
                                                            </td>
                                                            <td class='center'>
                                                                <button type='button'
                                                                    class='btn-white btn btn-xs' wire:click='removePayment({{$loop->index}})'>Remove</button>
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
                                                            <td><strong>TOTAL :</strong></td>
                                                            <td>
                                                                <input name="sumTotal" id="sumTotal"
                                                                    class='form-control' value="{{ Service::MoneyFormat($this->calPrice()->total) }}"
                                                                    required readonly>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Tax 1% :</strong></td>
                                                            <td><input name="tax1" id="tax1"
                                                                     class='form-control' value="{{ Service::MoneyFormat($this->calPrice()->tax1) }}"
                                                                    required readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Tax 3% :</strong></td>
                                                            <td><input name="tax3" id="tax3" class='form-control' value="{{  Service::MoneyFormat($this->calPrice()->tax3) }}"
                                                                    required></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Vat7% :</strong></td>
                                                            <td><input name="tax7" id="tax7" class='form-control' value="{{  Service::MoneyFormat($this->calPrice()->tax7) }}"
                                                                    required></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>GRAND TOTAL:</strong></td>
                                                            <td style="text-align: left"><span
                                                                    id="showgrandTotal">{{ Service::MoneyFormat($this->calPrice()->grandTotal)}}</span>
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
                                    <button name="back" class="btn btn-secondary" type="button"
                                        wire:click.prevent='{{ url()->previous() }}'><i class="fa fa-reply"></i> Back</button>

                                    <button name="Approve" id="Approve" class="btn btn-success" type="button" wire:click='save'><i
                                            class="fa fa-save"></i> Approve</button>
                                    <button class="btn btn-primary " type="button" onclick=""><i
                                            class="fa fa-print"></i> Job</button>
                                    <button class="btn btn-primary " type="button" onclick=""><i
                                            class="fa fa-print"></i> Booking confirm</button>
                                    <button class="btn btn-primary " type="button" onclick=""><i
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
