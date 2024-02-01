<div>
    <livewire:component.page-heading title_main="Invoice" title_sub="ใบแจ้งหนี้" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Account"
        breadcrumb_page="Invoice" />

    <div class="wrapper wrapper-content animated fadeInRight ecommerce">

        <div class="ibox-title">
            <h5>Search Condition</h5>
            <div class="ibox-tools">
                <a href="job_form?action=add" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a>
            </div>
        </div>

        <div class="ibox-content m-b-sm border-bottom">
            <form wire:submit="search">
                <div class="row m-b-sm m-t-sm">
                    <div class="col-md-11">
                        <div class="input-group">
                            <div class="form-group col-margin0" id="dateStart" style="width: 150px;">
                                <label class="font-normal">Date Range</label>
                                <div class="input-group date"> <span class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" name="dateStart" class="form-control"
                                        wire:model="dateStart" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group col-margin0 " id="dateEnd" style="width: 150px;">
                                <label class="font-normal">To</label>
                                <div class="input-group date"> <span class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" name="dateEnd" class="form-control " wire:model="dateEnd"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="font-normal">Invoice  No.</label>
                                <div class="input-group">
                                  <input type="text" id="invoiceID" name="invoiceID" class="form-control" wire:model="invoiceNo">
                                </div>
                              </div>
                                
                          <div class="form-group" >
                                <label class="font-normal">Job No.</label>
                                <div class="input-group">
                                  <input type="text" id="refJobNo" name="refJobNo" class="form-control" wire:model="jobNo">
                                </div>
                              </div>
                            <div class="form-group col-margin0">
                                <label class="font-normal">Customer</label>
                                <div>
                                    <select class="select2_single form-control select2" style="width:300px;"
                                        name="cusCode" id="cusCode" wire:model="customerSearch">
                                        <option value="">- select -</option>
                                        @foreach ($customerList as $customer)
                                            <option value="{{ $customer->cusCode }}">
                                                {{ $customer->custNameEN }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-normal" style="color: wheat">.</label>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div wire:loading class="loader-wrapper">
                        <div class="loader"></div>
                    </div>

                    <div class="ibox-content">
                        <table wire:loading.remove class="footable table table-stripped toggle-arrow-tiny"
                            data-page-size="{{ $data->total() }}" data-filter=#filter>
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th data-toggle="true" width="10%">Document  No.</th>
                                    <th data-hide="phone" width="15%">Document Date</th>
                                    <th data-toggle="true" width="10%">JobNo</th>
                                    <th data-toggle="true" width="35%">Customer</th>
                                    <th data-hide="phone,tablet" width="10%">Amount</th>
                                    <th  width="10%">Status</th>
                                    <th data-hide="phone,tablet"  data-sort-ignore="true" width="15%">Action</th>                            
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->documentID }}</td>
                                        <td>{{ $item->documentDate }}</td>
                                        <td>{{ $item->refJobNo }}</td>
                                        <td>{{ $item->customer != null ? $item->customer->custNameTH : '' }}</td>
                                        <td>{{ $item->grandTotal }}</td>
                                        @if ($item->docStatus != null)
                                            <td class="center"><span
                                                    @class([
                                                        'label',
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
                                                <button class="btn-white btn btn-xs"
                                                    onClick="location.href='port_form?action=view&portCode={{ $item->fCode }}">View</button>
                                                <button class="btn-white btn btn-xs"
                                                    onClick="location.href='port_form?action=edit&portCode={{ $item->fCode }}">Edit</button>
                                                <button class="btn-white btn btn-xs"
                                                    onClick="return confirmDel('{{ $item->fCode }}','port_action.php');">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                        {{ $data->withQueryString()->links('layouts.themes.layout.custom-pagination-links') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
