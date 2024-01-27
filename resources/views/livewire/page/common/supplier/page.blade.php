@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <style>
    tr {
        background-color: #ffffff !important;
    }
    </style>

@endsection
<div>
    <livewire:component.page-heading title_main="Supplier" title_sub="ผู้จำหน่าย" breadcrumb_title="Common Data" breadcrumb_page="Supplier" />

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
                        <table class="table" id="basic-1">
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
                                        <td class="center">{{  $item->editBy != null? $item->editBy->username : '' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-xs" onClick="location.href='port_form?action=view&portCode={{ $item->cusCode }}">View</button>
                                                <button class="btn btn-info btn-xs" onClick="location.href='port_form?action=edit&portCode={{ $item->cusCode }}">Edit</button>
                                                <button class="btn btn-danger btn-xs" onClick="return confirmDel('{{ $item->cusCode }}','port_action.php');">Delete</button>
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