<div>
    <livewire:component.page-heading title_main="Dashboard" title_sub="" breadcrumb_title="Dashboard"
        breadcrumb_page="Dashboard" />

    <div class="container-fluid ecommerce-page">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card sale-chart">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="sale-detail">
                                    <div class="icon"><i data-feather="shopping-bag"></i></div>
                                    <div class="sale-content">
                                        <h3>Invoice</h3>
                                        <p>{{ number_format($data_invoice) }} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="small-chart-view sales-chart" id="sales-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card sale-chart">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="sale-detail">
                                    <div class="icon"><i data-feather="dollar-sign"></i></div>
                                    <div class="sale-content">
                                        <h3>Account<br/> Balance</h3>
                                        <p>{{ number_format($data_total_balance) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="small-chart-view income-chart" id="income-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card sale-chart">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="sale-detail">
                                    <div class="icon"><i data-feather="file-text"></i></div>
                                    <div class="sale-content">
                                        <h3>Income<br/> this month</h3>
                                        <p>{{ number_format($data_total_income) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="small-chart-view order-chart" id="order-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card sale-chart">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="sale-detail">
                                    <div class="icon"><i data-feather="users"></i></div>
                                    <div class="sale-content">
                                        <h3>VAT</h3>
                                        <p>{{ number_format($data_vat) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="small-chart-view visitor-chart" id="visitor-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Advance Payment</h3>
                    </div>
                    <div class="card-body">
                        <table class="table" data-page-size="{{ $data_advance_pyment_table->total() }}">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Customer Name</th>
                                    <th>Total Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_advance_pyment_table as $advance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $advance->customer != null ? $advance->customer->custNameTH : '' }}</td>
                                        <td>{{ $advance->sumTotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3>ใบแจ้งหนี้ ค้างชำระ</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Customer Name</th>
                                    <th>Total Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Job Inprocess</h3>
                    </div>
                    <div class="card-body">
                        <table class="table" data-page-size="{{ $data_job_inprocess->total() }}">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Job No.</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Port</th>
                                    <th>Sales</th>
                                    <th>Time period (Day)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_job_inprocess as $job)
                                <tr>
                                    <td>{{ $loop->iteration + (($data_job_inprocess->currentPage() - 1) * $data_job_inprocess->perPage()) }}</td>
                                    <td>{{ $job->documentID }}</td>
                                    <td>{{ $job->documentDate }}</td>
                                    <td>{{ $job->customerRefer != null ? $job->customerRefer->custNameEN : '' }}</td>
                                    <td>{{ $job->landingPort != null ? $job->landingPort->portNameEN : '' }}</td>
                                    <td>{{ $job->salemanRefer != null ? $job->salemanRefer->empName : '' }}</td>
                                    <td class="text-center">
                                        {{ (new DateTime($job->documentDate))->diff(new DateTime('now'))->format("%r%a")}}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('job-order.form', ['action' => 'view', 'id' => $job->documentID]) }}" wire:navigate>
                                            <i class="fa fa-search text-primary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br/>
                        <div class="row">
                            <div class="col-4">
                                {{ $data_job_inprocess->withQueryString()->links('layouts.themes.layout.custom-pagination-info') }}
                            </div>
                            <div class="col-8"> 
                                {{ $data_job_inprocess->withQueryString()->links('layouts.themes.layout.custom-pagination-links') }}
                            </div>
                        </div>
                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>