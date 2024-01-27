@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jsgrid.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>JS Grid Tables</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Tables</li>
                        <li class="breadcrumb-item active"> JS Grid Tables</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3 class="mb-3">Basic Scenario</h3><span>Grid with filtering, editing, inserting, deleting,
                            sorting and paging. Data provided by controller.</span>
                    </div>
                    <div class="card-body">
                        <div class="basic_table" id="basicScenario"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3 class="mb-3">Sorting Scenario</h3><span>Sorting can be done not only with column header
                            interaction, but also with sort method.</span>
                    </div>
                    <div class="card-body">
                        <div class="sort-panel mb-3">
                            <label>Sorting Field:
                                <select class="btn btn-primary dropdown-toggle btn-md pe-5" id="sortingField">
                                    <option>Id</option>
                                    <option>Product</option>
                                    <option>Order Id</option>
                                    <option>Price</option>
                                    <option>Quantity</option>
                                    <option>Shipped</option>
                                    <option>Total</option>
                                </select>
                            </label>
                            <div class="d-inline">
                                <button class="btn btn-md btn-secondary" id="sort" type="button">Sort</button>
                            </div>
                        </div>
                        <div class="js-shorting" id="sorting-table"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3 class="mb-3">Batch Delete</h3><span>Cell content of every column can be customized with
                            itemTemplate, headerTemplate, filterTemplate and insertTemplate functions specified in field
                            config. This example shows how to implement batch deleting with custom field for selecting
                            items.</span>
                    </div>
                    <div class="card-body">
                        <div id="batchDelete"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jsgrid/jsgrid.min.js') }}"></script>
    <script src="{{ asset('assets/js/jsgrid/griddata.js') }}"></script>
    <script src="{{ asset('assets/js/jsgrid/jsgrid.js') }}"></script>
@endsection
