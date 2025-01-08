<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header row">
                <div class="col-6">
                    <h3>สรุปค่าใช้จ่ายดำเนินงาน</h3>
                </div>
                {{-- <div class="col-6 text-end">
                    <a class="btn btn-primary " target="_blank"
                        href="{{'/api/print/report-expense'}}">
                        <i class="fa fa-print"></i> Export
                    </a>
                </div> --}}
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
                                @php
                                    // Initialize an array to hold the sum for each month
                                    $overallMonthlyTotals = array_fill(1, 12, 0);
                                    $grandTotal = 0; // Overall total sum
                                @endphp

                                @if(count($expense_payment) > 0)
                                @foreach ($expense_payment as $detail => $items)
                                    <tr>
                                        <th style="white-space: nowrap">{{ $this->getNameCharge($detail) }}</th>

                                        @php
                                        $monthlyTotals = array_fill(1, 12, 0); // Initialize array for 12 months
                                        $sumTotal = 0;
                                    @endphp
                                    
                                    @php
                                        // Group items by month and sum the amounts
                                        $groupedItems = collect($items)->groupBy('month')->map(function ($monthItems) {
                                            return $monthItems->sum('amount');
                                        });
                                    
                                        // Fill the $monthlyTotals array with the grouped sums
                                        foreach ($groupedItems as $month => $totalAmount) {
                                            $monthlyTotals[$month] = $totalAmount;
                                            $sumTotal += $totalAmount;

                                            $overallMonthlyTotals[$month] += $totalAmount;
                                        }
                                    @endphp
                                    
                                    @foreach ($monthlyTotals as $monthTotal)
                                        <td> {{ $monthTotal > 0 ? number_format($monthTotal, 2) : '-' }}</td>
                                    @endforeach
                                       

                                        <th>{{ number_format($sumTotal, 2) }}</th>

                                        @php
                                            $grandTotal += $sumTotal; // Add to the overall total
                                        @endphp
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Sum</th>

                                    @foreach ($overallMonthlyTotals as $total)
                                        <td>{{ $total > 0 ? number_format($total, 2) : '-' }}</td>
                                    @endforeach

                                    <td>{{ number_format($grandTotal, 2) }}</td>
                                </tr>
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