@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
    tr {
        background-color: #ffffff !important;
    }
    </style>

@endsection
<div>
    <livewire:component.page-heading title_main="Saleman" title_sub="พนักงานขาย" breadcrumb_title="Common Data" breadcrumb_page="Saleman" />

    <div class="container-fluid">
        <!-- State saving Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0 row">
                    <div class="col-6">
                        
                    </div>
                    <div class="col-6" style="justify-content: flex-end; display: flex">
                        <a href="country_form?action=add" class="btn btn-primary">
                            <i class="fa fa-plus "> </i> Create new 
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="basic-1" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Employee Code</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th data-hide="phone">Update By</th>
                                    <th data-hide="phone,tablet">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->empCode }}</td>
                                        <td>{{ $item->empName }}</td>
                                        <td class="center"><span @class(['badge', 'label-primary' => $item->isActive])>{{ $item->isActive ? 'Active' : 'Disable' }}</span></td>
                                        <td class="center">{{ $item->editBy != null? $item->editBy->username : '' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-xs" onClick="location.href='port_form?action=view&portCode={{ $item->portCode }}">View</button>
                                                <button class="btn btn-info btn-xs" onClick="location.href='port_form?action=edit&portCode={{ $item->portCode }}">Edit</button>
                                                <button class="btn btn-danger btn-xs" onClick="return confirmDel('{{ $item->portCode }}','port_action.php');">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- State saving Ends-->
    </div>
</div>

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection