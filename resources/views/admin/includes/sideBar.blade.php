<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img src="{{ url(\Settings::get('application_logo')) }}" alt="image" class="rounded-circle" height="60px" width="60px" style="border-radius:20%!important">

                    <ul class="dropdown-menu animated fadeInLeft m-t-xs">
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
        <img alt="image" class="rounded-circle" height="60px" width="60px" style="border-radius:20%!important" src="{{ url(\Settings::get('application_logo')) }}">
                </div>
            </li>
            <li class="@if(Request::segment('2') == 'dashboard') active @endif">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span class="nav-label">
                        Dashboard
                    </span>
                </a>
            </li>

            <li class="@if(Request::segment('2') == 'transaction') active @endif">
                <a href="{{ route('admin.transaction.index') }}">
                    <i class="fa fa-exchange" data-toggle="tooltip" title="Transaction Management"></i>
                    <span class="nav-label">Transaction </span>
                </a>
            </li>

            <li class="@if(Request::segment('2') == 'currency') active @endif">
                <a href="{{ route('admin.currency.index') }}">
                    <i class="fa fa-money" data-toggle="tooltip" title="Currency Management"></i>
                    <span class="nav-label">Currency </span>
                </a>
            </li>

            <li class="@if(Request::segment('2') == 'country') active @endif">
                <a href="{{ route('admin.country.index') }}">
                    <i class="fa fa-flag" data-toggle="tooltip" title="Country Management"></i>
                    <span class="nav-label">Country </span>
                </a>
            </li>

            <li class="@if(Request::segment('2') == 'companies') active @endif">
                <a href="{{ route('admin.companies.index') }}">
                    <i class="fa fa-building-o" data-toggle="tooltip" title="Country Management"></i>
                    <span class="nav-label">Companies </span>
                </a>
            </li>

            <li class="@if(Request::segment('2') == 'bank') active @endif" data-toggle="tooltip" title="Bank">
                <a href="{{ route('admin.bank.index') }}">
                    <i class="fa fa-university"></i>
                    <span class="nav-label">Bank </span>
                </a>
            </li>

            <li class="@if(Request::segment('2') == 'clients') active @endif">
                <a href="{{ route('admin.clients.index_clients') }}">
                    <i class="fa fa-users" data-toggle="tooltip" title="Country Management"></i>
                    <span class="nav-label">Clients </span>
                </a>
            </li>

            <li class="@if(Request::segment('2') == 'category' || Request::segment('2') == 'subcategory') active @endif">
                <a href="#">
                    <i class="fa fa-list-alt" data-toggle="tooltip" title="Category Management"></i>
                    <span class="nav-label">Category</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li class="@if(Request::segment('2') == 'category') active @endif"><a href="{{ route('admin.category.index') }}">Category</a></li>
                    <li class="@if(Request::segment('2') == 'subcategory') active @endif"><a href="{{ route('admin.subcategory.index') }}">Sub Category</a></li>
                </ul>
            </li>
            <li class="@if(Request::segment('2') == 'inwardtype' || Request::segment('2') == 'outwardtype' || Request::segment('2') == 'othertype') active @endif">
                <a href="#">
                    <i class="fa fa-tag" data-toggle="tooltip" title="Category Management"></i>
                    <span class="nav-label">Type</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li class="@if(Request::segment('2') == 'inwardtype') active @endif"><a href="{{ route('admin.type.inwardtype') }}">InWard Type</a></li>
                    <li class="@if(Request::segment('2') == 'outwardtype') active @endif"><a href="{{ route('admin.type.outwardtype') }}">OutWard Type</a></li>
                    <li class="@if(Request::segment('2') == 'othertype') active @endif"><a href="{{ route('admin.type.othertype') }}">Other Type</a></li>
                </ul>
            </li>
            <!-- <li class="@if(Request::segment('2') == 'paymenttype') active @endif">
                <a href="{{ route('admin.paymenttype.index') }}">
                    <i class="fa fa-credit-card"></i>
                    <span class="nav-label">Payment Type </span>
                </a>
            </li> -->
            <li class="@if(Request::segment('2') == 'report') active @endif">
                <a href="{{ route('admin.report.index') }}">
                    <i class="fa fa-file"></i>
                    <span class="nav-label">Report </span>
                </a>
            </li>
           <li class="@if(Request::segment('2') == 'settings') active @endif">
                <a href="{{ url('admin/settings') }}" data-toggle="tooltip" title="Settings">
                    <i class="fa fa-cogs"></i>
                    <span class="nav-label">Settings</span>
                </a>
            </li>
            
        </ul>
    </div>
</nav>

