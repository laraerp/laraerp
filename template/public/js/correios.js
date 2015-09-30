(function ( $ ) {

    $.fn.getCep = function(options) {

        var settings = $.extend({
            cep: function(){},
            onBefore: function(){},
            onAfter: function(){},
            onSuccess: function(endereco){},
            onError: function(message){}
        }, options );

        $(this).click(function() {

            if (typeof(settings.onSuccess) === "function")
                var cep = settings.cep();
            else
                var cep = settings.cep;

            if(cep == null)
                settings.onError('Nenhum CEP informado');

            settings.onBefore();

            $.get("/util/cep/"+cep, function (json) {

                if(json.code===0)
                    settings.onSuccess(json.endereco);
                else
                    settings.onError(json.message);

                settings.onAfter();

            }, 'json');

        });
    };

}( jQuery ));