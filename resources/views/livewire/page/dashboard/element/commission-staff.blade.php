<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3>Commission Staff</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
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

                            @if(count($commission_staff) > 0)
                            @foreach ($commission_staff as $supCode => $items)
                                <tr>
                                    <th style="white-space: nowrap">{{ $this->getNameSup($supCode) }}</th>

                                    @php
                                        $monthlyTotals = array_fill(1, 12, 0); // Initialize array for 12 months
                                        $sumTotal = 0;
                                    @endphp

                                    @foreach ($items as $item)
                                        @php
                                            $monthlyTotals[$item->month] = $item->sumTotal;
                                            $sumTotal += $item->sumTotal;

                                            $overallMonthlyTotals[$item->month] += $item->sumTotal;
                                        @endphp
                                    @endforeach

                                    @foreach ($monthlyTotals as $monthTotal)
                                        <td>{{ $monthTotal > 0 ? number_format($monthTotal, 2) : '-' }}</td>
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
                        
            </div>
        </div>
    </div>
</div>