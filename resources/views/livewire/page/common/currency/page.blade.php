<div>
    <livewire:component.page-heading title_main="Currency" title_sub="สกุลเงิน" breadcrumb_title="Common Data"
        breadcrumb_page="Currency" />

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-7"></div>
                        <div class="col-3">
                            <input type="text" id="search" name="search" class="form-control" wire:model.live="searchText" placeholder="Search in table">
                        </div>
                        <div class="col-2" style="justify-content: flex-end; display: flex">
                            <a href="{{ route('currency.form', ['action' => 'create']) }}" class="btn btn-primary">
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
                                <th style="width:20%">Type Name</th>
                                <th style="width:20%">exchange rate(฿)</th>
                                <th  style="width:10%">Status</th>
                                <th data-hide="phone"  style="width:10%">Update By</th>
                                <th data-hide="phone,tablet"  style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->currencyCode }}</td>
                                    <td>{{ $item->currencyName }}</td>
                                    <td>{{ $item->exchange_rate }}</td>
                                    <td class="center"><span
                                            @class(['badge', 'label-primary' => $item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span>
                                    </td>
                                    <td class="center">{{ $item->editBy != null? $item->editBy->username : ''}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-success" href="{{route('currency.form', ['action' => 'view', 'id' => $item->currencyCode])}}">View</a>
                                            <a class="btn btn-xs btn-primary" href="{{route('currency.form', ['action' => 'edit', 'id' => $item->currencyCode])}}">Edit</a>
                                            <button class="btn btn-xs btn-danger" wire:confirm="Are you sure want to delete {{$item->currencyName}}" wire:click="delete('{{$item->currencyCode}}')" wire:refresh="$refresh">Delete</button>
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
