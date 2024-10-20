<div>
    <livewire:component.page-heading title_main="Report" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Report"
        breadcrumb_page="ใบสำคัญจ่าย" />

    <div class="container-fluid">
        <form wire:submit="search" wire:refresh="$refresh">
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
                                        <label class="font-normal">Supplier</label>
                                        <div>
                                            {{-- <select class="select2_single form-control select2"
                                            name="supCode" id="supCode" wire:model="supplierSearch">
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
                                            <th width="5%">No.</th>
                                            <th width="10%">Document No.</th>
                                            <th width="10%">Document Date</th>
                                            <th width="20%">Supplier</th>
                                            <th width="20%">Detail</th>
                                            <th>Amount</th>
                                            <th>Ref. Bill No.</th>
                                            <th>Ref. Job No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($data) > 0)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->documentID }}</td>
                                                <td>{{ Service::DateFormat($item->documentDate, true) }}</td>
                                                <td>{{ $item->supplier != null ? $item->supplier->supNameEN ? $item->supplier->supNameEN : $item->supplier->supNameTH : '' }}</td>
                                                <td>{{ $item->items[0]->chartDetail }}</td>
                                                <td>{{ number_format($item->items[0]->amount, 2) }}</td>
                                                <td>{{ $item->items[0]->invNo }}</td>
                                                <td>{{ $item->refJobNo }}</td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">Data Not Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
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
