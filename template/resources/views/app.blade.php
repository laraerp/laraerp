<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laraerp</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Boostrap Datepicker -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>

    <!-- JQuery Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>

    <!-- Typeahead -->
    <script src="http://twitter.github.com/typeahead.js/releases/latest/typeahead.bundle.min.js"></script>

    <!-- Moment -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/pt-br.js"></script>

    <!-- jQuery Form Plugin -->
    <script src="//oss.maxcdn.com/jquery.form/3.50/jquery.form.min.js"></script>

    <!-- Laraerp -->
    <link href='/vendor/laraerp/template/css/app.css' rel='stylesheet' type='text/css'>
    <script src='/vendor/laraerp/template/js/app.js'></script>
    <script src='/vendor/laraerp/template/js/cidades.js'></script>
    <script src='/vendor/laraerp/template/js/correios.js'></script>
    <script src='/vendor/laraerp/template/js/documento.js'></script>

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Laraerp</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            @if (Auth::check())
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('vendas.index') }}"><i class="glyphicon glyphicon-arrow-up"></i> Vendas</a></li>
                    <li><a href="{{ route('compras.index') }}"><i class="glyphicon glyphicon-arrow-down"></i> Compras</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-object-align-bottom"></i> Estoque</a></li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Financeiro<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('financeiro.extrato') }}">Entrada/Saída</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route('financeiro.contasPagar') }}">Contas à pagar</a></li>
                            <li><a href="{{ route('financeiro.contasReceber') }}">Contas à receber</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cadastros <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('produtos.index') }}">Produtos</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route('clientes.index') }}">Clientes</a></li>
                            <li><a href="{{ route('fornecedores.index') }}">Fornecedores</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Nome do usuário <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">

                            <li><a href="/configuracoes">Configurações</a></li>
                            <li><a href="/notafiscal/importar">Importar NFe's</a></li>
                            <li><a href="/auth/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            @endif

        </div>
    </div>
</nav>

<div class="container-fluid">
    @if (Session::get('erro'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Session::get('erro') ?>
        </div>
    @endif

    @if (Session::get('alert'))
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Session::get('alert') ?>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@yield('content')


@yield('script')

</body>
</html>