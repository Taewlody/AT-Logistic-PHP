<div>
    <livewire:component.page-heading title_main="Port" title_sub="ท่าเรือ" breadcrumb_title="Common Data" breadcrumb_page="Port" />

    <div class="container-fluid">

        <div class="card">
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
                                <th style="width:10%">Code</th>
                                <th style="width:20%">Port Name</th>
                                <th data-hide="phone" style="width:20%">Country</th>
                                <th style="width:10%">Status</th>
                                <th data-hide="phone"  style="width:10%">Update By</th>
                                <th data-hide="phone,tablet"  style="width:10%">Action</th>
                          </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->portCode }}</td>
                                    <td>{{ $item->portNameTH }}</td>
                                    <td>{{ $item->country->countryNameTH }}</td>
                                    <td class="center"><span @class(['badge', 'label-primary' => $item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span></td>
                                    <td class="center">{{ $item->editBy != null? $item->editBy->username : '' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-success" onClick="location.href='port_form?action=view&portCode={{ $item->portCode }}">View</button>
                                            <button class="btn btn-xs btn-primary" onClick="location.href='port_form?action=edit&portCode={{ $item->portCode }}">Edit</button>
                                            <button class="btn btn-xs btn-danger" onClick="return confirmDel('{{ $item->portCode }}','port_action.php');">Delete</button>
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
