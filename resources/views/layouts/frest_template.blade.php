<!DOCTYPE html>
<!--
Template Name: Frest HTML Admin Template
Author: :Pixinvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/pixinvent_portfolio
Renew Support: https://1.envato.market/pixinvent_portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->
{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration  --}}
@isset($pageConfigs)
    {!! \App\Helpers\TemplateHelper::updatePageConfig($pageConfigs) !!}
@endisset
@php
    // confiData variable layoutClasses array in Helper.php file.
      $configData = \App\Helpers\TemplateHelper::applClasses();
@endphp

<html class="loading" lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
      data-textdirection="{{$configData['direction'] == 'rtl' ? 'rtl' : 'ltr' }}">
<!-- BEGIN: Head-->

<head>
    <meta  charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bio-Manguinhos {{env('APP_ENV')}} @yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/contractor/1/logo.png')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/sweetalert2-11/src/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/smartwizard/dist/css/smart_wizard.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/smartwizard/dist/css/smart_wizard_dots.min.css')}}">

    {{-- Include core + vendor Styles --}}
    @include('panels.styles')

    @yield('css')
</head>
<!-- END: Head-->

@if(!empty($configData['mainLayoutType']) && isset($configData['mainLayoutType']))
    @include(($configData['mainLayoutType'] === 'horizontal-menu') ? 'layouts.frest_template_horizontal':'layouts.frest_template_vertical')
@else
    {{-- if mainLaoutType is empty or not set then its print below line --}}
    <h1>{{'mainLayoutType Option is empty in config custom.php file.'}}</h1>
@endif

</html>
