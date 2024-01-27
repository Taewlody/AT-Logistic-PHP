<div>
    <livewire:component.page-heading title_main="Messenger Booking" breadcrumb_title="Messenger"
        breadcrumb_page="Messenger Booking" />

    <div class="wrapper wrapper-content animated fadeInRight ecommerce">

        <div class="ibox-title">
            <h5>Search Condition</h5>
            <div class="ibox-tools">
                <a href="job_form?action=add" class="btn btn-primary btn-xs"><i class="fa fa-plus "> </i> Create new </a>
            </div>
        </div>

        <div class="ibox-content m-b-sm border-bottom">
            <form id="form" name="form" method="post">
                <div class="row m-b-sm m-t-sm">
                    <div class="col-md-11">
                        <div class="input-group">
                            <div class="form-group col-margin0" id="dateStart" style="width: 150px;">
                                <label class="font-normal">Date Range</label>
                                <div class="input-group date"> <span class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" name="dateStart" class="form-control"
                                        wire:model.live="dateStart" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group col-margin0 " id="dateEnd" style="width: 150px;">
                                <label class="font-normal">To</label>
                                <div class="input-group date"> <span class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" name="dateEnd" class="form-control " wire:model.live="dateEnd"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="font-normal">Document No.</label>
                                <div class="input-group">
                                  <input type="text" id="documentID" name="documentID" class="form-control" wire:model.live="documentNo">
                                </div>
                              </div>
                                
                          {{-- <div class="form-group" >
                                <label class="font-normal">Job No.</label>
                                <div class="input-group">
                                  <input type="text" id="refJobNo" name="refJobNo" class="form-control" wire:model.live="jobNo">
                                </div>
                              </div> --}}
                            <div class="form-group col-margin0">
                                <label class="font-normal">Job Type</label>
                                <div>
                                    <select class="select2_single form-control select2" style="width:300px;"
                                        name="cusCode" id="cusCode" wire:model.live="customerSearch">
                                        <option value="">- select -</option>
                                        {{-- @foreach ($customerList as $customer)
                                            <option value="{{ $customer->cusCode }}">
                                                {{ $customer->custNameEN }}</option>
                                        @endforeach --}}
                                        <option value="1">รับเอกสาร</option>
							            <option value="1">วางบิล/รับเชค</option>
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


                        {{-- <table class="footable table table-stripped toggle-arrow-tiny"
                            data-page-size="{{ $data->total() }}" data-filter=#filter> --}}
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">

                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th data-toggle="true" width="10%">Document  No.</th>
                                    <th data-hide="phone" width="15%"> Date</th>
                                    <th data-toggle="true" width="25%">Messenger</th>
                                    
                                    <th data-hide="phone,tablet" width="15%">Job Type</th>
                                
                                    <th data-hide="phone,tablet" width="15%">Status</th>
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
                                                        'label',
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
                                                <button class="btn-white btn btn-xs"
                                                    onClick="location.href='port_form?action=view&portCode={{ $item->fCode }}">View</button>
                                                <button class="btn-white btn btn-xs"
                                                    onClick="location.href='port_form?action=edit&portCode={{ $item->fCode }}">Edit</button>
                                                <button class="btn-white btn btn-xs"
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
                                  
                                    <td><span class="label label-primary">Approve</span></td>
                                    <td class="text-right"><div class="btn-group">
                                        <button class="btn-white btn btn-xs">View</button>
                                        <button class="btn-white btn btn-xs">Edit</button>
                                        <button class="btn-white btn btn-xs">Delete</button>
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>INV2106-002</td>
                                    <td>16/6/2021</td>
                                    <td>Messenger</td>
                                    
                                    
                                    <td>ส่งเอกสาร</td>
                                   
                                    <td><span class="label label-primary">Approve</span></td>
                                    <td class="text-right"><div class="btn-group">
                                        <button class="btn-white btn btn-xs">View</button>
                                        <button class="btn-white btn btn-xs">Edit</button>
                                        <button class="btn-white btn btn-xs">Delete</button>
                                      </div></td>
                                  </tr>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="10"><ul class="pagination float-left">
                                      </ul></td>
                                  </tr>
                                </tfoot>
                        </table>
                        {{-- {{ $data->appends(['sort'])->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
