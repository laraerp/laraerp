@extends('template')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Configurações
        </h1>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">

        <!-- Faturamento -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> Dados da empresa</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" >
                        <tbody> 
                            <tr>         
                                <td width="35%">CNPJ:</td>
                                <td width="65%">
                                    <a class="editable editable-click editPessoa" href="#" id="documento" data-type="text" data-title="Informe o documento">11.355.632/0001-94</a>
                                </td>
                            </tr> 
                            <tr>         
                                <td>Razão Social:</td>
                                <td>
                                    <a class="editable editable-click editPessoa" href="#" id="razao_apelido" data-type="text" data-title="Informe a razão social">Jansen Felipe Corrêa de Lacerda Neres Vitor - ME</a>
                                </td>
                            </tr>  
                            <tr>         
                                <td>Nome Fantasia:</td>
                                <td>
                                    <a class="editable editable-click editPessoa" href="#" id="nome" data-type="text" data-title="Informe o nome fantasia">Supliu Soluções Web</a>
                                </td>
                            </tr> 
                            <tr>         
                                <td>Fundação:</td>
                                <td>
                                    <a class="editable editable-click editPessoa" href="#" id="nascimento_fundacao" data-type="date" data-format="dd/mm/yyyy" data-clear="false" data-title="Informe">10/11/2009</a>
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="row">
    <div class="col-lg-6">

        <!-- NFe -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-inbox fa-fw"></i> Nota fiscal eletrônica</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i> Nenhum certificado cadastrado! <a href="#" class="alert-link">Clique aqui</a> para enviar seu certificado A1!
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-6">

        <!-- Centro de custo -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Centros de custo</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-info-circle"></i> Nenhum centro de custo encontrado! <a href="#" class="alert-link">Clique aqui</a> para cadastrar!
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