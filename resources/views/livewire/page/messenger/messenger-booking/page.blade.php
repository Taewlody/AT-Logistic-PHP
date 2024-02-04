<div>
    <livewire:component.page-heading title_main="Messenger Booking" breadcrumb_title="Messenger"
        breadcrumb_page="Messenger Booking" />

    <div class="container-fluid">
        <form wire:submit="search">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 m-auto">
                                <h3>Search Condition</h3>
                                </div>

                                <div class="col-6 text-end">
                                    <a href="job_form?action=add" class="btn btn-primary"><i class="fa fa-plus "> </i> Create new </a>
                                </div>
                            </div>
                            <br/><br/>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0" id="dateStart">
                                        <label class="font-normal">Date Range</label>
                                        <div class="input-group date"> 
                                            <input class="form-control digits" name="dateStart" wire:model="dateStart" autocomplete="off" type="date" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group" id="dateEnd">
                                        <label class="font-normal">To</label>
                                        <div class="input-group date"> 
                                            <input class="form-control digits" name="dateEnd" wire:model="dateEnd" autocomplete="off" type="date" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Document No.</label>
                                        <div>
                                            <input type='text' name='documentNo' class='form-control' id="documentNo"
                                                wire:model="documentNo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group col-margin0">
                                        <label class="font-normal">Job Type</label>
                                        <div>
                                            <input type='text' name='documentNo' class='form-control' id="documentNo"
                                                wire:model="documentNo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="ibox-content table-responsive">

                                <div wire:loading class="loader-wrapper">
                                    <div class="loader"></div>
                                </div>
                            
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
    
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th data-toggle="true" width="15%">Document No.</th>
                                            <th data-hide="phone" width="15%"> Date</th>
                                            <th data-toggle="true" width="25%">Messenger</th>
                                            
                                            <th data-hide="phone,tablet" width="15%">Job Type</th>
                                        
                                            <th data-hide="phone,tablet" width="10%">Status</th>
                                            <th class="text-center" data-sort-ignore="true" width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->documentID }}</td>
                                            <td>{{ $item->documentDate }}</td>
                                            <td>{{ $item->customer != null ? $item->customer->custNameTH : '' }}</td>
                                            
    
                                            <td>{{ $item->refJobNo }}</td>
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
                                                <td class="center"><span
                                                        @class([
                                                            'label'
                                                        ])>Disabled</span>
                                                </td>
                                            @endif
    
                                            <td class="center">{{ $item->editBy != null ? $item->editBy->username : '' }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs btn-success"
                                                        onClick="location.href='port_form?action=view&portCode={{ $item->fCode }}">View</button>
                                                    <button class="btn btn-xs btn-primary"
                                                        onClick="location.href='port_form?action=edit&portCode={{ $item->fCode }}">Edit</button>
                                                    <button class="btn btn-xs btn-danger"
                                                        onClick="return confirmDel('{{ $item->fCode }}','port_action.php');">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach --}}
    
                                        <tr>
                                            <td>1</td>
                                            <td>INV2106-001</td>
                                            <td>16/6/2021</td>
                                            <td>Messenger</td>
                                    
                                            <td>รับเชค/วางบิล</td>
                                        
                                            <td><span class="badge label-primary">Approve</span></td>
                                            <td class="text-right"><div class="btn-group">
                                                <button class="btn btn-xs btn-success">View</button>
                                                <button class="btn btn-xs btn-primary">Edit</button>
                                                <button class="btn btn-xs btn-danger">Delete</button>
                                            </div></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>INV2106-002</td>
                                            <td>16/6/2021</td>
                                            <td>Messenger</td>
                                            
                                            
                                            <td>ส่งเอกสาร</td>
                                        
                                            <td><span class="badge label-primary">Approve</span></td>
                                            <td class="text-right"><div class="btn-group">
                                                <button class="btn btn-xs btn-success">View</button>
                                                <button class="btn btn-xs btn-primary">Edit</button>
                                                <button class="btn btn-xs btn-danger">Delete</button>
                                            </div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            {{-- <br/>
                            <div class="row">
                                <div class="col-4">
                                    {{ $data->withQueryString()->links('layouts.themes.layout.custom-pagination-info') }}
                                </div>
                                <div class="col-8"> 
                                    {{ $data->withQueryString()->links('layouts.themes.layout.custom-pagination-links') }}
                                </div>
                            </div>                  --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
