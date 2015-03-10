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