@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Resetar sua Senha')
{{-- page scripts --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
    <!-- reset password start -->
    <section class="row flexbox-container">
        <div class="col-xl-7 col-10">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- left section-login -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right d-flex justify-content-center mb-0 p-2 h-100">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="text-center mb-2">Resetar sua senha</h4>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="mb-2" method="POST" action="{{ url('/password/email') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <label class="text-bold-600" for="exampleInputPassword1">Endereço de e-mail</label>
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Endereço de e-mail" required autofocus>
                                        </div>
                                        <button type="submit" class="btn btn-primary glow position-relative w-100">Enviar link por email<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <img class="img-fluid" src="{{asset('images/pages/forgot-password.png')}}" alt="branding logo">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- reset password ends -->
@endsection
