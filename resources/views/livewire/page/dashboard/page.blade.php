<div>
    <livewire:component.page-heading title_main="Dashboard" title_sub="" breadcrumb_title="Dashboard"
        breadcrumb_page="Dashboard" />

    <div class="container-fluid ecommerce-page">
        {{-- start row 1 --}}
        <div class="row">
            {{-- start invoice --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card sale-chart">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="sale-detail">
                                    <div class="icon"><i data-feather="shopping-bag"></i></div>
                                    <div class="sale-content">
                                        <h3>Invoice</h3>
                                        <p>{{ number_format($data_invoice, 2) }} </p>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="small-chart-view sales-chart" id="sales-chart"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- end invoice --}}

            {{-- start account balance --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card sale-chart">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="sale-detail">
                                    <div class="icon"><i data-feather="dollar-sign"></i></div>
                                    <div class="sale-content">
                                        <h3>Account Balance</h3>
                                        <p>{{ number_format($data_total_balance, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="small-chart-view income-chart" id="income-chart"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- end account balance --}}

            {{-- start income this month --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card sale-chart">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="sale-detail">
                                    <div class="icon"><i data-feather="file-text"></i></div>
                                    <div class="sale-content">
                                        <h3>Income this month</h3>
                                        <p>{{ number_format($data_total_income, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="small-chart-view order-chart" id="order-chart"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- end income this month --}}

            {{-- start VAT --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card sale-chart">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="sale-detail">
                                    <div class="icon"><i data-feather="users"></i></div>
                                    <div class="sale-content">
                                        <h3>VAT</h3>
                                        <p>{{ number_format($data_vat, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="small-chart-view visitor-chart" id="visitor-chart"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- end VAT --}}
        </div>
        {{-- end row 1 --}}

        {{-- start row 2 --}}
       

        <div class="row">
            <div class="col-lg-6 col-12">
                <livewire:page.dashboard.element.advance :$action/>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3>ยอดเจ้าหนี้คงค้าง</h3>
                            </div>
                            <div class="col text-end">
                                <h3>{{ number_format($sum_payment_voucher_total, 2) }}</h3>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="card-body">
                        <table class="table" data-page-size="{{ $data_payment_voucher_table->total() }}">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Supplier Name</th>
                                    <th style="white-space: nowrap">Total Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_payment_voucher_table as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payment->supplier != null ? $payment->supplier->supNameTH : '' }}</td>
                                        <td>{{ number_format($payment->sumTotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br/>
                        <div class="row">
                            <div class="col-auto">
                                {{ $data_payment_voucher_table->withQueryString()->links('layouts.themes.layout.custom-pagination-info') }}
                            </div>
                            <div class="col"> 
                                {{ $data_payment_voucher_table->withQueryString()->links('layouts.themes.layout.custom-pagination-links') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3></h3>
                            </div>
                            <div class="col text-end">
                                <h3></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3>ใบแจ้งหนี้ ค้างชำระ</h3>
                            </div>
                            <div class="col text-end">
                                <h3>{{ number_format($sum_invoice_total, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Customer Name</th>
                                    <th style="white-space: nowrap">Total Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_invoice_table->sortByDesc('sum_total_netamt') as $invoice)
                                {{-- @if(($invoice->total_netamt - $invoice->cus_paid > 0) || ($invoice->total_netamt - $invoice->cus_paid < 0)) --}}
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $invoice['custNameTH']}}</td>
                                    <td>{{ number_format($invoice['sum_total_netamt'], 2) }}</td>
                                </tr>
                                {{-- @endif --}}
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <br/>
                        <div class="row">
                            <div class="col">
                                {{ $data_invoice_table->withQueryString()->links('layouts.themes.layout.custom-pagination-info') }}
                            </div>
                            <div class="col"> 
                                {{ $data_invoice_table->withQueryString()->links('layouts.themes.layout.custom-pagination-links') }}
                            </div>
                        </div> --}}
                    </div>
                </div>
                
            </div>
        </div>
        {{-- end row 2 --}}

        {{-- start row 4 job inprocess --}}
        <div class="row" wire:ignore.self>
        <livewire:page.dashboard.element.job-inprocess :$action/>
        </div>
        {{-- end row 4 job inprocess --}}

        {{-- start row 5 ยอดภาษีมูลค่าเพิ่ม --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>ยอดภาษีมูลค่าเพิ่ม ยอดขาย ยอดซื้อ</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
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
        </div>
        {{-- end row 5 ยอดภาษีมูลค่าเพิ่ม --}}

        {{-- start row 6 ยอดถูกหักภาษี ณ ที่จ่าย  --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>ยอดถูกหักภาษี ณ ที่จ่าย </h3>
                    </div>
                    <div class="card-body">
                            <div class="row mb-3 text-end">
                                <div class="col text-end" style="margin: auto">
                                        Year   
                                </div>
                                <div class="col-3">
                                    <select class="select2_single form-control select2"  wire:model="yearTaxSearch">
                                        <option value="">- select -</option>
                                        @foreach ($yearOptions as $year)
                                        <option value="{{$year->year}}">{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" id="postYearTaxSearch" wire:click="searchYearTax">Search</button>
                                </div>
                            </div>
                        <div class="table-responsive">
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
                                    @if(count($yearTaxTotal) > 0)
                                    <tr>
                                        <th>Billing Summary</th>
                                        @foreach ($billingSummary as $bill)
                                            <td>{{ number_format($bill->value, 2) }}</td>
                                        @endforeach
                                        <th>{{ number_format($billingSummaryTotal, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Tax 3%</th>
                                        
                                        @foreach ($yearTaxTotal as $year)
                                            <td>{{ number_format($year->value2, 2) }}</td>
                                        @endforeach
                                        <th>{{ number_format($totalYearTax3, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tax 1%</th>
                                        
                                        @foreach ($yearTaxTotal as $year)
                                            <td>{{ number_format($year->value1, 2) }}</td>
                                        @endforeach
                                        <th>{{ number_format($totalYearTax1, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Profit</th>
                                        @foreach ($netProfit as $profit)
                                            <td>{{ number_format($profit->value, 2) }}</td>
                                        @endforeach
                                        <th>{{ number_format($totalYearNetProfit, 2) }}</td>
                                    </tr>
                                    
                                    @else
                                    <tr>
                                        <td colspan="13" class="text-center">Data Not Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>  
                        </div>                          
                        <br/>    
                        <div class="bar-chart-widget">
                            <div class="bar-chart-widget">
                                <div class="bottom-content card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <b>Billing Summary</b>
                                            <div id="chart-widget1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
        {{-- end row 6 ยอดถูกหักภาษี ณ ที่จ่าย  --}}

        {{-- start row 7 สรุปยอดสำรองจ่าย  --}}
        <livewire:page.dashboard.element.reserve :$action/>
        {{-- end row 7 สรุปยอดสำรองจ่าย  --}}

        {{-- <livewire:page.dashboard.elements.expense /> --}}
        <livewire:page.dashboard.element.expense :$action/>
        
        {{-- end row 8 สรุปค่าใช้จ่ายดำเนินงาน   --}}

        {{-- start row 9 commission staff   --}}
        <livewire:page.dashboard.element.commission-staff :$action/>
        {{-- end row 9 commission staff   --}}
    </div>
</div>


@push('scripts')
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
@endpush

@script
<script>
    let optionscolumnchart_yeartax = {
        series: [
            {
                name: "billing summary",
                data: [],
            }
        ],

        legend: {
            show: false,
        },
        chart: {
            type: "line",
            height: 380,
        },
        plotOptions: {
            bar: {
                radius: 10,
                horizontal: false,
                columnWidth: "55%",
                endingShape: "rounded",
            },
        },
        dataLabels: {
            enabled: true,
        },
        stroke: {
            show: true,
            colors: ["transparent"],
            curve: "smooth",
            lineCap: "butt",
        },
        grid: {
            show: false,
            padding: {
                left: 50,
                right: 20,
            },
        },
        xaxis: {
            categories: $wire.monthList
        },
        yaxis: {
            title: {
                text: " (บาท)",
            },
        },
        fill: {
            colors: [KohoAdminConfig.primary, KohoAdminConfig.secondary, "#51bb25"],
            type: "gradient",
            gradient: {
                shade: "light",
                type: "vertical",
                shadeIntensity: 0.1,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 0.9,
                stops: [0, 100],
            },
        },

        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " บาท";
                },
            },
        },
        responsive: [
            {
                breakpoint: 575,
                options: {
                    chart: {
                        height: 280,
                    },
                },
            },
        ],
    };

    let chartcolumnchart_yeartax = new ApexCharts(
        document.querySelector("#chart-widget1"),
        optionscolumnchart_yeartax
    );

    chartcolumnchart_yeartax.render();

    document.addEventListener('livewire:initialized', () => {
        chartcolumnchart_yeartax.updateOptions({
            xaxis: {
                categories: $wire.monthList
            },
            series: [
                {
                    name: "billing summary",
                    data: $wire.billingSummaryChart,
                }
            ],
        });
    })

    $('#postYearTaxSearch').click(function() {
        console.log('postYearTaxSearch');
        setTimeout(() => {
            chartcolumnchart_yeartax.updateOptions({
                xaxis: {
                    categories: $wire.monthList
                },
                series: [
                    {
                        name: "billing summary",
                        data: $wire.billingSummaryChart,
                    }
                ],
            });
        }, 7500);
        // console.log('postYearTaxSearch', $wire.billingSummaryChart);
    })
</script>

@endscript