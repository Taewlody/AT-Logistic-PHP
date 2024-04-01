<div>
    <livewire:component.page-heading title_main="Report" title_sub="กำไร-ขาดทุนตาม Job" breadcrumb_title="Report"
        breadcrumb_page="กำไร-ขาดทุนตาม Job" />

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
                                        <label class="font-normal">Job No.</label>
                                        <div>
                                            <input type='text' name='documentID' class='form-control' id="documentID" wire:model="documentID">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Customer</label>
                                        <div>
                                            <select class="select2_single form-control select2"
                                                name="cusCode" id="cusCode" wire:model="customerSearch">
                                                <option value="">- select -</option>
                                                @foreach ($customerList as $customer)
                                                    <option value="{{ $customer->cusCode }}">
                                                        {{ $customer->custNameTH }}</option>
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
                                                        <option value="{{ $saleman->empName }}">
                                                            {{ $saleman->empName }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Month</label>
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
                                    data-page-size="{{ $data->total() }}" data-filter=#filter>
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th width="10%">Document No.</th>
                                            <th width="10%">Date</th>
                                            <th width="30%">Cutomer</th>
                                            <th width="10%">รายได้</th>
                                            <th width="10%">ค่าใช้จ่าย</th>
                                            <th width="15%">กำไร/ขาดทุน1</th>
                                            <th width="15%">กำไร/ขาดทุน2</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($data) > 0)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->documentID }}</td>
                                                <td>{{ $item->documentDate }}</td>
                                                <td>{{ $item->custNameEN }}</td>
                                                <td>{{ number_format($item->total_amt, 2) }}</td>
                                                <td>{{ number_format($item->cost, 2) }}</td>
                                                <td>{{ number_format($item->profit, 2) }}</td>
                                                <td>{{ number_format($item->netprofit, 2) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-xs btn-success"
                                                            href="{{ route('job-order.form', ['action' => 'view', 'id' => $item->documentID]) }}" wire:navigate>View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="text-center">Data Not Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ number_format($this->getTotalAmount, 2,'.', ',') }}</td>
                                        <td>{{ number_format($this->getTotalCost, 2,'.', ',') }}</td>
                                        <td>{{ number_format($this->getTotalProfit, 2,'.', ',') }}</td>
                                        <td>{{ number_format($this->getTotalNetProfit, 2,'.', ',') }}</td>
                                        <td></td>
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
