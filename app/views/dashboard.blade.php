@extends('template')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Dashboard <small>Statistics Overview</small>
        </h1>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">

        <!-- Faturamento -->
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-upload fa-fw"></i> Importar notas fiscais</h3>
            </div>
            <div class="panel-body">
                <p>Envie os arquivos de suas notas fiscais de entrada e saída e evite inúmeros cadastros!</p>

                <form method="post" action="/notaFiscal/importar" enctype="multipart/form-data" style="display: none;">
                    <input name="files[]" id="files" type="file" multiple="true" accept="application/xml" />
                </form>

                <input type="button" id="btnSelecionarArquivos" class="btn btn-success btn-lg" value="Importar arquivos .xml" />
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-12">

        <!-- Faturamento -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Faturamento</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-info-circle"></i> Nenhum pedido foi faturado para exibir no gráfico.
                </div>
            </div>
        </div>

    </div>
</div>


<div class="row">
    <div class="col-lg-6">

        <!-- Estoque -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-building fa-fw"></i> Estoque de produtos</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-info-circle"></i> Nenhum produto encontrado! <a href="#" class="alert-link">Clique aqui</a> para cadastrar seu primeiro produto!
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-6">


        <!-- Pedido -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-dollar fa-fw"></i> Pedidos</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-info-circle"></i> Nenhum pedido encontrado! <a href="#" class="alert-link">Clique aqui</a> para cadastrar seu primeiro pedido!
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.row -->
@stop

@section('javascript')
<script type="text/javascript">
    $(function () {
        $("#btnSelecionarArquivos").click(function () {
            $("#files").click();
            $("#files").change(function () {
                $(this).parent().submit();
            });
        });
    });
</script>
@stop    