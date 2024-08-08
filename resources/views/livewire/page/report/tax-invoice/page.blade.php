<div>
    <livewire:component.page-heading title_main="Report" title_sub="ภาษีขาย" breadcrumb_title="Report"
        breadcrumb_page="ภาษีขาย" />

    <div class="container-fluid">
        <form wire:submit="$refresh">
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
                                        <label class="font-normal">เดือน</label>
                                        <div>
                                            <select class="form-control"
                                                name="month" id="month" wire:model="monthSearch">
                                                <option value="">- select -</option>
                                                @foreach (ThaiDate::full_month_list() as $i => $month)
                                                    <option value="{{ $i+1 }}">
                                                        {{ $month }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">ปี</label>
                                        <div>
                                            <select class="form-control"
                                                name="year" id="year" wire:model="yearSearch">
                                                <option value="">- select -</option>
                                                @foreach ($yearList as $year)
                                                    <option value="{{ $year }}">
                                                        {{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    
                                    <a class="btn btn-secondary" target="_blank"
                                        href="{{'/api/print/report_tax_invoice/'.$yearSearch.'/'.$monthSearch}}"><i
                                            class="fa fa-print"></i>
                                        Print</a>
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
                                            <th data-toggle="true" width="15%">Bill No.</th>
                                            <th data-hide="phone" width="15%">Date</th>
                                            <th data-toggle="true" width="30%">Supplier Name</th>
                                            <th data-hide="phone,tablet" width="10%">Amount</th>
                                            <th width="5%">Vat</th>
                                            <th data-hide="phone,tablet" data-sort-ignore="true" width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($data) > 0)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->documentID }}</td>
                                                <td>{{Service::DateFormat($item->documentDate, true)}}</td>
                                                <td>{{ $item->customer != null ? $item->customer->custNameTH : '' }}</td>
                                                <td>{{ number_format($item->items_sum_charges_receive, 2,'.', ',') }}</td>
        
                                                <td class="center">{{ $item->total_vat}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-xs btn-success"
                                                            href="{{ route('tax-invoice.form', ['action' => 'view', 'id' => $item->documentID]) }}" wire:navigate>View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">Data Not Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ number_format($this->getTotalAmount, 2,'.', ',') }}</td>
                                        <td>{{ number_format($this->getTotalVat, 2,'.', ',') }}</td>
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
