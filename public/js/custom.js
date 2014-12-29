$(function () {
    //Mask
    $('.cep').mask('00.000-000', {reverse: true});
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});

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
            $('.cpf').mask('000.000.000-00', {reverse: true, onChange: changeFields});
        }

        if ($(this).val() === 'CNPJ') {
            labelRazaoApelido.html('Razão social:');
            labelNascimentoFundacao.html('Fundação:');
            inputDocumento.addClass('cnpj');
            $('.cnpj').mask('00.000.000/0000-00', {reverse: true, onChange: changeFields});
        }

    });

    $('.formEdit input:not(".none")').blur(changeFields);
    $('.formEdit textarea:not(".none")').blur(changeFields);
    $('.formEdit select:not(".none")').blur(changeFields);
    $('.formEdit input[type=checkbox]:not(".none")').on('switchChange', changeFields);
});

function changeFields() {
    var element = $(this);

    element.parents().removeClass("has-feedback");
    element.next("span.glyphicon").remove();

    var form = element.closest('.formEdit');
    var formGroup = element.closest('.form-group');

    formGroup.removeClass('has-success');
    formGroup.removeClass('has-error');
    formGroup.remove(".glyphicon");

    var url = form.attr('action');

    var param = {};

    if (element.attr('type') == 'checkbox') {
        param[element.attr('name')] = element.prop('checked') ? element.attr('data-on') : element.attr('data-off');
    } else
        param[element.attr('name')] = element.val();


    $.ajax({
        type: "POST",
        dataType: 'json',
        url: url,
        data: param,
        beforeSend: function () {
            element.inputSpinner();
        },
        success: function (json) {
            element.parents().removeClass("has-feedback")
            element.next("span.glyphicon").remove();

            if (json.codigo === 0) {
                formGroup.removeClass('has-error');

                var style = "";

                if (formGroup.find(".input-group").length) {
                    var width = formGroup.find(".input-group-btn").first().width();
                    style = "margin-right:" + width + "px;";
                }

                formGroup.append('<span class="glyphicon glyphicon-ok form-control-feedback" style="' + style + '"></span>');

                formGroup.addClass('has-success has-feedback');

                element.removeAttr('data-toggle');
                element.removeAttr('title', json.mensagem);
                element.tooltip('destroy');

                if (json.refresh)
                    location.reload();

            } else {
                element.attr('data-toggle', 'tooltip').attr('title', json.mensagem).tooltip('toggle');
                formGroup.addClass('has-error');
            }

        },
        error: function (data) {
            element.parents().removeClass("has-feedback")
            element.next("span.glyphicon").remove();

            element.attr('data-toggle', 'tooltip').attr('title', 'Erro desconhecido. Tente novamente.').tooltip('toggle');
            formGroup.addClass('has-error');
        }
    });
}

function loadUF(selectUF, selectFK) {
    $.get("/endereco/uf", null, function (json) {
        $.each(json, function (i, item) {
            if (selectUF.attr('itemid') === item) {
                aux = 'selected';
            } else
                aux = '';

            selectUF.append('<option value="' + item + '" ' + aux + '>' + item + '</option>');

            if (selectUF.attr('itemid') === item)
                selectUF.trigger("change");
        });
    }, 'json');

    selectUF.change(function () {
        var uf = $(this).val();
        selectFK.html('<option>Carregando..</option>');
        if (uf.length === 2) {
            $.get('/endereco/cidades?uf=' + uf, null, function (json) {
                selectFK.html('');
                $.each(json, function (i, item) {
                    if (selectFK.attr('itemid') === item.id || selectFK.attr('itemname') === item.nome)
                        aux = 'selected';
                    else
                        aux = '';
                    selectFK.append('<option value="' + item.id + '" ' + aux + '>' + item.nome + '</option>');
                });
            }, 'json');
        }
    });
}

(function ($) {
    $.fn.consultaCep = function (params) {

        $(this).click(function () {
            var value = $(this).html();

            $(this).html('Consultando ..');

            params.logradouro.val('');
            params.bairro.val('');
            params.fk_cidade.attr('itemname', '');

            $.get('/endereco/consulta-cep?cep=' + params.cep.val(), function (json) {
                if (json.code === 0) {
                    params.logradouro.val(json.resposta.logradouro);
                    params.bairro.val(json.resposta.bairro);
                    params.fk_cidade.attr('itemid', '');
                    params.fk_cidade.attr('itemname', json.resposta.cidade.toUpperCase());
                    params.uf.find("option").each(function () {
                        if ($(this).val() === json.resposta.uf) {
                            $(this).attr("selected", "true");
                            $(this).trigger("change");
                        }
                    });
                }
                $(this).html(value);
            });
        });
    }
}(jQuery));