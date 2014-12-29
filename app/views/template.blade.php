<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>LaraERP</title>

        <!-- Bootstrap Core CSS -->
        {{ HTML::style('css/bootstrap.min.css') }}

        <!-- Custom CSS -->
        {{ HTML::style('css/sb-admin.css') }}

        <!-- Editable -->
        {{ HTML::style('css/bootstrap-editable.css') }}

        <!-- Morris Charts CSS -->
        {{ HTML::style('css/plugins/morris.css') }}

        <!-- Custom Fonts -->
        {{ HTML::style('font-awesome-4.1.0/css/font-awesome.min.css') }}
        
        <!-- Switch -->
        {{ HTML::style('css/bootstrap-switch.min.css') }}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">LaraERP</a>
                </div>
                @include('menu')            
                @include('sidebar')                
            </nav>

            <div id="page-wrapper">

                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery Version 1.11.0 -->
        {{ HTML::script('js/jquery-1.11.0.js') }}

        <!-- Bootstrap Core JavaScript -->
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/plugins/jquery.bootstrap-input-spinner.js') }}

        {{ HTML::script('js/plugins/jquery.mask.min.js') }}
        {{ HTML::script('js/plugins/jquery.maskMoney.js') }}

        {{ HTML::script('js/custom.js') }}

        {{ HTML::script('js/bootstrap-editable.min.js') }}
        
        {{ HTML::script('js/bootstrap-switch.min.js') }}

        @yield("javascript")

    </body>

</html>