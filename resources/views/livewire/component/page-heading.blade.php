<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>{{$title_main}}  @if ($title_sub != "") / {{$title_sub}} @endif</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"> <a>{{$breadcrumb_main}}</a></li>
                    <li class="breadcrumb-item"> <a>{{$breadcrumb_title}}</a></li>
                    <li class="breadcrumb-item"> <a>{{$breadcrumb_page}}</a> </li>
                    @if ($breadcrumb_page_title != "")
                        <li class="breadcrumb-item"> <a>{{$breadcrumb_page_title}}</a> </li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>