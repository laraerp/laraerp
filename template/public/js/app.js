$(function () {

    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        }
    });

    $('.datepicker').datepicker({
        'format': 'dd/mm/yyyy'
    });

    $('.cep').mask('00.000-000');
    $('.phone').mask('0000-0000');
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.money').mask('000.000.000.000.000,00', {reverse: true});

    $('.telefone').mask(function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    }, {onKeyPress: function (val, e, field, options) {
        field.mask(maskBehavior.apply({}, arguments), options);
    }});


});

/**
 * Number.prototype.format(n, x, s, c)
 *
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

/*
 * GetCookie
 */
function getCookie(name) {
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = jQuery.trim(cookies[i]);
            // Does this cookie string begin with the name we want?
            if (cookie.substring(0, name.length + 1) == (name + '=')) {
                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                break;
            }
        }
    }
    return cookieValue;
}

function decodeEntities(string){
    return $('<textarea />').html(string).text();
}
