<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

 
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900" rel="stylesheet">
    
    <!--Icons-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!--bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />

    <!--custom style-->
    <link href="{{ asset('css/style.css?v=0.02') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">

    <!--select2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!--bootstrap select-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet">
    
    <!--date range picker-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    <!--draggable table-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!--bootstrap taginput-->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTfEzf1y6XJjR0Qn2/C7M+Z8v/gB3T6tK+k1t4g+D6t8T6+K+w8/z+k+D6t8T6+K+w8/z+k=" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-tagsinput.css') }}">
    
    <!--tel input-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.15.0/build/css/intlTelInput.css">


    <style>
        /* Hide the +91 text, keep only the flag */
        .iti__selected-dial-code {
            display: none !important;
        }
        
        /* Fix spacing so input aligns properly */
        .iti--separate-dial-code .iti__selected-flag {
            padding-right: 10px;
        }
    </style>
    
    @yield('css')
    
</head>
<body>
    @yield('content')
    
    
    <!-- jQuery FIRST -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>

    <!-- Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    

    <!-- intl-tel-input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
    
    
    
    <!--bootstrap select-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    
    <!--dragable table-->
    <script src="https://cdn.jsdelivr.net/npm/tablednd@1.0.5/dist/jquery.tablednd.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js"></script>
    

    <!--bootstrap taginput-->
    <!--<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-i2pZ0bQ/rN8eM4a/C8W/H/Q7/g+w8/z+k+D6t8T6+K+w8/z+k+D6t8T6+K+w8/z+k=" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
    <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>

    <!-- Common -->
    <script src="{{ asset('js/common.js') }}"></script>
    
    <!--tel input-->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.15.0/build/js/intlTelInput.min.js"></script>

    <script>
    $(function() {
        $('.daterange').each(function() {
            $(this).daterangepicker({
                opens: 'right',
                autoUpdateInput: false, // input empty until user selects
                locale: {
                    format: 'YYYY-MM-DD', // Y-m-d style
                    cancelLabel: 'Clear'
                }
            });
    
            // When user applies selection
            $(this).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(
                    picker.startDate.format('YYYY-MM-DD') + ' - ' +
                    picker.endDate.format('YYYY-MM-DD')
                );
            });
    
            // When user cancels selection
            $(this).on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    });


    // $(function () {
    //   $('#daterange').daterangepicker({
    //     singleDatePicker: true,
    //     showDropdowns: true,
    //     autoApply: true,
    //     startDate: moment(),
    //     locale: {
    //       format: 'DD/MM/YYYY'
    //     }
    //   });
    // });
    
    $(document).ready(function(){
        
        $('.add-stop-btn').click(function(){
            $('.add-stop').show();
        });
        
        $('.removeStop').click(function(){
            $('.add-stop').hide();
        });
        
    });
    
    
    // initTelInputs ------------------------------------------------------------------------------------------------------
    initTelInputs();
    
    function initTelInputs(context = document) {

        $(context).find('.telinput').each(function () {
    
            if ($(this).data('iti')) return;
    
            const input = this;
    
            const iti = window.intlTelInput(input, {
                loadUtils: () =>
                    import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.15.0/build/js/utils.js"),
                initialCountry: "in",
                separateDialCode: true,
                autoPlaceholder: "off"
            });
    
            $(input).data('iti', iti);
    
            function updatePhoneCode() {
                const countryData = iti.getSelectedCountryData();
    
                $(input)
                    .closest('.row')
                    .find('.phone_code')
                    .first()
                    .val(countryData.dialCode);
            }
    
            updatePhoneCode();
            input.addEventListener("countrychange", updatePhoneCode);
        });
    }
    // initTelInputs ------------------------------------------------------------------------------------------------------
        
    </script>

    <!-- Page JS -->
    @yield('js')
    
    @if(session('error'))
    <script>
        window.onload = function () {
            if (typeof Toast !== 'undefined') {
                Toast.fire({
                    icon: 'error',
                    title: @json(session('error'))
                });
            } else {
                alert(@json(session('error'))); // fallback
            }
        };
    </script>
    @endif
    
</body>

</html>
