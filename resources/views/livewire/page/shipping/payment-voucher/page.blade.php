@push('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}"> --}}
    <style>
        tr {
            background-color: #ffffff !important;
        }
    </style>
@endpush
<div>
    <livewire:component.page-heading title_main="Payment Voucher" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Shipping"
        breadcrumb_page="Payment Voucher" />

    <div class="container-fluid">
        <form wire:submit="search">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 m-auto">
                                <h3 >Search Condition</h3>
                            </div>
                            <div class="col-6 text-end">
                                <a href="country_form?action=add" class="btn btn-primary">
                                    <i class="fa fa-plus "> </i> Create new
                                </a>
                            </div>
                        </div>
                        <div>
                            {{-- <form id="form" name="form" method="get"> --}}
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-normal">Document No.</label>
                                        <div class="input-group">
                                            <input type="text" id="documentID" name="documentID" class="form-control"
                                                wire:model="documentNo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-normal">Job No.</label>
                                        <div class="input-group">
                                            <input type="text" id="refJobNo" name="refJobNo" class="form-control"
                                                wire:model="jobNo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">supplier</label>
                                        <div>
                                            <select class="select2_single form-control select2"
                                                name="cusCode" id="cusCode" wire:model="supplierSearch">
                                                <option value="">- select -</option>
                                                @foreach ($supplierList as $supplier)
                                                    <option value="{{ $supplier->cusCode }}">
                                                        {{ $supplier->supNameEN }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0" id="dateStart">
                                        <label class="font-normal">Date Range</label>
                                        <div class="input-group date"> 
                                            <input class="form-control digits" name="dateStart" wire:model="dateStart" autocomplete="off" type="datetime-local">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0 " id="dateEnd">
                                        <label class="font-normal">To</label>
                                        <div class="input-group date"> 
                                            <input class="form-control digits" name="dateEnd" wire:model="dateEnd" autocomplete="off" type="datetime-local">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                        Search
                                    </button>
                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox">

                                        <div class="ibox-content table-responsive">

                                            <div wire:loading class="loader-wrapper">
                                                <div class="loader"></div>
                                            </div>
                                            <table wire:loading.remove class="footable table table-stripped toggle-arrow-tiny"
                                                data-page-size="{{ $data->total() }}" data-filter=#filter>
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No.</th>
                                                        <th data-toggle="true" width="15%">Document  No.</th>
                                                        <th data-hide="phone" width="15%">Document Date</th>
                                                        <th data-hide="phone,tablet" width="10%">Job No.</th>
                                                        <th data-toggle="true" width="35%">Customer</th>
                                                        <th data-hide="phone,tablet" width="10%">Amount</th>
                                                        <th width="5%">Status</th>
                                                        <th data-hide="phone,tablet" data-sort-ignore="true" width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}
                                                            </td>
                                                            <td>{{ $item->documentID }}</td>
                                                            <td>{{ $item->documentDate }}</td>
                                                            <td>{{ $item->refJobNo }}</td>
                                                            <td>{{ $item->supplier != null ? $item->supplier->supNameTH : '' }}</td>
                                                            <td>{{ $item->sumTotal }}</td>
                                                            @if ($item->docStatus != null)
                                                                <td class="center"><span
                                                                        @class([
                                                                            'badge',
                                                                            'label-primary' => $item->docStatus->status_code == 'A',
                                                                            'label-danger' => $item->docStatus->status_code == 'D',
                                                                            'label-warning' => $item->docStatus->status_code == 'P',
                                                                        ])>{{ $item->docStatus->status_name }}</span>
                                                                </td>
                                                            @else
                                                                <td class="center"><span @class(['label'])>Disabled</span>
                                                                </td>
                                                            @endif

                                                            {{-- <td class="center">{{ $item->editBy != null ? $item->editBy->username : '' }}
                                                        </td> --}}
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button class="btn-success btn btn-xs"
                                                                        onClick="location.href='port_form?action=view&portCode={{ $item->fCode }}">View</button>
                                                                    <button class="btn-primary btn btn-xs"
                                                                        onClick="location.href='port_form?action=edit&portCode={{ $item->fCode }}">Edit</button>
                                                                    <button class="btn-danger btn btn-xs"
                                                                        onClick="return confirmDel('{{ $item->fCode }}','port_action.php');">Delete</button>
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
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

@script
    <script>
        $wire.on('post-search', () => {
            // $('.footable').footable();
            console.log("post-search");
            $('.loader-wrapper').show();
        });

        Livewire.hook('request', ({
            uri,
            options,
            payload,
            respond,
            succeed,
            fail
        }) => {
            // Runs after commit payloads are compiled, but before a network request is sent...
            console.log("Live wire hook request");
            respond(({
                status,
                response
            }) => {
                // Runs when the response is received...
                // "response" is the raw HTTP response object
                // before await response.text() is run...
                console.log("respond", status, ":", response);
            })

            succeed(({
                status,
                json
            }) => {
                // Runs when the response is received...
                // "json" is the JSON response object...
                console.log("succeed", status, ":", json);
            })

            fail(({
                status,
                content,
                preventDefault
            }) => {
                // Runs when the response has an error status code...
                // "preventDefault" allows you to disable Livewire's
                // default error handling...
                // "content" is the raw response content...
                console.log("fail", status, ":", content, "->", preventDefault);
            })
        })
    </script>
@endscript
