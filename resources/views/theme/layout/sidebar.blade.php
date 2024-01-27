<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logoNew.jpg') }}" alt="" style="width: 96px; height: 35px;"><img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logoNew.jpg') }}" alt="" tyle="width: 96px; height: 35px;"></a>
                    <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-left"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo-icon-dark.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""><img
                                class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-icon-dark.png') }}"
                                alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    
                    <li class="sidebar-list"> <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i
                                data-feather="home"></i><span class="lan-3">Dashboard</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="lan-4" href="{{ route('dashboard') }}">Dashboard</a></li>
                        </ul>
                    </li>
                    
                    
                </ul>
                
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
