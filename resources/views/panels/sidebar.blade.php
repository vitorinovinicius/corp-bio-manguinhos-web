{{-- vertical-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu')
<div class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{asset('/')}}">
                <div class="brand-logo">
                {{--<img src="{{asset('images/logo/logo.png')}}" class="logo" alt="">--}}
                </div>
                <h2 class="brand-text mb-0">
                @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
                {{$configData['templateTitle']}}
                @else
                Bio-Manguinhos
                @endif
                </h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                <i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i>
                <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
            
            @is(['superuser', 'admin'])
            <li class="nav-item @if(app('router')->is("admin.index")){{"active"}}@endif">
                <a href="#">
                    <i class="menu-livicon" data-icon="box"></i>
                    <span class="menu-title">Relatórios</span>
                </a>
                <ul class="menu-content"> 
                    <li class="{{(app('router')->is("admin.index"))? "active": ""}}">
                        <a href="{{route("admin.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Todos</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endis
            
            @is(['superuser', 'admin'])
            <li class="nav-item @if(app('router')->is("emails.*")){{"active"}}@endif">
                <a href="#">
                    <i class="menu-livicon" data-icon="envelope-pull"></i>
                    <span class="menu-title">E-mail</span>
                </a>
                <ul class="menu-content"> 
                    <li class="{{(app('router')->is("emails.todos"))? "active": ""}}">
                        <a href="{{route("emails.todos")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Todos</span>
                        </a>
                    </li>
                    <li class="{{(app('router')->is("emails.envio"))? "active": ""}}">
                        <a href="{{route("emails.envio")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Enviados</span>
                        </a>
                    </li>
                    <li class="{{(app('router')->is("emails.confirma"))? "active": ""}}">
                        <a href="{{route("emails.confirma")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Confirmados</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endis
            <li class="nav-item">
                <a href="#">
                    <i class="menu-livicon" data-icon="briefcase"></i>
                    <span class="menu-title">Formulários</span>
                </a>
                <ul class="menu-content">
                    <li class="{{(app('router')->is("forms.*"))? "active": ""}}">
                        <a href="{{route("forms.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Todos</span>
                        </a>
                    </li>
                </ul>
            </li>
            @is('superuser')
            <li class="nav-item
                @if(
                    app('router')->is("configurations*")
                    OR app('router')->is("contractor_occurrence_types*")
                    OR app('router')->is("permissions*")
                    OR app('router')->is("roles*")
                    OR app('router')->is("occurrence_type_forms*")
                    OR app('router')->is("sms*")
                    OR app('router')->is("log_locals*")

                    OR app('router')->is("configuration*")
                    OR app('router')->is("plans*")
                    OR app('router')->is("districts*")
                    OR app('router')->is("contractor_districts*")
                    OR app('router')->is("contractors*")
                    OR app('router')->is("finish_work_days*")
                    OR app('router')->is("equipments*")

                    )
            {{"active"}}
            @endif ">
                <a href="#">
                    <i class="menu-livicon" data-icon="gears"></i>
                    <span class="menu-title">Configurações</span>
                </a>

                <ul class="menu-content">
                    @shield('users.index')
                    <li class="{{(app('router')->is("users*"))? "active": ""}}">
                        <a href="{{route("users.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Usuários</span>
                        </a>
                    </li>
                    @endshield
                    <li class="{{(app('router')->is("teams*"))? "active": ""}}">
                        <a href="{{route("teams.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Setores</span>
                        </a>
                    </li>
                    <li class="{{(app('router')->is("permissions*"))? "active": ""}}">
                        <a href="{{route("permissions.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Permissões</span>
                        </a>
                    </li>
                    <li class="{{(app('router')->is("roles*"))? "active": ""}}">
                        <a href="{{route("roles.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Perfil (regras)</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endis
            <li class="nav-item">
                <a href="{{ url('/logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="menu-livicon" data-icon="external-link"></i>
                    <span class="menu-title">Sair</span>
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</div>
@endif
{{-- horizontal-menu --}}
@if($configData['mainLayoutType'] == 'horizontal-menu')
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-light navbar-without-dd-arrow
@if($configData['navbarType'] === 'navbar-static') {{'navbar-sticky'}} @endif" role="navigation" data-menu="menu-wrapper">
<div class="navbar-header d-xl-none d-block">
    <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto">
            <a class="navbar-brand" href="{{asset('/')}}">
                <div class="brand-logo">
                <img src="{{asset('images/logo/logo.png')}}" class="logo" alt="">
                </div>
                <h2 class="brand-text mb-0">
                    @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
                    {{$configData['templateTitle']}}
                    @else
                    Bio-Manguinhos
                    @endif
                </h2>
            </a>
        </li>
        <li class="nav-item nav-toggle">
            <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                <i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
            </a>
        </li>
    </ul>
</div>
<div class="shadow-bottom"></div>
<!-- Horizontal menu content-->
<div class="navbar-container main-menu-content" data-menu="menu-container">
    <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
    @if(!empty($menuData[1]) && isset($menuData[1]))
        @foreach ($menuData[1]->menu as $menu)
            <li class="@if(isset($menu->submenu)){{'dropdown'}} @endif nav-item" data-menu="dropdown">
                <a class="@if(isset($menu->submenu)){{'dropdown-toggle'}} @endif nav-link" href="{{asset($menu->url)}}"
                    @if(isset($menu->submenu)){{'data-toggle=dropdown'}} @endif @if(isset($menu->newTab)){{"target=_blank"}}@endif>
                        <i class="menu-livicon" data-icon="{{$menu->icon}}"></i>
                    <span>{{ __('locale.'.$menu->name)}}</span>
                </a>
                @if(isset($menu->submenu))
                    @include('panels.sidebar-submenu',['menu'=>$menu->submenu])
                @endif
            </li>
        @endforeach
    @endif
    </ul>
</div>
<!-- /horizontal menu content-->
</div>
@endif

{{-- vertical-box-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu-boxicons')
<div class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto">
            <a class="navbar-brand" href="{{asset('/')}}">
                <div class="brand-logo">
                <img src="{{asset('images/logo/logo.png')}}" class="logo" alt="">
                </div>
                <h2 class="brand-text mb-0">
                @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
                {{$configData['templateTitle']}}
                @else
                Bio-Manguinhos
                @endif
                </h2>
            </a>
        </li>
        <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i></a></li>
    </ul>
</div>
<div class="shadow-bottom"></div>
<div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
        @if(!empty($menuData[2]) && isset($menuData[2]))
        @foreach ($menuData[2]->menu as $menu)
            @if(isset($menu->navheader))
                <li class="navigation-header"><span>{{$menu->navheader}}</span></li>
            @else
            <li class="nav-item {{(request()->is($menu->url.'*')) ? 'active' : '' }}">
                <a href="@if(isset($menu->url)){{asset($menu->url)}} @endif" @if(isset($menu->newTab)){{"target=_blank"}}@endif>
                    @if(isset($menu->icon))
                        <i class="{{$menu->icon}}"></i>
                    @endif
                    @if(isset($menu->name))
                        <span class="menu-title">{{ __('locale.'.$menu->name)}}</span>
                    @endif
                    @if(isset($menu->tag))
                        <span class="{{$menu->tagcustom}}">{{$menu->tag}}</span>
                    @endif
                </a>
                @if(isset($menu->submenu))
                    @include('panels.sidebar-submenu',['menu' => $menu->submenu])
                @endif
            </li>
            @endif
        @endforeach
        @endif
    </ul>
</div>
</div>
@endif
