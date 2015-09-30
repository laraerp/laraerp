(function ($) {

    $.fn.ufs = function(options) {

        var select = $(this);

        var settings = $.extend({
            'default': select.attr('default'),
            'onChange': function(uf){}
        }, options );

        $.get("/util/ufs", null, function (json) {

            $.each(json, function (key, value) {
                select.append('<option value="' + value.uf + '" '+(settings.default==value.uf?'selected':'')+'>' + value.uf + '</option>');
            })

            settings.onChange(select.val());

        }, 'json');

        select.change(function(){
            settings.onChange(select.val());
        });
    };


    $.fn.cidades = function(options) {

        var select = $(this);

        var settings = $.extend({
            'default': select.attr('default'),
            'uf': null
        }, options );

        if(settings.uf == null)
            console.warn('Nenhuma UF informada');
        else{

            select.html('<option>Carregando..</option>');

            $.get("/util/cidades/"+settings.uf, null, function (json) {
                select.html('<option value="">Selecione</option>');

                $.each(json, function (key, value) {
                    select.append('<option value="' + value.id + '" '+((settings.default==value.id || settings.default==value.nome || settings.default==value.nome.toUpperCase())?'selected':'')+'>' + value.nome + '</option>');
                })

            }, 'json');

        }
    };

}(jQuery));