@extends('theme.others.layout_others.master')

@section('others-content')
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div><a class="logo" href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                                    src="{{ asset('assets/images/logoNew.jpg') }}" alt="logo image"></a></div>
                        <div class="login-main">
                            <form class="theme-form" id="m-t" name="form1" role="form"  autocomplete="off" method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <h2 class="text-center">Logistic Management System
                                </h2>
                                <p class="text-center">Login in. To see it in action.</p>
                                <div class="form-group">
                                    <label class="col-form-label">Username</label>
                                    <input type="text" class="form-control" placeholder="Username" autocomplete="off" id="username" name="username" required=true>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input type="password" class="form-control" placeholder="Password"  autocomplete="new-password" id="password" name="password" required=true>
                                        
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" name="btnSubmit" type="submit">Sign in </button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
