<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3>สรุปยอดสำรองจ่าย</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3 text-end">
                    <div class="col text-end" style="margin: auto">
                            Year   
                    </div>
                    <div class="col-3">
                        <select class="select2_single form-control select2"  wire:model="yearBillSearch">
                            <option value="">- select -</option>
                            @foreach ($yearOptions as $year)
                            <option value="{{$year->year}}">{{$year->year}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary" wire:click="searchYearReservePayment">Search</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="basic-1">
                        <thead>
                            <tr>
                                @foreach (EngDate::full_month_list() as $month)
                                <th>{{$month}}</th>
                                @endforeach
                                <th>Sum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($dataBill) > 0)
                            <tr>
                                @foreach( $dataBill as $bill)
                                    <td>{{ number_format($bill, 2, '.', ',')}}</td>
                                @endforeach
                                <td>{{ number_format(array_sum($dataBill), 2, '.', ',')}}</td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="12" class="text-center">Data Not Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table> 
                </div>                     
            </div>
        </div>
    </div>
</div>