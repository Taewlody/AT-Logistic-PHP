@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
    tr {
        background-color: #ffffff !important;
    }
    </style>

@endpush
<div>
    <livewire:component.page-heading title_main="Country" title_sub="ประเทศ" breadcrumb_title="Common Data" breadcrumb_page="Country" />

    <div class="container-fluid">
        {{-- <form wire:submit="search"> --}}
        
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-7"></div>
                        <div class="col-3">
                            <input type="text" id="search" name="search" class="form-control" wire:model.live="searchText" placeholder="Search in table">
                        </div>
                        <div class="col-2" style="justify-content: flex-end; display: flex">
                            <a href="{{ route('country.form', ['action' => 'create']) }}" class="btn btn-primary">
                                <i class="fa fa-plus "> </i> Create new 
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" data-page-size="{{ $data->total() }}">
                            <thead>
                                <tr>
                                    <th style="width:5%">No.</th>
                                    <th style="width:10%">Code</th>
                                    <th style="width:40%">Country Name</th>
                                    <th  style="width:10%">Status</th>
                                    <th data-hide="phone" style="width:10%">Update By</th>
                                    <th data-hide="phone,tablet" style="width:10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + (($data->currentPage() - 1) * $data->perPage()) }}</td>
                                        <td>{{ $item->countryCode }}</td>
                                        <td>{{ $item->countryNameTH }}</td>
                                        <td class="center"><span @class(['badge', 'label-primary' => $item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span></td>
                                        <td class="center">{{ $item->editBy != null? $item->editBy->username : '' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a type="button" class="btn btn-success btn-xs" href="{{ route('country.form', ['countryCode' => $item->countryCode ]) }}">View</a>
                                                <a type="button" class="btn btn-info btn-xs" href="{{ route('country.form', ['action' => 'edit', 'countryCode' => $item->countryCode ]) }}">Edit</a>
                                                <a type="button" class="btn btn-danger btn-xs" wire:ckick="delete({{$item->countryCode}})">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
        
        {{-- </form> --}}
    </div>
</div>
@push('scripts')
    {{-- <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush

{{-- @script
<script>
    setInterval(() => {
        // console.log("wire:", $wire.get('page'));
        $wire.$refresh();
    }, 2000);
</script>

@endscript --}}
