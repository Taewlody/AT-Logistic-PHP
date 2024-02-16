@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
    tr {
        background-color: #ffffff !important;
    }
    </style>

@endpush
<div>
    <livewire:component.page-heading title_main="User Type" title_sub="ประเภทผู้ใช้งาน" breadcrumb_title="Administrator" breadcrumb_page="User Type" />

    <div class="container-fluid">
        <!-- State saving Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0 row">
                    <div class="col-6">
                        
                    </div>
                    <div class="col-6" style="justify-content: flex-end; display: flex">
                        <a href="{{ route('user-type.form', ['action' => 'create']) }}" class="btn btn-primary">
                            <i class="fa fa-plus "> </i> Create new 
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="basic-1" data-page-size="{{ $data->total() }}">
                            <thead>
                                <tr>
                                    <th style="width:5%">No.</th>
                                    <th style="width:10%">Code</th>
                                    <th style="width:20%">Type Name</th>
                                    <th  style="width:10%">Status</th>
                                    <th data-hide="phone"  style="width:10%">Update By</th>
                                    <th data-hide="phone,tablet"  style="width:10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + (($data->currentPage() - 1) * $data->perPage()) }}</td>
                                        <td>{{ $item->userTypecode }}</td>
                                        <td>{{ $item->userTypeName }}</td>
                                        <td class="center"><span @class(['badge', 'label-primary' => $item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span></td>
                                        <td class="center">{{ $item->editBy != null? $item->editBy->username : '' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-success btn-xs" href="{{ route('user-type.form', ['action' => 'view', 'id' => $item->userTypecode ]) }}">View</a>
                                                <a class="btn btn-info btn-xs" href="{{ route('user-type.form', ['action' => 'edit', 'id' => $item->userTypecode ]) }}">Edit</a>
                                                <button class="btn btn-danger btn-xs" wire:confirm="Are you sure want to delete {{$item->userTypeName}}" wire:click="delete('{{$item->userTypecode}}')" wire:refresh="$refresh">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data->appends(['sort' => 'countryCode'])->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- State saving Ends-->
    </div>
</div>
@push('scripts')
    {{-- <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush

@script
<script>
    setInterval(() => {
        // console.log("wire:", $wire.get('page'));
        $wire.$refresh();
    }, 2000);
</script>

@endscript