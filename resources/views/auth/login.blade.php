@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Bem-vindo')
{{-- page scripts --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
@endsection

@section('content')
    <!-- login page start -->
    <section id="auth-login" class="row flexbox-container">
        <div class="col-xl-8 col-11">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- left section-login -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <p class="text-center">
                                        <img class="img-fluid w-50" src="{{asset('images/logo-fiocruz.png')}}" alt="branding logo">
                                    </p>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form method="POST" action="{{ url('/login') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group mb-50 {{ $errors->has('email') ? ' error' : '' }}">
                                            <label class="text-bold-600" for="exampleInputEmail1">E-mail</label>
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

                                        </div>
                                        <div class="form-group {{ $errors->has('password') ? ' error' : '' }}">
                                            <label class="text-bold-600" for="exampleInputPassword1">Senha</label>
                                            <input id="password" type="password" class="form-control" name="password" placeholder="Senha" required>
                                        </div>
                                        <div class="form-group">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                            <div class="text-left">
                                                <div class="checkbox checkbox-sm">
                                                    <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                                                    <label class="checkboxsmall" for="exampleCheck1">
                                                        <small>Lembrar de mim</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <a href="{{ url('/password/reset') }}" class="card-link"><small>Esqueceu a senha?</small></a>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary glow w-100 position-relative">Entrar
                                            <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <div class="card-content">
                            <img class="img-fluid" src="{{asset('images/pages/login.png')}}" alt="branding logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login page ends -->
@endsection
