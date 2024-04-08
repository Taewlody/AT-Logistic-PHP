<div>
    <livewire:component.page-heading title_main="Report" title_sub="ยอดขายตามใบแจ้งหนี้" breadcrumb_title="Report"
        breadcrumb_page="ยอดขายตามใบแจ้งหนี้" />

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
                                   
                                </div>
                            </div>
                            <br/><br/>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Date Range</label>
                                        <div>
                                            <div class="input-group date"> 
                                                <input class="form-control digits" name="dateStart" wire:model="dateStart" autocomplete="off" type="date" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">To</label>
                                        <div>
                                            <div class="input-group date"> 
                                                <input class="form-control digits" name="dateEnd" wire:model="dateEnd" autocomplete="off" type="date" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Document No.</label>
                                        <div>
                                            <input type='text' name='documentID' class='form-control' id="documentID" wire:model="documentID">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Customer</label>
                                        <div>
                                            <select class="select2_single form-control select2"
                                                name="cusCode" id="cusCode" wire:model="customerSearch">
                                                <option value="">- select -</option>
                                                @foreach ($customerList as $customer)
                                                    <option value="{{ $customer->cusCode }}">
                                                        {{ $customer->custNameEN ? $customer->custNameEN : $customer->custNameTH }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Sale</label>
                                        <div>
                                            <select class="select2_single form-control select2"
                                                    name="saleman" id="saleman" wire:model="salemanSearch">
                                                    <option value="">- select -</option>
                                                    @foreach ($salemanList as $saleman)
                                                        <option value="{{ $saleman->usercode }}">
                                                            {{ $saleman->empName }}</option>
                                                    @endforeach
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
    
                                <table class="footable table table-stripped toggle-arrow-tiny"
                                    data-filter=#filter>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Document No.</th>
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>Amount</th>
                                            <th>Vat</th>
                                            <th>3%</th>
                                            <th>1%</th>
                                            <th>Reserve</th>
                                            <th>Total Net</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($data) > 0)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->documentID }}</td>
                                                <td>{{ Service::DateFormat($item->documentDate, true) }}</td>
                                                <td>{{ $item->customer != null ? $item->customer->custNameEN ? $item->customer->custNameEN : $item->customer->custNameTH : '' }}</td>
                                                <td>{{ number_format($item->total_amt, 2) }}</td>
                                                <td>{{ number_format($item->total_vat, 2) }}</td>
                                                <td>{{ number_format($item->tax3, 2) }}</td>
                                                <td>{{ number_format($item->tax1, 2) }}</td>
                                                <td>{{ number_format($item->cus_paid, 2) }}</td>
                                                <td>{{ number_format($item->total_netamt, 2) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-xs btn-success"
                                                            href="{{ route('invoice.form', ['action' => 'view', 'id' => $item->documentID]) }}" wire:navigate>View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="11" class="text-center">Data Not Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ number_format($this->getTotalAmount, 2)}}</th>
                                        <th>{{ number_format($this->getTotalVat, 2)}}</th>
                                        <th>{{ number_format($this->getTotalTax3, 2) }}</th>
                                        <th>{{ number_format($this->getTotalTax1, 2) }}</th>
                                        <th>{{ number_format($this->getTotalReserve, 2) }}</th>
                                        <th>{{ number_format($this->getTotalNet, 2) }}</th>
                                        <th></th>
                                    </tfoot>
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

        </form>
    </div>
</div>
