@extends('template')
@section('content')

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Notas fiscais
        </h1>
    </div>
</div>
<!-- /.row -->

@if (Session::get('erro'))
<div class="alert alert-error alert-danger">{{{ Session::get('erro') }}}</div>
@endif

@if (Session::get('alert'))
<div class="alert alert-error alert-warning">{{{ Session::get('alert') }}}</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-upload fa-fw"></i> Importar notas fiscais eletrônicas</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="/notaFiscal/importar" enctype="multipart/form-data" style="display: none;">
                    <input name="files[]" id="files" type="file" multiple="true" accept="application/xml" />
                </form>
                <input type="button" id="btnSelecionarArquivos" class="btn btn-success btn-lg" value="Importar arquivos .xml" />
            </div>
        </div>
    </div>
</div>


<form id="formFilter" method="GET" class="form-horizontal">
    <div class="row">
        <div class="col-lg-12">
            <div id="accordion" class="panel-group accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <div class="input-group" style="padding: 10px;">
                                <input class="form-control" type="text" name="nome_like" value="{{ Input::get('nome_like') }}" placeholder="Digite uma palavra chave.." />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Filtrar</button>
                                    <button class="btn btn-default " type="button" href="#collapseOne" data-parent=".accordion" data-toggle="collapse">Avançado</button>
                                </span>
                            </div>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="collapseOne" style="height: 0px;">
                        <div class="panel-body">
                            Nenhum filtro avançado
                        </div>
                    </div>
                </div> <!-- /.panel-default -->
            </div>
        </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-xs-8 pull-left">
            <a class="btn btn-sm btn-success" href="{{ action('ClienteController@getCreate') }}"><i class="fa fa-plus-circle"></i> Criar novo Cliente</a>
        </div>
        <div class="col-xs-4 pull-right">
            <div class="input-group input-group-sm">
                <span class="input-group-addon">Mostrar</span>
                <input type="text" class="form-control" id="limit" name="limit" value="{{ $limit }}">                       
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" onclick="$('#formFilter').submit();">Filtrar</button>
                </span>
            </div>
        </div>
    </div>
    <!-- /.row -->
</form>

<hr />

<div class="table-responsive">
    <table class="table table-hover table-condensed table-striped">
        <thead>
            <tr class="orderBy">
                <th><a href="{{ URL::to('cliente?sort=nome' . $querystr) }}">Nome/Fantasia<i class="caret"></i></a></th>
                <th><a href="{{ URL::to('cliente?sort=razao_apelido' . $querystr) }}">Razão/Apelido<i class="caret"></i></a></th>
                <th><a href="{{ URL::to('cliente?sort=documento' . $querystr) }}">Documento<i class="caret"></i></a></th>
                <th width="100">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
            <tr>
                <td>{{ Utils::highlighting($cliente->pessoa->nome, Input::get('nome_like')) }}</td> 
                <td>{{ Utils::highlighting($cliente->pessoa->razao_apelido, Input::get('razao_apelido_like')) }}</td> 
                <td>{{ Utils::highlighting($cliente->pessoa->getDocumento(), Input::get('documento_like')) }}</td> 
                <td>
                    <a href="{{ action('ClienteController@getView', $cliente->id) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ action('ClienteController@getDelete', $cliente->id) }}" class="btn btn-xs btn-danger">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $clientes->links() }}
@stop


@section('javascript')
<script type="text/javascript">
    $(function() {
        $("#btnSelecionarArquivos").click(function() {
            $("#files").click();
            $("#files").change(function() {
                $(this).parent().submit();
            });
        });
    });
</script>
@stop   