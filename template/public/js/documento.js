(function ($) {

    var documento, settings;

    $.fn.consultaReceita = function (options) {

        documento = $(this).val().replace(/[^\d]+/g,'');

        settings = $.extend({
            'onBefore': function(){},
            'onAfter': function(resultado){}
        }, options );

        //Construindo modal
        buildModal();

        //Consultando parametros
        showModal();
        documentoParams();

    }

    function documentoParams(){
        showProgress('Aguarde.. Conectando ao site da Receita..');

        //Buscando parametros para realizar a consulta
        $.post('/util/parametrosReceita', {documento: documento}, function (json) {

            if (json.code === 0)
                setFormConsulta(json.params.captchaBase64, json.params.cookie);
            else
                showProgress(json.message, true);
        }, 'json').fail(function () {
            showProgress('Ocorreu um erro de conexao com o site da receita.. Tente novamente', true);
        });
    }

    function setFormConsulta(captchaBase64, cookie) {
        var html = '<img src="' + captchaBase64 + '" />' + '<br /><br /><input class="form-control" id="captcha" placeholder="Digite aqui as letras da imagem" />';

        if(documento.length == 11)
            html += '<br /><input class="form-control" id="consultaNascimento" placeholder="Informe a data de nascimento" />';

        html += '<br />Nao consegue ler? <a href="#" id="btnAtualizar">Clique aqui</a> para gerar outra imagem';

        $('#consultaReceita div.modal-body').html(html);

        $('#consultaNascimento').datepicker({
            'format': 'dd/mm/yyyy'
        });

        $('#btnAtualizar').unbind();
        $('#btnAtualizar').click(function () {
            documentoParams();
        });

        $('#btnConsultar').unbind();
        $('#btnConsultar').click(function () {
            consultar($('#consultaNascimento').val(), $('#captcha').val(), cookie);
        });
    }

    function consultar(nascimento, captcha, cookie) {
        showProgress('Consultando..');

        settings.onBefore();

        $.post('/util/consultaReceita', {nascimento: nascimento, documento: documento, captcha: captcha, cookie: cookie}, function (json) {

            if (json.code === 0) {
                settings.onAfter(json.params);
                hideModal();
            } else
                showProgress(json.message, true);

        }, 'json').fail(function () {
            showProgress('Ocorreu um erro ao consultar. Tente novamente', true);
        });
    }

    function showProgress(message, fail) {
        $('#consultaReceita div.modal-body').html('<div class="progress"><div id="progressReceita" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">' + message + '</div></div>');

        if (fail === true){
            $("#progressReceita")
                .addClass("progress-bar-danger")
                .removeClass("active")
                .removeClass("progress-bar-striped");

            $('#consultaReceita div.modal-body').append('<a href="#" id="btnTentarNovamente">Clique aqui</a> para tentar novamente');

            $('#btnTentarNovamente').unbind();
            $('#btnTentarNovamente').click(function () {
                documentoParams();
            });
        }
    }

    function buildModal() {
        $('body').append('<div id="consultaReceita" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Consultar</h4></div><div class="modal-body" id="consultaReceitaBody"></div><div class="modal-footer"><button id="btnConsultar" type="button" class="btn btn-primary">Consultar</button><button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button></div></div></div></div>');
    }

    function showModal() {
        $('#consultaReceita').modal('show');
    }

    function hideModal() {
        $('#consultaReceita').modal('hide');
    }

}(jQuery));