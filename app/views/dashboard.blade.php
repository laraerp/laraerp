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

        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-info-circle"></i> Dica: <a href="/notaFiscal" class="alert-link">Clique aqui</a> para importar suas NFe de entrada e saída e evite cadastrar clientes, produtos, fornecedores entre outros! 
        </div>

        <!-- Faturamento -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Faturamento</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> Nenhum pedido foi faturado para exibir no gráfico.
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
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> Nenhum produto encontrado! <a href="#" class="alert-link">Clique aqui</a> para cadastrar seu primeiro produto!
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
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> Nenhum pedido encontrado! <a href="#" class="alert-link">Clique aqui</a> para cadastrar seu primeiro pedido!
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.row -->
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