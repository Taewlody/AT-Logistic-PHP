<div>
    <livewire:component.page-heading title_main="Invoice" title_sub="ใบแจ้งหนี้" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Account"
        breadcrumb_page="Invoice" />

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
                                    <a href="job_form?action=add" class="btn btn-primary"><i class="fa fa-plus "> </i> Create new </a>
                                </div>
                            </div>
                            <br/><br/>
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
                                                        {{ $customer->custNameEN }}</option>
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
                                                        <option value="{{ $saleman->empCode }}">
                                                            {{ $saleman->empName }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Job No.</label>
                                        <div>
                                            <input type='text' name='jobNo' class='form-control' id="jobNo"
                                                wire:model="jobNo">
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
                                        <label class="font-normal">Invoice No</label>
                                        <div>
                                            <input type='text' name='invNo' class='form-control' id="invNo"
                                                wire:model="invNo">
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

                            
                                <table wire:loading.remove class="footable table table-stripped toggle-arrow-tiny"
                                    data-page-size="{{ $data->total() }}" data-filter=#filter>
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th data-toggle="true" width="15%">Document No.</th>
                                            <th data-hide="phone" width="15%">Job Date</th>
                                            <th data-toggle="true" width="30%">Customer</th>
                                            <th data-hide="phone,tablet" width="10%">Job No.</th>
                                            <th data-hide="phone,tablet" width="15%">Tax Invoice</th>
                                            <th data-hide="phone,tablet" width="10%">Sale</th>
                                            <th  width="5%">Status</th>
                                            <th data-hide="phone,tablet"  data-sort-ignore="true" width="15%">Action</th>                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->documentID }}</td>
                                                <td>{{ $item->documentDate }}</td>
                                                <td>{{ $item->customer != null ? $item->customer->custNameTH : '' }}</td>
                                                <td>{{ $item->ref_jobNo }}</td>
                                                <td>{{ $item->taxivRef }}</td>
                                                <td>{{ $item->salemanRef != null ? $item->salemanRef->empName : '' }}</td>
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

                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-success"
                                                            onClick="location.href='port_form?action=view&portCode={{ $item->fCode }}">View</button>
                                                        <button class="btn btn-xs btn-primary"
                                                            onClick="location.href='port_form?action=edit&portCode={{ $item->fCode }}">Edit</button>
                                                        <button class="btn btn-xs btn-danger"
                                                            onClick="return confirmDel('{{ $item->fCode }}','port_action.php');">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
