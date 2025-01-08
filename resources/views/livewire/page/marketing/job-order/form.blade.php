<div>
    <livewire:component.page-heading title_main="Job Orders" title_sub="ใบสั่งงาน" breadcrumb_title="Marketing"
        breadcrumb_page="Job Orders" breadcrumb_page_title="Job Orders Form" />

    {{-- loading --}}
    <div wire:loading.flex class="loader-wrapper" wire:target="submit,approve">
        <div class="loader"></div>
    </div>

    <form class="form-body" wire:submit="submit" onkeydown="return event.key != 'Enter';">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">

                {{-- Header file --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col file-box">
                                    <div class="file">
                                        {{-- <a id="invoice" target="blank"
                                            href="{{route('invoice.form',$invoice != null ? array('action' => 'edit', 'id' => $invoice->documentID) : array('action'=>'create', 'ref' => ($job->documentID !=null ? $job->documentID : '')))}}" @disabled($action=="create" )> --}}
                                        @if($invoice != null)
                                        <a target="_blank"
                                            href="{{'/api/print/invoice_pdf/'.$invoice->documentID}}">
                                            <div class="icon">
                                                <i class="fa fa-file-text"></i>
                                            </div>
                                            <div class="file-name text">
                                                Invoice <span id="invoiceNoText">{{$invoice != null?
                                                    $invoice->documentID : '' }}</span>
                                            </div>
                                        </a>
                                        @else
                                        <div class="icon">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                        <div class="file-name text">
                                            Invoice</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col file-box">
                                    <div class="file">
                                        <a id="btnbill_of_lading" target="blank"
                                            href="{{route('bill-of-lading.form', $billOfLanding != null ? array('action' => 'edit', 'id' => $billOfLanding->documentID) : array('action'=>'create', 'ref' => ($job->documentID !=null ? $job->documentID : '')))}}"
                                            @disabled($action=="create" )>
                                            <div class="icon">
                                                <i class="fa fa-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                Bill of landing <span id="invoiceNoText">{{$billOfLanding != null?
                                                    $billOfLanding->documentID : '' }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col file-box">
                                    <div class="file">
                                        <a id="trailer_booking" target="blank"
                                            href="{{route('trailer-booking.form', $trailerBooking != null ? array('action' => 'edit', 'id' => $trailerBooking->documentID) : array('action'=>'create', 'ref' => ($job->documentID !=null ? $job->documentID : '')))}}"
                                            @disabled($action=="create" )>
                                            <div class="icon">
                                                <i class="fa fa-file-text"></i>
                                            </div>
                                            <div class="file-name text-navy">
                                                Trailer Booking <span id="invoiceNoText">{{$trailerBooking != null?
                                                    $trailerBooking->documentID : '' }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Section 1_1 Document --}}
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
                                aria-labelledby="headingDocument" data-bs-parent="#accordion-1" >
                                <div class="card-body">
                                    <livewire:page.marketing.job-order.element.document wire:key='job-document'
                                        wire:model="job" :$action />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 1_2 Sale --}}
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
                            <div id="collapseSale" role="tabpanel" class="collapse show" aria-labelledby="headingSale"
                                data-bs-parent="#accordion-2">
                                <div class="card-body">
                                    <livewire:page.marketing.job-order.element.detail wire:model="job" 
                                        :$action />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 3 Location --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-3" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingLocation">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseLocation" aria-expanded="false"
                                        aria-controls="collapseLocation">
                                        Location
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseLocation" role="tabpanel" class="collapse"
                                aria-labelledby="headingLocation" data-bs-parent="#accordion-3" wire:ignore.self>
                                <div class="card-body">
                                    <livewire:page.marketing.job-order.element.location wire:model.live="job"
                                        :$action />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 4 Containers --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-4" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingContainers">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseContainers" aria-expanded="false"
                                        aria-controls="collapseContainers">
                                        Containers
                                    </a>
                                </h2>
                                @error('containerList')
                                    <h4 class="text-danger" style="padding-left: 20px">{{ $message }}</h4>
                                @enderror
                            </div>
                            <div id="collapseContainers" role="tabpanel" class="collapse"
                                aria-labelledby="headingContainers" data-bs-parent="#accordion-4" wire:ignore.self>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-1">
                                            <label class="col-form-label" style="padding-top: 5px;">Type</label>
                                        </div>
                                        <div class="col-md-2">
                                            <livewire:element.select2 wire:model.change="typeContainer" name="typeContainer"
                                                :options="Service::ContainerTypeSelecter()" itemKey="containertypeCode" 
                                                itemValue="containertypeName"/>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="col-form-label" style="padding-top: 5px;">Size</label>
                                        </div>
                                        <div class="col-md-2">
                                            <livewire:element.select2 wire:model.change="sizeContainer" name="sizeContainer"
                                                :options="Service::ContainerSizeSelecter()" itemKey="containersizeCode"
                                                itemValue="containersizeName"/>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="col-form-label" style="padding-top: 5px;">จำนวน</label>

                                        </div>
                                        <div class="col-md-2">
                                            <input name="containQty" type="number" class="form-control" id="containQty" min="0"
                                                wire:model.live.number="quantityContainer">

                                        </div>
                                        <div class="col" style="display: flex; align-items: flex-end;">
                                            <button class="btn btn-primary" type="button" wire:click="addContainer" @disabled($typeContainer == '' || $sizeContainer == '' || $quantityContainer < 1)>
                                                <i class="fa fa-plus"></i>Add
                                            </button>
                                        </div>
                                        @error('typeContainer') <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('sizeContainer') <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('quantityContainer')
                                        <div class="text-danger m-2">{{ $message }}</div>
                                        @enderror
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
                                                        @foreach ($containerList as $container)
                                                        <tr id="tr{{ $loop->iteration }}" wire:key="container-{{$loop->index}}">
                                                            <td>
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>
                                                                <select :key="$loop->index" class="form-control"
                                                                    wire:model.lazy="containerList.{{ $loop->index }}.containerType">
                                                                    <option value="">Select</option>
                                                                    @foreach (Service::ContainerTypeSelecter() as $type)
                                                                    <option value="{{ $type->containertypeCode }}">
                                                                        {{ $type->containertypeName }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select :key="$loop->index" class="form-control" 
                                                                    wire:model.lazy="containerList.{{ $loop->index }}.containerSize">
                                                                    <option value="">Select</option>
                                                                    @foreach (Service::ContainerSizeSelecter() as $size)
                                                                    <option value="{{ $size->containersizeCode }}">
                                                                        {{ $size->containersizeName }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" :key="$loop->index"
                                                                    wire:model.lazy.debounce.700ms="containerList.{{ $loop->index }}.containerNo">
                                                            </td>
                                                            <td class="center">
                                                                <input type="text" class="form-control" :key="$loop->index"
                                                                    wire:model.lazy.debounce.700ms="containerList.{{ $loop->index }}.containerSealNo">
                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control" :key="$loop->index"
                                                                    wire:model.number.lazy.debounce.700ms="containerList.{{ $loop->index }}.containerGW">
                                                            </td>
                                                            <td class="center">
                                                                <select :key="$loop->index" class="form-control" wire:model.lazy="containerList.{{ $loop->index }}.containerGW_unit">
                                                                    <option value="">Select</option>
                                                                    @foreach (Service::UnitContainerSelecter() as $unit)
                                                                    <option value="{{ $unit->unitCode }}">
                                                                        {{ $unit->unitName }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="center">
                                                                <input type="text" class="form-control" :key="$loop->index"
                                                                    wire:model.lazy.debounce.700ms="containerList.{{ $loop->index }}.containerNW">
                                                            </td>
                                                            <td class="center">
                                                                <select :key="$loop->index" class="form-control" wire:model.lazy="containerList.{{ $loop->index }}.containerNW_Unit">
                                                                    <option value="">Select</option>
                                                                    @foreach (Service::UnitContainerSelecter() as $unit)
                                                                    <option value="{{ $unit->unitCode }}">
                                                                        {{ $unit->unitName }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </td>
                                                            <td class="center">
                                                                <input type="number" class="form-control"
                                                                :key="$loop->index"
                                                                    wire:model.number.lazy.debounce.700ms="containerList.{{ $loop->index }}.containerTareweight">
                                                            </td>
                                                            <td class="center">
                                                                <button type="button" class="btn-danger btn btn-xs"
                                                                    wire:click="removeContainer('{{ $loop->index }}')">Remove</button>
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
                </div>

                {{-- Section 5 Packaged Size --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-5" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingPackaged">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsePackaged" aria-expanded="false"
                                        aria-controls="collapsePackaged">
                                        Packaged Size
                                    </a>
                                    @error('packagedList')
                                        <h4 class="text-danger" style="padding-left: 20px">{{ $message }}</h4>
                                    @enderror
                                </h2>
                            </div>
                            <div id="collapsePackaged" role="tabpanel" class="collapse"
                                aria-labelledby="headingPackaged" data-bs-parent="#accordion-5" wire:ignore.self>
                                <div class="card-body">
                                    <livewire:page.marketing.job-order.element.packaged-size 
                                        wire:model.live="packagedList" :$action />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 6 Goods --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-6" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingGoods">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseGoods" aria-expanded="false"
                                        aria-controls="collapseGoods">
                                        Goods / สินค้า
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseGoods" role="tabpanel" class="collapse" aria-labelledby="headingGoods"
                                data-bs-parent="#accordion-6" wire:ignore.self>
                                <div class="card-body">
                                    <livewire:page.marketing.job-order.element.goods 
                                        wire:model="goodsList" :$action />
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Total Number of Package (in
                                            words)</label>
                                        <div class="col-md-4">
                                            <input type="text" name="good_total_num_package" class="form-control"
                                                wire:model.live.debounce.500ms="job.good_total_num_package">
                                        </div>
                                        <div class="col-md-1">
                                            <label style="padding-top: 5px;">Commodity</label>
                                        </div>
                                        <div class="col-md-4">
                                            <livewire:element.select2 wire:model.live='listCommodity'
                                                name="listCommodity" :options="Service::CommoditySelecter()"
                                                itemKey="commodityCode" itemValue="commodityNameEN" :multiple="true"
                                                :searchable="true" :disabled="$action != 'create' && $action != 'edit'">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 7 Charges --}}
                <div class="col-lg-12">
                    {{-- <div id="accordion-7" class="default-according"> --}}
                        <div class="card">
                            <div class="card-header" id="headingCharges">
                                <h3 class="mb-0">
                                    {{-- <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseCharges" aria-expanded="false"
                                        aria-controls="collapseCharges"> --}}
                                        Charges / ค่าใช้จ่าย
                                    {{-- </a> --}}
                                </h3>
                            </div>
                            {{-- <div id="collapseCharges" role="tabpanel" class="collapse" aria-labelledby="headingCharges"
                                data-bs-parent="#accordion-7" wire:ignore.self> --}}
                                <div class="card-body">
                                    <div class="form-group  row">
                                        <div class="col-md-6">
                                            <livewire:element.select2 wire:model.live="chargeCode" name="chargeCode"
                                                :options="Service::ChargesSelecter()" itemKey="chargeCode"
                                                itemValue="chargeName" :searchable="true"
                                                :disabled="$action != 'create' && $action != 'edit'">
                                        </div>
                                        <div class="col-md-2" style="padding-left: 0px;">
                                            <button class="btn btn-primary " type="button" 
                                                wire:click="addCharge" @disabled($chargeCode=='' )><i
                                                    class="fa fa-plus"></i>
                                                Add</button>
                                        </div>
                                    </div>
                                    <livewire:page.marketing.job-order.element.charges 
                                        wire:model.live="chargeList" :$action
                                        :groupTypeContainer="$this->groupedContainer"
                                        :groupTypePackage="$this->packagedList->sum('packaed_totalCBM')"
                                        :deliveryType="$job->deliveryType"
                                        :commissionSale="$job->commission_sale" :commissionCustomers="$job->commission_customers"
                                        :documentID="$job->documentID" />
                                </div>
                            {{-- </div> --}}
                        </div>
                    {{-- </div> --}}
                </div>

                {{-- Section 8 Advance Payment --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-8" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingCustomerPayment">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseCustomerPayment" aria-expanded="false"
                                        aria-controls="collapseCustomerPayment">
                                        ลูกค้าสำรองจ่าย
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseCustomerPayment" role="tabpanel" class="collapse"
                                aria-labelledby="headingCustomerPayment" data-bs-parent="#accordion-8" wire:ignore.self>
                                <div class="card-body">
                                    <div class="form-group">
                                        <table class="table" width="100%" name="table_cash" id="table_cash">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">No.</th>
                                                    <th style="width:10%">documentID</th>
                                                    <th style="width:40%">detail</th>
                                                    <th style="width:20%">Amount</th>
                                                    <th style="width:10%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($advancePayment as $piad)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td><a href="{{ route('advance-payment.form', ['action' => 'edit', 'id' => $piad->documentID]) }}"
                                                            target="_blank">{{$piad->documentID}}</a></td>
                                                    <td>{{$piad->note == '' ? 'ลูกค้าสำรองจ่าย' : $piad->note}}</td>
                                                    <td>{{Service::MoneyFormat($piad->sumTotal)}}</td>
                                                    @if ($piad->docStatus != null)
                                                    <td class="center">
                                                        <span @class([ 'badge' , 'label-primary'=>
                                                            $piad->docStatus->status_code == 'A',
                                                            'label-danger' => $piad->docStatus->status_code == 'D',
                                                            'label-warning' => $piad->docStatus->status_code == 'P',
                                                            ])>{{ $piad->docStatus->status_name }}</span>
                                                    </td>
                                                    @else
                                                    <td class="center"><span @class([ 'label' ])>Disabled</span>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
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

                {{-- Section 9 Attach File --}}
                <div class="col-lg-12 mb-2">
                    <div id="accordion-9" class="default-according">
                        <div class="card">
                            <div class="card-header" id="headingAttachment">
                                <h2 class="mb-0">
                                    <a role="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseAttachment" aria-expanded="false"
                                        aria-controls="collapseAttachment">
                                        Attach File / ไฟล์แนบ
                                    </a>
                                </h2>
                            </div>
                            <div id="collapseAttachment" role="tabpanel" class="collapse"
                                aria-labelledby="headingAttachment" data-bs-parent="#accordion-9" wire:ignore.self>
                                <div class="card-body">
                                    <div class="form-group">
                                        <table class="table" width="100%" name="table_attach" id="table_attach">
                                            <thead>
                                                <tr>
                                                    <th style="width:10%">No.</th>
                                                    <th style="width:30%">File Detail</th>
                                                    <th style="width:50%">File Name</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attachsPaymentVoucher as $attachVoucher)
                                                {{-- {{dd($attachVoucher)}} --}}
                                                <tr class='gradeX' wire:key='attach-field-{{ $attachVoucher->items }}'>
                                                    <td>{{ $attachVoucher->documentID }}</td>
                                                    <td>
                                                        <input type='text' class='form-control'
                                                            value="{{$attachVoucher->filedetail}}" disabled>
                                                    </td>
                                                    <td>
                                                        <input type='text' class='form-control'
                                                            value="{{$attachVoucher->fileName}}"
                                                            disabled>
                                                    </td>
                                                    <td class='center'>
                                                        <a href='/api/blobfile/{{$attachVoucher->fileName}}'
                                                            target="_blank">View</a>
                                                        &nbsp;
                                                        {{-- <button type='button' class='btn-white btn btn-xs'
                                                            wire:click='removeFile({{$loop->index}})'>Remove</button> --}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach ($attachsAdvancePayment as $attachAdvance)
                                                <tr class='gradeX' wire:key='attach-field-{{ $attachAdvance->items }}'>
                                                    <td>{{ $attachAdvance->documentID }}</td>
                                                    <td>
                                                        <input type='text' class='form-control'
                                                            value="{{$attachAdvance->filedetail}}" disabled>
                                                    </td>
                                                    <td>
                                                        <input type='text' class='form-control'
                                                            value="{{$attachAdvance->fileName}}"
                                                            disabled>
                                                    </td>
                                                    <td class='center'>
                                                        <a href='/api/blobfile/{{$attachAdvance->fileName}}'
                                                            target="_blank">View</a>
                                                        &nbsp;
                                                        {{-- <button type='button' class='btn-white btn btn-xs'
                                                            wire:click='removeFile({{$loop->index}})'>Remove</button> --}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach ($attachs as $attach)
                                                <tr class='gradeX' wire:key='attach-field-{{ $attach->items }}'>
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
                                                        <a href='/api/blobfile/{{$attach->fileName}}'
                                                            target="_blank">View</a>
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
                                                    <input type="file" wire:model.change="file">
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
                                                @error('cusCodeEmpty')
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
                                    <label>{{ $createBy->username ?? '' }}
                                        {{-- {{ $job->createTime ?? '' }} --}}
                                        {{($job->createTime && $job->createTime !== '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($job->createTime)->addHours(7)->format('Y-m-d H:i:s') : ' '}}</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Update By</label>
                                <div class="col-sm-10">
                                    <label>
                                        {{ $editBy->username ?? '' }} 
                                        {{-- {{ $job->editTime ?? '' }} --}}
                                        {{ ($job->editTime && $job->editTime !== '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($job->editTime)->addHours(7)->format('Y-m-d H:i:s') : ' '}}
                                    </label>
                                </div>
                            </div>
                            @endif
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <a name="back" class="btn btn-white" type="button" href="{{ route('job-order') }}"
                                        wire.loading.attr="disabled">
                                        <i class="fa fa-reply"></i> Back</a>
                                    @if($job->documentstatus != 'A')
                                    <button name="Approve" id="Approve" class="btn btn-success" type="submit"><i
                                            class="fa fa-save"></i> Save</button>
                                    @endif
                                    @if($action != 'create' && $job->documentstatus != 'A' && Auth::user()->hasRole('admin'))
                                    <button name="Approve" id="Approve" class="btn btn-success" wire:click="approve"
                                        type="button"><i class="fa fa-check"></i> Approve</button>
                                    @endif

                                    @if($action != 'create' && $job->documentstatus == 'A')
                                    <button name="Update" id="Update" class="btn btn-secondary" wire:click="update"
                                        type="button"><i class="fa fa-check"></i> Update</button>
                                    @endif
                                    

                                    @if($job->documentID != null ||$job->documentID != '')
                                    <a class="btn btn-primary " target="_blank"
                                        href="{{'/api/print/job_order_pdf/'.$job->documentID}}"><i
                                            class="fa fa-print"></i> Job</a>
                                    @endif
                                    @if($job->documentID != null ||$job->documentID != '')
                                    <a class="btn btn-primary " target="_blank"
                                        href="{{'/api/print/booking_job_pdf/'.$job->documentID}}"><i
                                            class="fa fa-print"></i> Booking confirm</a>
                                    @endif
                                    @if($trailerBooking != null)
                                    <a class="btn btn-primary " target="_blank"
                                        href="{{'/api/print/trailer_booking_pdf/'.$trailerBooking->documentID}}"><i
                                            class="fa fa-print"></i> Trailer booking</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- Alert Modal --}}
    
</div>

@push('modal')
<livewire:modal.modal-alert /> 
<livewire:modal.job-order.charges-alert />
@endpush

