@push('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}"> --}}
    <style>
        tr {
            background-color: #ffffff !important;
        }
    </style>
@endpush
<div>
    <livewire:component.page-heading title_main="Payment Voucher" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Account"
        breadcrumb_page="Payment Voucher" />

    <div class="container-fluid">

        <div class="ibox-title">
            <h5>Search Condition</h5>
            <div class="col-12" style="justify-content: flex-end; display: flex">
                <a href="country_form?action=add" class="btn btn-primary">
                    <i class="fa fa-plus "> </i> Create new
                </a>
            </div>
        </div>

        {{-- <form wire:submit="search"> --}}
        <div class="ibox-content m-b-sm border-bottom">
            <form wire:submit="search">
                <div class="row m-b-sm m-t-sm">
                    <div class="col-md-11">
                        <div class="input-group">
                            <div class="form-group col-margin0" id="dateStart" style="width: 150px;">
                                <label class="font-normal">Date Range</label>
                                <div class="input-group date"> <span class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" name="dateStart" class="form-control" wire:model="dateStart"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group col-margin0 " id="dateEnd" style="width: 150px;">
                                <label class="font-normal">To</label>
                                <div class="input-group date"> <span class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" name="dateEnd" class="form-control " wire:model="dateEnd"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-normal">Document No.</label>
                                <div class="input-group">
                                    <input type="text" id="documentID" name="documentID" class="form-control"
                                        wire:model="documentNo">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-normal">Job No.</label>
                                <div class="input-group">
                                    <input type="text" id="refJobNo" name="refJobNo" class="form-control"
                                        wire:model="jobNo">
                                </div>
                            </div>
                            <div class="form-group col-margin0">
                                <label class="font-normal">supplier</label>
                                <div>
                                    <select class="select2_single form-control select2" style="width:300px;"
                                        name="cusCode" id="cusCode" wire:model="supplierSearch">
                                        <option value="">- select -</option>
                                        @foreach ($supplierList as $supplier)
                                            <option value="{{ $supplier->cusCode }}">
                                                {{ $supplier->supNameEN }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-normal" style="color: wheat">.</label>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-content">

                        <div wire:loading class="loader-wrapper">
                            <div class="loader"></div>
                        </div>
                        <table wire:loading.remove class="footable table table-stripped toggle-arrow-tiny"
                            data-page-size="{{ $data->total() }}" data-filter=#filter>
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th data-toggle="true" width="10%">Document  No.</th>
                                    <th data-hide="phone" width="15%">Document Date</th>
                                    <th data-hide="phone,tablet" width="10%">Job No.</th>
                                    <th data-toggle="true" width="35%">Customer</th>
                                    <th data-hide="phone,tablet" width="10%">Amount</th>
                                    <th width="10%">Status</th>
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
                                                        'label',
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
                                                <button class="btn-white btn btn-xs"
                                                    onClick="location.href='port_form?action=view&portCode={{ $item->fCode }}">View</button>
                                                <button class="btn-white btn btn-xs"
                                                    onClick="location.href='port_form?action=edit&portCode={{ $item->fCode }}">Edit</button>
                                                <button class="btn-white btn btn-xs"
                                                    onClick="return confirmDel('{{ $item->fCode }}','port_action.php');">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                        {{ $data->withQueryString()->links('layouts.themes.layout.custom-pagination-links') }}
                    </div>
                </div>
            </div>
        </div>
        {{-- </form> --}}
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
