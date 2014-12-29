@extends('template')

@section('content')


<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        @yield("page-header")                
    </div>
</div>
<!-- /.row -->

@if (Session::get('erro'))
<div class="alert alert-error alert-danger">{{{ Session::get('erro') }}}</div>
@endif

@if (Session::get('alert'))
<div class="alert alert-error alert-warning">{{{ Session::get('alert') }}}</div>
@endif

<form class="form-horizontal" role="form" method="post">

    <div class="row">
        <div class="col-lg-{{ trim($__env->yieldContent('custom'))?'7':'12' }}">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Dados da pessoa:
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tipo:</label>
                        <div class="col-sm-9">
                            <select name="tipo" class="form-control none tipoPessoa" inputDocumento="documento" labelRazaoApelido="labelRazaoApelido" labelNascimentoFundacao="labelNascimentoFundacao">
                                <option value="CNPJ" {{ Input::old('tipo') == 'CNPJ' ? 'selected' : '' }}>Pessoa Jurídica</option>
                                <option value="CPF" {{ Input::old('tipo') == 'CPF' ? 'selected' : '' }}>Pessoa Fisica</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Documento:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control {{ strlen(Input::old('documento')) == 14 ? 'cpf' : 'cnpj' }}" id="documento" name="documento" value="{{ Input::old('documento') }}" placeholder="CPF ou CNPJ" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" id="btnConsultarReceita" type="button">Consultar Receita Federal</button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nome:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ Input::old('nome') }}" placeholder="Nome ou nome fantasia da empresa" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" id="labelRazaoApelido">{{ Input::old('tipo') == 'CPF' ? 'Apelido:' : 'Razão social:' }}</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="razao_apelido" name="razao_apelido" value="{{{ Input::old('razao_apelido') }}}" placeholder="Apelido ou razão social da empresa">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" id="labelNascimentoFundacao">{{ Input::old('tipo') == 'CPF' ? 'Nascimento:' : 'Fundação:' }}</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="nascimento_fundacao" id="nascimento_fundacao" value="{{ Input::old('nascimento_fundacao') }}" placeholder="dd/mm/aaaa">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Endereço:
                </div>
                <div class="panel-body">
                    @include('endereco.formFields')
                </div>
            </div>

        </div>

        @if (trim($__env->yieldContent('custom')))
        <div class="col-lg-5">
            @yield("custom")  
        </div>
        @endif

    </div>

    <button type="submit" class="btn btn-success">Cadastrar</button>
    <button type="reset" class="btn btn-danger">Limpar</button>
</form>



<!-- Modal -->
<div class="modal fade" id="pessoaExisteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">O documento informado já existe!</h4>
            </div>
            <form role="form" method="POST" action="">
                <input type="hidden" id="pessoaExisteModal_fkPessoa" name="fk_pessoa" />

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-warning">
                                Encontramos um cadastro com o documento <span id="pessoaExisteModal_documento_span"></span>.<br />
                                <span style="font-size: 11px;">(OBS: O sistema não permite cadastros com documentos repetidos)</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nome:</label>
                        <div id="pessoaExisteModal_nome_div"></div>
                    </div>

                    <div class="form-group">
                        <label>Razão Social/Apelido:</label>
                        <div id="pessoaExisteModal_razao_div"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="submit" value="Utilizar" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="consultaReceitaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Consultar site da Receita Federal</h4>
            </div>
            <form role="form">
                <div class="modal-body">
                    <img id="consultaReceitaModal_img" />
                    <br />
                    <br />
                    <div class="form-group">
                        <input type="text" id="consultaReceitaModal_captcha" class="form-control" name="captcha" placeholder="Informe as letras" />
                    </div> 
                </div>
                <div class="modal-footer">
                    <input id="consultaReceitaModal_btnConsultar" type="button" value="Consultar" class="btn btn-success" />
                    <input id="consultaReceitaModal_btnRecarregar" type="button" value="Recarregar captcha" class="btn btn-warning" />
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript">
    $(function() {

        var viewstate = null;
        var cookie = null;

        /*
         * Prepara consulta Receita 
         */
        function consultaReceita(callback) {
            $.getJSON("/pessoa/consulta-receita?documento=" + $("#documento").val(), callback);
        }

        $("#btnConsultarReceita").click(function() {
            var btnConsultar = $(this);
            var value = btnConsultar.html();

            btnConsultar.html('Consultando ..');

            consultaReceita(function(json) {
                if (json.code === 0) {
                    $("#consultaReceitaModal_img").attr('src', json.params.captchaBase64);
                    viewstate = json.params.viewstate;
                    cookie = json.params.cookie;

                    $('#consultaReceitaModal').modal('show');
                }
                btnConsultar.html(value);
            });
        });

        /*
         * Reload captcha 
         */
        $("#consultaReceitaModal_btnRecarregar").click(function() {
            var btnRecarregar = $(this);
            var value = btnRecarregar.val();

            btnRecarregar.val('Consultando...');

            consultaReceita(function(json) {
                if (json.code === 0) {
                    $("#consultaReceitaModal_img").attr('src', json.params.captchaBase64);
                    viewstate = json.params.viewstate;
                    cookie = json.params.cookie;
                }
                btnRecarregar.val(value);
            });
        });

        /*
         * Efetua consulta Receita 
         */
        $("#consultaReceitaModal_btnConsultar").click(function() {
            var btnConsultar = $(this);
            var value = btnConsultar.val();

            var param = {
                documento: $("#documento").val(),
                viewstate: viewstate,
                cookie: cookie,
                captcha: $("#consultaReceitaModal_captcha").val()
            };

            btnConsultar.val('Consultando...');

            var nome = $("#nome");
            var razao_apelido = $("#razao_apelido");
            var cep = $("#cep");
            var logradouro = $("#logradouro");
            var numero = $("#numero");
            var complemento = $("#complemento");
            var bairro = $("#bairro");
            var fk_cidade = $("#fk_cidade");

            //Cliente
            var nascimento_fundacao = $("#nascimento_fundacao");

            $.post("/pessoa/consulta-receita", param, function(json) {
                if (json.code === 0 || json.code === 1) {
                    if (json.code === 0) {

                        nome.val(json.params.nome_fantasia);
                        razao_apelido.val(json.params.razao_social);

                        //Cliente                        
                        nascimento_fundacao.val(json.params.data_abertura);

                        cep.val(json.params.cep);
                        logradouro.val(json.params.logradouro);
                        numero.val(json.params.numero);
                        complemento.val(json.params.complemento);
                        bairro.val(json.params.bairro);
                        fk_cidade.attr('itemid', '');
                        fk_cidade.attr('itemname', json.params.cidade.toUpperCase());

                        $("#uf option").each(function() {
                            if ($(this).val() === json.params.uf) {
                                $(this).attr("selected", "true");
                                $(this).trigger("change");
                            }
                        });
                    }
                    if (json.code === 1) {
                        nome.val(json.params.nome);
                    }
                    $('#consultaReceitaModal').modal('hide');
                } else {
                    alert(json.params.message);
                    $("#consultaReceitaModal_btnRecarregar").trigger('click');
                }
                btnConsultar.val(value);
            }, 'json');
        });


        /*
         * Verifica documento existe
         */
        $("#documento").blur(function() {
            var documento = $(this).val();
            $("#btnConsultarReceita").attr('disable', true);

            $.getJSON("/pessoa/check-documento?documento=" + documento, function(json) {
                if (json.code === 1) {
                    $("#pessoaExisteModal_fkPessoa").val(json.pessoa.id);
                    $("#pessoaExisteModal_documento_span").html(json.pessoa.documento);
                    $("#pessoaExisteModal_nome_div").html(json.pessoa.nome);
                    $("#pessoaExisteModal_razao_div").html(json.pessoa.razao_apelido);

                    $('#consultaReceitaModal').modal('hide');
                    $('#pessoaExisteModal').modal('show');
                } else
                    $("#btnConsultarReceita").attr('disable', false);
            });
        });

        $('#pessoaExisteModal').on('hidden.bs.modal', function(e) {
            $("#btnConsultarReceita").attr('disable', false);
        });
    });
</script>
@stop
