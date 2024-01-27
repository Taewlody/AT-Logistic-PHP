@extends('theme.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
@endsection


@section('main-content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Default Dashboard</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Default </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid default-page">
        <div class="row">
            <div class="col-xl-5 col-lg-5">
                <div class="card profile-greeting">
                    <div class="card-body">
                        <div>
                            <h1>Welcome,William</h1>
                            <p> You have completed 40% of your this week! Start a new goal & improve your result</p><a
                                class="btn" href="{{ route('user-profile') }}">Continue<i data-feather="arrow-right"></i></a>
                        </div>
                        <div class="greeting-img"><img class="img-fluid"
                                src="{{ asset('assets/images/dashboard/profile-greeting/bg.png') }}" alt=""></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-lg-3">
                <div class="card yearly-view">
                    <div class="card-header pb-0">
                        <h3>Yearly Overview<span class="badge badge-primary">50/100</span></h3>
                        <h5 class="mb-0">Monday</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="yearly-view" id="yearly-view"></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/chart/knob/knob.min.js') }}"></script>
<script src="{{ asset('assets/js/chart/knob/knob-chart.js') }}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"> </script>
<script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
<script src="{{ asset('assets/js/notify/index.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
@endsection
