<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3>สรุปค่าใช้จ่ายดำเนินงาน</h3>
            </div>
            <div class="card-body">
                {{-- <div class="card-body"> --}}
                    <div class="row mb-3 text-end">
                        <div class="col text-end" style="margin: auto">
                                Year   
                        </div>
                        <div class="col-3">
                            <select class="select2_single form-control select2"  wire:model="yearExpensePaymentSearch">
                                <option value="">- select -</option>
                                @foreach ($yearOptions as $year)
                                <option value="{{$year->year}}">{{$year->year}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" wire:click="searchYearExpensePayment">Search</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="basic-1">
                            <thead>
                                <tr>
                                    <th></th>
                                    @foreach (EngDate::full_month_list() as $month)
                                    <th>{{$month}}</th>
                                    @endforeach
                                    <th>Sum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($expense_payment) > 0)
                                @foreach ($expense_payment as $supCode => $items)
                                    <tr>
                                        <th style="white-space: nowrap">{{ $this->getNameSup($supCode) }}</th>

                                        @php
                                            $monthlyTotalsExpense = array_fill(1, 12, 0); // Initialize array for 12 months
                                            $sumTotalExpense = 0;
                                        @endphp

                                        @foreach ($items as $item)
                                            @php
                                                $monthlyTotalsExpense[$item->month] = $item->sumTotal;
                                                $sumTotalExpense += $item->sumTotal;
                                            @endphp
                                        @endforeach

                                        @foreach ($monthlyTotalsExpense as $monthTotal)
                                            <td>{{ $monthTotal > 0 ? number_format($monthTotal, 2) : '-' }}</td>
                                        @endforeach

                                        <th>{{ number_format($sumTotalExpense, 2) }}</th>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="14" class="text-center">Data Not Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table> 
                    </div>   
                {{-- </div> --}}
                        
            </div>
        </div>
    </div>
</div>