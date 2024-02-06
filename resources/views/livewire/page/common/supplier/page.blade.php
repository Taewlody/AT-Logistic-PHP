<div>
    <livewire:component.page-heading title_main="Supplier" title_sub="ผู้จำหน่าย" breadcrumb_title="Common Data" breadcrumb_page="Supplier" />

    <div class="container-fluid">

        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-7"></div>
                        <div class="col-3">
                            <input type="text" id="search" name="search" class="form-control" wire:model.live="searchText" placeholder="Search in table">
                        </div>
                        <div class="col-2" style="justify-content: flex-end; display: flex">
                            <a href="{{ route('supplier.form', ['action' => 'create']) }}" class="btn btn-primary">
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
                                <th style="width:40%">Supplier Name</th>
                                <th  style="width:10%">Status</th>
                                <th data-hide="phone"  style="width:10%">Update By</th>
                                <th data-hide="phone,tablet"  style="width:10%">Action</th>
                            </tr>
                          </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->supCode }}</td>
                                    <td>{{ $item->supNameTH }}</td>
                                    <td class="center"><span @class(['badge', 'label-primary' => $item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span></td>
                                    <td class="center">{{ $item->editBy != null? $item->editBy->username : '' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-success" href="{{ route('supplier.form', ['action' => 'view', 'id' => $item->supCode]) }} ">View</a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('supplier.form', ['action' => 'edit', 'id' => $item->supCode]) }} ">Edit</a>
                                            <button class="btn btn-xs btn-danger" wire:confirm="Are you sure want to delete {{$item->supNameTH}}" wire:click="delete('{{$item->supCode}}')">Delete</button>
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

