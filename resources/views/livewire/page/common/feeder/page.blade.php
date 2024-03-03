<div>
    <livewire:component.page-heading title_main="Feeder" title_sub="ชื่อเรือ" breadcrumb_title="Common Data" breadcrumb_page="Feeder" />

    <div class="container-fluid">

        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-7"></div>
                        <div class="col-3">
                            <input type="text" id="search" name="search" class="form-control" wire:model.live="searchText" placeholder="Search in table">
                        </div>
                        <div class="col-2" style="justify-content: flex-end; display: flex">
                            <a href="{{ route('feeder.form', ['action' => 'create']) }}" class="btn btn-primary">
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
                                <th style="width:40%">Feeder Name</th>
                                <th style="width:10%">Status</th>
                                <th data-hide="phone" style="width:10%">Update By</th>
                                <th data-hide="phone,tablet" style="width:10%">Action</th>
                            </tr>
                          </thead>
                            <tbody>
                                @if(count($data) > 0)
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->fCode }}</td>
                                    <td>{{ $item->fName }}</td>
                                    <td class="center"><span @class(['badge', 'label-primary' => $item->isActive, 'label-secondary' => !$item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span></td>
                                    <td class="center">{{ $item->editBy != null? $item->editBy->username : '' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-success" href="{{ route('feeder.form', ['action' => 'view', 'id' => $item->fCode]) }}">View</a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('feeder.form', ['action' => 'edit', 'id' => $item->fCode]) }}">Edit</a>
                                            <button class="btn btn-xs btn-danger" wire:confirm="Are you sure want to delete {{$item->fName}}" wire:click="delete('{{$item->fCode}}')" wire:refresh="$refresh">Delete</button>
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

