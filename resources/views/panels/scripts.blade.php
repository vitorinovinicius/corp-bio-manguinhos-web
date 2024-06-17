
    <!-- BEGIN: Vendor JS-->
    <script>
        var assetBaseUrl = "{{ asset('') }}";
    </script>
    <script src="{{asset('vendors/js/vendors.min.js')}}"></script>
    <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.tools.js')}}"></script>
    <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.defaults.js')}}"></script>
    <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @yield('vendor-scripts')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    @if($configData['mainLayoutType'] == 'vertical-menu')
    <script src="{{asset('js/scripts/configs/vertical-menu-light.js')}}"></script>
    @else
    <script src="{{asset('js/scripts/configs/horizontal-menu.js')}}"></script>
    @endif
    <script src="{{asset('js/core/app-menu.js')}}"></script>
    <script src="{{asset('js/core/app.js')}}"></script>
    <script src="{{asset('js/scripts/components.js')}}"></script>
    <script src="{{asset('js/scripts/footer.js')}}"></script>
    <script src="{{asset('js/scripts/customizer.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2-11/src/sweetalert2.all.min.js') }}"></script>
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script src="{{asset('assets/plugins/smartwizard/dist/js/jquery.smartWizard.min.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    @yield('page-scripts')
    <!-- END: Page JS-->
    <!-- REQUIRED JS SCRIPTS -->
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            $(".layout-name").on("click", function () {
                var $this = $(this);
                var currentLayout = $this.data("layout");

                let colorTheme = null;

                if (currentLayout === "") {
                    colorTheme = 1;
                }

                if (currentLayout === "dark-layout") {
                    colorTheme = 2;
                }

                if (currentLayout === "semi-dark-layout") {
                    colorTheme = 3;
                }

                if(colorTheme != null) {
                    changeColorUser(colorTheme);
                }
            });

            function changeColorUser(colorTheme) {
                $.ajax({
                    headers:{'X-CSRF-Token': '{{ csrf_token() }}'},
                    type: 'PUT',
                    url: '{{route("users.themeColor")}}',
                    data: {color: colorTheme},
                    success: function (data) {
                        console.log("Theme alterado com sucesso!");
                    },
                    error: function () {
                        console.log("Erro ao alterar o Theme");
                    },
                });
            }
        });

    </script>
