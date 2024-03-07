<div>
    <livewire:component.page-heading title_main="Saleman" title_sub="พนักงานขาย" breadcrumb_title="Common Data" breadcrumb_page="Saleman" />

    <div class="container-fluid">

        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-7"></div>
                        <div class="col-3">
                            <input type="text" id="search" name="search" class="form-control" wire:model.live="searchText" placeholder="Search in table">
                        </div>
                        <div class="col-2" style="justify-content: flex-end; display: flex">
                            <a href="{{ route('saleman.form', ['action' => 'create']) }}" class="btn btn-primary">
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
                                <th style="width:15%">Employee Code</th>
                                <th style="width:35%">Name</th>
                                <th  style="width:10%">Status</th>
                                <th data-hide="phone"  style="width:10%">Update By</th>
                                <th data-hide="phone,tablet"  style="width:10%">Action</th>
                            </tr>
                          </thead>
                            <tbody>
                                @if(count($data) > 0)
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->empCode }}</td>
                                    <td>{{ $item->empName }}</td>
                                    <td class="center"><span @class(['badge', 'label-primary' => $item->isActive, 'label-secondary' => !$item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span></td>
                                    <td class="center">{{ $item->editBy != null? $item->editBy->username : '' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-success" href="{{ route('saleman.form', ['action' => 'view', 'id' => $item->empCode]) }}">View</a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('saleman.form', ['action' => 'edit', 'id' => $item->empCode]) }}">Edit</a>
                                            <button class="btn btn-xs btn-danger" wire:confirm="Are you sure want to delete {{$item->empName}}" wire:click="delete('{{$item->empCode}}', '{{$item->usercode}}')" wire:refresh="$refresh">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">Data Not Found</td>
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

