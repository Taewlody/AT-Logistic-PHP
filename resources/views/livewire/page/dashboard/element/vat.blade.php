<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3>ยอดภาษีมูลค่าเพิ่ม ยอดขาย ยอดซื้อ</h3>
        </div>
        <div class="card-body">
            <div class="card-body">
                <div class="row mb-3 text-end">
                    <div class="col text-end" style="margin: auto">
                            Year   
                    </div>
                    <div class="col-3">
                        <select class="select2_single form-control select2"  wire:model="yearSearch">
                            <option value="">- select -</option>
                            @foreach ($yearOptions as $year)
                            <option value="{{$year->year}}">{{$year->year}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary" wire:click="searchYearVatPayment">Search</button>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach (EngDate::full_month_list() as $month)
                            <th>{{$month}}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($yearVatTotal) > 0)
                        <tr>
                            <th>ภาษีซื้อ</th>
                            @foreach ($monthVatBuy as $buy)
                                <td>{{ number_format($buy, 2) }}</td>
                            @endforeach
                            <th>{{ number_format($totalMonthVatBuy, 2) }}</th>
                        </tr>
                        <tr>
                            <th>ภาษีขาย</th>
                            
                            @foreach ($monthVatSale as $sale)
                                <td>{{ number_format($sale, 2) }}</td>
                            @endforeach
                            <th>{{ number_format($totalMonthVatSale, 2) }}</th>
                        </tr>
                        <tr>
                            <th>ส่วนต่าง</th>
                            @foreach ($monthVatDifferent as $dif)
                                <td>{{ number_format($dif, 2) }}</td>
                            @endforeach
                            <th>{{ number_format($totalVatDifferent, 2) }}</th>
                        </tr>
                        
                        @else
                        <tr>
                            <td colspan="13" class="text-center">Data Not Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table> 
            </div>
                    
        </div>
    </div>
</div>