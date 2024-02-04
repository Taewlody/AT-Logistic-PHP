<div>
    <livewire:component.page-heading title_main="Bank Account" title_sub="บัญชีธนาคาร" breadcrumb_title="Common Data" breadcrumb_page="Bank Account" />
    
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-7"></div>
                        <div class="col-3">
                            <input type="text" id="search" name="search" class="form-control" wire:model.live="searchText" placeholder="Search in table">
                        </div>
                        <div class="col-2" style="justify-content: flex-end; display: flex">
                            <a href="country_form?action=add" class="btn btn-primary">
                                <i class="fa fa-plus "> </i> Create new 
                            </a>
                        </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="footable table table-stripped toggle-arrow-tiny"
                        data-page-size="{{ $data->total() }}" data-filter=#filter>
                        <thead>
                            <tr>
                                <th style="width:5%">No.</th>
                                <th style="width:25%">Account Name</th>
                                <th style="width:25%">Account ID</th>
                                <th style="width:10%">Status</th>
                                <th data-hide="phone" style="width:10%">Update By</th>
                                <th data-hide="phone,tablet" style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->accountName }}</td>
                                    <td>{{ $item->accountID }}</td>
                                    <td class="center"><span
                                            @class(['badge', 'label-primary' => $item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span>
                                    </td>
                                    <td class="center">{{ $item->editBy != null? $item->editBy->username : '' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-success"
                                                onClick="location.href='port_form?action=view&portCode={{ $item->accountCode }}">View</button>
                                            <button class="btn btn-xs btn-primary"
                                                onClick="location.href='port_form?action=edit&portCode={{ $item->accountCode }}">Edit</button>
                                            <button class="btn btn-xs btn-danger"
                                                onClick="return confirmDel('{{ $item->accountCode }}','port_action.php');">Delete</button>
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
