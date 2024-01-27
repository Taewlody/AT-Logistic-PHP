@extends('layout.master')

@section('main-content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Switch</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Form Widgets</li>
                        <li class="breadcrumb-item active">Switch</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Basic Switch</h3>
                    </div>
                    <div class="card-body row switch-showcase height-equal">
                        <div class="col-sm-">
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Bootstrap Switch</label>
                                <div class="flex-grow-1 text-end">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Bootstrap Disabled</label>
                                <div class="flex-grow-1 text-end">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDisabled" type="checkbox"
                                            disabled="">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Default Switch</label>
                                <div class="flex-grow-1 text-end">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Unhecked Switch</label>
                                <div class="flex-grow-1 text-end">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">With Icon</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Unhecked With Icon</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Disabled State</label>
                                <div class="flex-grow-1 text-end">
                                    <label class="switch">
                                        <input type="checkbox" disabled=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="col-form-label m-r-10">Disabled With Icon</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" disabled=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Switch Color</h3>
                    </div>
                    <div class="card-body row switch-showcase height-equal">
                        <div class="col-sm-12">
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Bootstrap Switch</label>
                                <div class="flex-grow-1 text-end">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox"
                                            data-onstyle="secondary" checked="">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Disabled checked</label>
                                <div class="flex-grow-1 text-end">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckCheckedDisabled" type="checkbox"
                                            checked="" disabled="">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Primary Color</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Secondary Color</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-secondary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Success Color</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-success"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Info Color</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state bg-info"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Warning Color</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-warning"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="col-form-label m-r-10">Danger Color</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-danger"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Switch Outline</h3>
                    </div>
                    <div class="card-body row switch-showcase">
                        <div class="col-sm-12">
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Primary Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Secondary Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-secondary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Success Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-success"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Info Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state bg-info"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Warning Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-warning"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="col-form-label m-r-10">Danger Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-danger"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Switch unchecked Outline</h3>
                    </div>
                    <div class="card-body row switch-showcase">
                        <div class="col-sm-12">
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Primary Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Secondary Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state bg-secondary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Success Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state bg-success"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Info Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state bg-info"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Warning Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state bg-warning"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="col-form-label m-r-10">Danger Color</label>
                                <div class="flex-grow-1 text-end icon-state switch-outline">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state bg-danger"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Switch Sizing</h3>
                    </div>
                    <div class="card-body row switch-showcase">
                        <div class="col-sm-12">
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Large Size</label>
                                <div class="flex-grow-1 text-end switch-lg">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Large Unhecked</label>
                                <div class="flex-grow-1 text-end switch-lg">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Normal Size</label>
                                <div class="flex-grow-1 text-end">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Normal Unhecked</label>
                                <div class="flex-grow-1 text-end">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Small Size</label>
                                <div class="flex-grow-1 text-end switch-sm">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="col-form-label m-r-10">Small Size Unhecked</label>
                                <div class="flex-grow-1 text-end switch-sm">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Switch With icon</h3>
                    </div>
                    <div class="card-body row switch-showcase">
                        <div class="col-sm-12">
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Large Size</label>
                                <div class="flex-grow-1 text-end switch-lg icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Large Unhecked</label>
                                <div class="flex-grow-1 text-end switch-lg icon-state">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Normal Size</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Normal Unhecked</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Small Size</label>
                                <div class="flex-grow-1 text-end switch-sm icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="col-form-label m-r-10">Small Size Unhecked</label>
                                <div class="flex-grow-1 text-end switch-sm icon-state">
                                    <label class="switch">
                                        <input type="checkbox"><span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Switch With color</h3>
                    </div>
                    <div class="card-body row switch-showcase">
                        <div class="col-sm-12">
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Primary Color (Disabled)</label>
                                <div class="flex-grow-1 text-end switch-lg icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked="" disabled=""><span
                                            class="switch-state bg-primary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Secondary Color</label>
                                <div class="flex-grow-1 text-end switch-lg icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-secondary"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Success Color</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-success"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Info Color</label>
                                <div class="flex-grow-1 text-end icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span class="switch-state bg-info"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <label class="col-form-label m-r-10">Warning Color</label>
                                <div class="flex-grow-1 text-end switch-sm icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-warning"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="col-form-label m-r-10">Danger Color</label>
                                <div class="flex-grow-1 text-end switch-sm icon-state">
                                    <label class="switch">
                                        <input type="checkbox" checked=""><span
                                            class="switch-state bg-danger"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
