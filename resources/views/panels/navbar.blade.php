{{-- navabar  --}}
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu
@if(isset($configData['navbarType'])){{$configData['navbarClass']}} @endif"
     data-bgcolor="@if(isset($configData['navbarBgColor'])){{$configData['navbarBgColor']}}@endif">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon bx bx-menu"></i></a></li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">

                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-color-fill"></i></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="scrollable-container media-list">
                                <div class="d-flex justify-content-between read-notification cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-body">
                                            <div class="theme-layouts">
                                                <div class="d-flex justify-content-center">
                                                    <div class="mx-50">
                                                        <fieldset>
                                                            <div class="radio">
                                                                <input type="radio" name="layoutOptions" value="false" id="radio-light" class="layout-name" data-layout="" @if(Auth::user()->theme == 1) checked="" @endif>
                                                                <label for="radio-light">Light</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="mx-50">
                                                        <fieldset>
                                                            <div class="radio">
                                                                <input type="radio" name="layoutOptions" value="false" id="radio-dark" class="layout-name" data-layout="dark-layout" @if(Auth::user()->theme == 2) checked="" @endif>
                                                                <label for="radio-dark">Dark</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="mx-50">
                                                        <fieldset>
                                                            <div class="radio">
                                                                <input type="radio" name="layoutOptions" value="false" id="radio-semi-dark" class="layout-name" data-layout="semi-dark-layout" @if(Auth::user()->theme == 3) checked="" @endif>
                                                                <label for="radio-semi-dark">Semi Dark</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name">{{Auth::user()->name}}</span>
                                <span class="user-status text-muted">Online</span>
                            </div>
                            <span><img class="round" src="{{ asset('/css/images/avatar1.png') }}" alt="avatar"
                                       height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form2').submit();"><i
                                    class="bx bx-power-off mr-50"></i>Logout</a>

                            <form id="logout-form2" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

