
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> @yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
        <!-- daterange picker -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/plugins/iCheck/all.css')}}">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/dist/css/AdminLTE.min.css')}}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/dist/css/skins/_all-skins.min.css')}}">
        <!-- Custom - Main - CSS -->
        <link rel="stylesheet" href="{{asset('public/css/main.css')}}">
        <!-- Summer Note - text editor -->
        <link rel="stylesheet" href="{{asset('public/plugins/summernote/summernote.css')}}">
        <!-- Bootstrap Datetimepicker-->
        <link rel="stylesheet" href="{{asset('public/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
        <!-- Morris charts -->
        <link rel="stylesheet" href="{{asset('public/vendor/adminlte/bower_components/morris.js/morris.css')}}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @stack('style')
    </head>
