<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Central System {{env('APP_ENV')}} @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/admin.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
@yield('css')
<!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css')}}">
{{--    <link rel="stylesheet" href="{{ url('/css/skins/skin-red.min.css') }}">--}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123048358-1"></script>
    <script nonce="{{ csp_nonce() }}">
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-123048358-1');
    </script>
</head>

    <body id="menu-principal" class="hold-transition skin-blue ">
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('content')
        </section>
            <!-- /.content -->

        <!-- Main Footer -->
        <footer style="margin: 30px">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                Central System
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{ date("Y")  }} <a href="http://centralsystem.com.br" target="_blank">Central System</a>.</strong> Todos os direitos reservados.
        </footer>

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.2.3 -->
        <script src="{{ url('/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ url('/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ url('/bower_components/AdminLTE/dist/js/app.min.js') }}"></script>
        {{--JQUERY COOKIE--}}
        <script src="{{ url('/js/js.cookie.js') }}"></script>
        @yield('scripts2')
        @yield('scripts')
        <script type="text/javascript" nonce="{{ csp_nonce() }}">
            $(document).on("click", ".sidebar-toggle", function (e) {
                e.preventDefault();
                if ($("#menu-principal").hasClass("sidebar-collapse")) {
                    Cookies.remove("menu");
                } else {
                    Cookies.set("menu", "collapsed");
                }
            });
        </script>
        </body>
</html>
