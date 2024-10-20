<div>
    <livewire:component.page-heading title_main="Bill of lading" title_sub="ใบตราส่งสินค้า" breadcrumb_title="Marketing"
        breadcrumb_page="Bill of lading" />

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
                                    <a href="{{ route('bill-of-lading.form', ['action' => 'create']) }}" class="btn btn-primary"><i class="fa fa-plus "> </i> Create new </a>
                                </div>
                            </div>
                            <br/><br/>
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
                                        <label class="font-normal">Customer</label>
                                        <div>
                                            {{-- <select class="select2_single form-control select2" 
                                                name="cusCode" id="cusCode" wire:model="customerSearch">
                                                <option value="">- select -</option>
                                                @foreach ($customerList as $customer)
                                                    <option value="{{ $customer->cusCode }}">
                                                        {{ $customer->custNameEN }}</option>
                                                @endforeach
                                            </select> --}}
                                            <livewire:element.select2 wire:model='customerSearch'
                                                name="cusCode" :options="Service::CustomerSelecter()"
                                                itemKey="cusCode" itemValue="custNameEN"
                                                :searchable="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Sale</label>
                                        <div>
                                            {{-- <select class="select2_single form-control select2"
                                                name="saleman" id="saleman" wire:model="salemanSearch">
                                                <option value="">- select -</option>
                                                @foreach ($salemanList as $saleman)
                                                    <option value="{{ $saleman->empCode }}">
                                                        {{ $saleman->empName }}</option>
                                                @endforeach
                                            </select> --}}
                                            <livewire:element.select2 wire:model='salemanSearch'
                                                name="saleman" :options="Service::AllSalemanSelecter()"
                                                itemKey="empName" itemValue="empName"
                                                :searchable="true">
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
                                        <th data-toggle="true" width="15%">Document  No.</th>
                                        <th data-hide="phone" width="15%">Date</th>
                                        <th data-toggle="true" width="30%">Customer</th>
                                        <th data-hide="phone,tablet" width="10%">ref Job</th>
                                        <th data-hide="phone,tablet" width="10%">Sale</th>
                                        <th  width="5%">Status</th>
                                        <th  width="10%">Update by</th>
                                        <th data-hide="phone,tablet"  data-sort-ignore="true" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( count($data) > 0 )
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->documentID }}</td>
                                            <td>{{ $item->documentDate }}</td>
                                            <td>{{ $item->customer != null ? $item->customer->custNameEN : '' }}</td>
                                            <td><a href="job_form?action=view&documentID={{$item->ref_jobID}}" target="blank">{{$item->ref_jobID}}</a></td>
                                            <td>{{ $item->jobOrder != null && $item->jobOrder->salemanRef != null ? $item->jobOrder->salemanRef->empName : '' }}</td>
    
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
    
                                            <td class="center">{{ $item->editBy != null ? $item->editBy->username : '' }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-xs btn-success"
                                                        href="{{ route('bill-of-lading.form', ['action' => 'view', 'id' => $item->documentID]) }}">View</a>
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('bill-of-lading.form', ['action' => 'edit', 'id' => $item->documentID]) }}">Edit</a>
                                                    <button class="btn btn-xs btn-danger"
                                                        onClick="return confirmDel('{{ $item->fCode }}','port_action.php');">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">Data Not Found</td>
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
       
        </form>
    </div>
</div>
