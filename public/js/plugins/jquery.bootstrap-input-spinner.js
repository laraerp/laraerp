/**************************************************************************/
/*******************************Input Text Spinner**************************/
/**************************************************************************/
/**
 * @license jQuery Twitter Bootstrap input text spinner plugin v1.0.0 23/04/2014
 * http://www.totpe.ro
 *
 * Copyright (c) 2014, Iulian Alexe (contact@totpe.ro)
 **/

//Use Exemple:

//$(".form-control").inputSpinner({ //options
//		'opacity'	: 0.5,
//		'color'		: 'red',
//		'glyphicon'	: 'glyphicon-refresh'
//});

//OR:

//$(".form-control").inputSpinner();
(function($) {
    var inputSpinnerFunc = function(element, options) {
        this.$element = $(element);

        this.options = $.extend(true, {}, $.fn.inputSpinner.defaults, options);

        if (this.$element.parents().hasClass("has-feedback")) {
            this.$element
                    .next("span")
                    .remove();
            this.$element
                    .parents()
                    .removeClass("has-feedback");
        } else {
            this.$element
                    .after($("<span></span>")
                            .addClass("glyphicon input-spinner form-control-feedback")
                            .addClass(this.options.glyphicon)
                            .css({
                                'opacity': this.options.opacity,
                                'color': this.options.color
                            })
                            );
            this.$element
                    .parents()
                    .addClass("has-feedback");
        }
        return this;
    };
    $.fn.inputSpinner = function(options) {
        return new inputSpinnerFunc(this, options);
    };

    $.fn.inputSpinner.defaults = {
        opacity: 0.7,
        color: '#999999',
        glyphicon: 'glyphicon-refresh',
    };

})(window.jQuery);
