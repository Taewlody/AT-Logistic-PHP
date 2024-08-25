<div>
    <livewire:component.page-heading title_main="Payment Voucher" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Account"
        breadcrumb_page="Payment Voucher" />

    <div class="container-fluid">
        <form wire:submit="search">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 m-auto">
                                <h3>Search Condition</h3>
                                </div>

                                <div class="col-6 text-end">
                                    <a href="{{ route('account-payment-voucher.form', ['action' => 'create']) }}" class="btn btn-primary"><i class="fa fa-plus "> </i> Create new </a>
                                </div>
                            </div>
                            <br/><br/>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Document No.</label>
                                        <div>
                                            <input type='text' name="documentNo" class='form-control' id="documentNo" wire:model="documentNo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Job No.</label>
                                        <div>
                                            <input type='text' name="jobNo" class='form-control' id="jobNo" wire:model="jobNo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Supplier</label>
                                        <div>
                                            {{-- <select class="select2_single form-control select2"
                                            name="supplier" id="supplier" wire:model="supplierSearch">
                                                <option value="">- select -</option>
                                                @foreach ($supplierList as $supplier)
                                                    <option value="{{ $supplier->supCode }}">
                                                        {{ $supplier->supNameEN ? $supplier->supNameEN : $supplier->supNameTH }}</option>
                                                @endforeach
                                            </select> --}}
                                            <livewire:element.select2 wire:model="supplierSearch" name="supplierSearch" :searchable="true"
                                                :options="Service::SupplierSelecter()" itemKey="supCode" 
                                                itemValue="supNameEN"/>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0" id="dateStart">
                                        <label class="font-normal">Date Range</label>
                                        <div class="input-group date"> 
                                            <input class="form-control digits" name="dateStart" wire:model="dateStart" autocomplete="off" type="date" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group" id="dateEnd">
                                        <label class="font-normal">To</label>
                                        <div class="input-group date"> 
                                            <input class="form-control digits" name="dateEnd" wire:model="dateEnd" autocomplete="off" type="date" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Status</label>
                                        <div>
                                            <select class="select2_single form-control select2" name="documentstatus" id="documentstatus" wire:model="documentstatus">
                                                <option value="">- select -</option>
                                                <option value="P">Pending</option>
                                                <option value="A">Approve</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="ibox-content table-responsive">
            
                                <div wire:loading class="loader-wrapper">
                                    <div class="loader"></div>
                                </div>
            
                                <div class="ibox-content">
                                    <table wire:loading.remove class="footable table table-stripped toggle-arrow-tiny"
                                        data-page-size="{{ $data->total() }}" data-filter=#filter>
                                        <thead>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th data-toggle="true" width="15%">Document  No.</th>
                                                <th data-hide="phone" width="15%">Document Date</th>
                                                <th data-toggle="true" width="10%">RefJob</th>
                                                <th data-toggle="true" width="35%">Supplier</th>
                                                <th data-hide="phone,tablet" width="10%">Amount</th>
                                                <th  width="5%">Status</th>
                                                <th data-hide="phone,tablet"  data-sort-ignore="true" width="15%">Action</th>                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if( count($data) > 0 )
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->documentID }}</td>
                                                    <td>{{ $item->documentDate == null ? "" : Service::DateFormat($item->documentDate, true) }}</td>
                                                    <td>{{ $item->refJobNo }}</td>
                                                    <td>{{ $item->supplier != null ? $item->supplier->supNameEN ? $item->supplier->supNameEN : $item->supplier->supNameTH : '' }}</td>
                                                    <td>{{ number_format($item->grandTotal, 2) }}</td>
                                                    @if ($item->docStatus != null)
                                                        <td class="center"><span
                                                                @class([
                                                                    'badge',
                                                                    'label-primary' => $item->docStatus->status_code == 'A',
                                                                    'label-danger' => $item->docStatus->status_code == 'D',
                                                                    'label-warning' => $item->docStatus->status_code == 'P',
                                                                ])>{{ $item->docStatus->status_name }}</span>
                                                        </td>
                                                    @else
                                                        <td class="center"><span
                                                                @class([
                                                                    'label' 
                                                                ])>Disabled</span>
                                                        </td>
                                                    @endif
            
                                                    {{-- <td class="center">{{ $item->editBy != null ? $item->editBy->username : '' }} --}}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-xs btn-success"
                                                                href="{{ route('account-payment-voucher.form', ['action' => 'view', 'id' => $item->documentID]) }}">View</a>
                                                            <a class="btn btn-xs btn-primary"
                                                                href="{{ route('account-payment-voucher.form', ['action' => 'edit', 'id' => $item->documentID]) }}">Edit</a>
                                                            <button class="btn btn-xs btn-danger"
                                                            wire:confirm="Are you sure want to delete {{$item->documentID}}" wire:click="delete('{{$item->documentID}}')" wire:refresh="$refresh">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="8" class="text-center">Data Not Found</td>
                                            </tr>
                                            @endif
                                    </table>
                                    <br/>
                                    <div class="row">
                                        <div class="col-4">
                                            {{ $data->withQueryString()->links('layouts.themes.layout.custom-pagination-info') }}
                                        </div>
                                        <div class="col-8"> 
                                            {{ $data->withQueryString()->links('layouts.themes.layout.custom-pagination-links') }}
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
