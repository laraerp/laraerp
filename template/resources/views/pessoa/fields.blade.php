<?php $tipo = (isset($params['documento']) && strlen(Utils::unmask($params['documento'])) == 11) ? 'fisica' : 'juridica' ?>

<div class="form-group">
    <label class="col-sm-3 control-label">*Tipo:</label>
    <div class="col-sm-9">
        <select name="tipo" class="form-control none tipoPessoa"
                inputDocumento="documento"
                labelRazaoApelido="labelRazaoApelido"
                labelNascimentoFundacao="labelNascimentoFundacao">

            <option value="CNPJ" {{ $tipo=='juridica' ? 'selected' : '' }}>Pessoa Jurídica</option>
            <option value="CPF" {{ $tipo=='fisica' ? 'selected' : ''}}>Pessoa Física</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">*Documento:</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input type="text" class="form-control {{ $tipo=='fisica' ? 'cpf' : 'cnpj'}}" id="documento" name="documento" value="{{ $params['documento'] or '' }}" placeholder="Documento" />
            <span class="input-group-btn">
                <button class="btn btn-primary" id="btnConsultarReceita" type="button">Consultar</button>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">*Nome:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $params['nome'] or '' }}" placeholder="Nome fantasia" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" id="labelRazaoApelido">{{ $tipo=='fisica' ? 'Apelido' : 'Razão Social'}}:</label>
    <div class="col-sm-9">
        <input class="form-control" id="razao_apelido" name="razao_apelido" value="{{ $params['razao_apelido'] or '' }}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" id="labelNascimentoFundacao">{{ $tipo=='fisica' ? 'Nascimento' : 'Fundação'}}:</label>
    <div class="col-sm-9">

        <?php
            if (isset($params['nascimento_fundacao']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $params['nascimento_fundacao']))
                $params['nascimento_fundacao'] = \DateTime::createFromFormat("Y-m-d", $params['nascimento_fundacao'])->format('d/m/Y');
        ?>

        <input class="form-control datepicker" name="nascimento_fundacao" id="nascimento_fundacao" value="{{ $params['nascimento_fundacao'] or '' }}" placeholder="dd/mm/aaaa">
    </div>
</div>

<script>
    $(function(){

        $('#btnConsultarReceita').click(function(){
            $('#documento').consultaReceita({
                'onAfter': function(resultado){
                    if(resultado.cpf){
                        $('#nome').val(resultado.nome);
                        $('#nascimento_fundacao').val(resultado.nascimento);
                    }else{
                        $('#nome').val(resultado.nome_fantasia);
                        $('#razao_apelido').val(resultado.razao_social);
                        $('#nascimento_fundacao').val(resultado.situacao_cadastral_data);
                        $('#email').val(resultado.email);
                        $('#telefone').val(resultado.telefone);

                        $('#cep').val(resultado.cep);
                        $('#logradouro').val(resultado.logradouro);
                        $('#numero').val(resultado.numero);
                        $('#complemento').val(resultado.complemento);
                        $('#bairro').val(resultado.bairro);
                        $('#cidade_id').attr('default', resultado.cidade);
                        $('#uf').val(resultado.uf);

                        $('#uf').trigger('change');

                    }
                }
            });
        });

        $('.tipoPessoa').change(function () {
            var inputDocumento = $('#' + $(this).attr('inputDocumento'));
            var labelRazaoApelido = $('#' + $(this).attr('labelRazaoApelido'));
            var labelNascimentoFundacao = $('#' + $(this).attr('labelNascimentoFundacao'));

            inputDocumento.removeClass('cpf');
            inputDocumento.removeClass('cnpj');

            if ($(this).val() === 'CPF') {
                labelRazaoApelido.html('Apelido:');
                labelNascimentoFundacao.html('Nascimento:');
                inputDocumento.addClass('cpf');
                $("#dadosComplementares").addClass('hide');
                $('.cpf').mask('000.000.000-00');
            }

            if ($(this).val() === 'CNPJ') {
                labelRazaoApelido.html('Razão social:');
                labelNascimentoFundacao.html('Fundação:');
                inputDocumento.addClass('cnpj');
                $("#dadosComplementares").removeClass('hide');
                $('.cnpj').mask('00.000.000/0000-00');
            }
        });

    });
</script>