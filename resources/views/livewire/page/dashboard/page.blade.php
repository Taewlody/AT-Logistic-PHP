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
    </div>
</div>