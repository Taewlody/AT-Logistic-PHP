<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>{{$title_main}} @if ($title_sub != "") / {{$title_sub}} @endif</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">{{$breadcrumb_title}}</li>
                    <li class="breadcrumb-item active">{{$breadcrumb_page}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
