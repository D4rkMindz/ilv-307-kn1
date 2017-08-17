var app = {};

$(document).ready(function () {
	// if (navigator.serviceWorker.controller) {
	//     console.log('[PWA Builder] active service worker found, no need to register')
	// } else {
	//     //Register the ServiceWorker
	//     navigator.serviceWorker.register('pwabuider-sw.js', {
	//         scope: './'
	//     }).then(function (reg) {
	//         console.log('Service worker has been registered for scope:' + reg.scope);
	//     });
	// }
});

/**
 * Show loading animation.
 */
function showLoader() {
    $("#loader").show();
}

/**
 * Hide loading animation.
 */
function hideLoader() {
    $("#loader").hide();
}

/**
 * Make a notification.
 *
 * This function requires NotifJS
 *
 * @param {Object} options
 * @param {string} options.type (fails, error)
 * @param {string} options.msg ("Hello World!")
 * @returns {!Array.<string>}
 */
function notify(options) {
    options = $.extend({
        position: 'center',
        multiline: true,
        zindex: 9999999,
        opacity: 0.9
    }, options);
    return notif(options);
}

/**
 * Get form data
 *
 * @returns {Array} formData with all data
 */
function getFormData(form) {
    var formData = {};
    var data = $(form).serializeArray();
    $.each(data, function (i, field) {
        formData[field.name] = field.value;
    });
    return formData;
}

app.translations = null;

function __(text) {
    if (app.translations[text]) {
        text = app.translations[text];
    }
    arguments[0] = text;
    text = sprintf.apply(this, arguments);
    return text;
}

function setText(translations) {
    app.translations = translations;
}
/**
 * Base url
 *
 @returns {|jQuery}
 */
function baseurl() {
    return $('head base').attr('href');
}

/**
 * Returns a formatted string using the first argument as a printf-like format.
 *
 * The first argument is a string that contains zero or more placeholders.
 * Each placeholder is replaced with the converted value from its corresponding argument.
 *
 * Supported placeholders are:
 *
 * %s - String.
 * %d - Number (both integer and float).
 * %% - single percent sign ('%'). This does not consume an argument.
 *
 * Argument swapping:
 *
 * %1$s ... %n$s
 *
 * When using argument swapping, the n$ position specifier must come immediately
 * after the percent sign (%), before any other specifiers, as shown in the example below.
 *
 * If the placeholder does not have a corresponding argument, the placeholder is not replaced.
 *
 * @author odan
 * @returns {String}
 */
function sprintf() {
    if (arguments.length < 2) {
        return arguments[0];
    }
    var args = arguments;
    var index = 1;
    var result = (args[0] + '').replace(/%((\d)\$)?([sd%])/g, function (match, group, pos) {
        if (match === '%%') {
            return '%';
        }
        if (typeof pos === 'undefined') {
            pos = index++;
        }
        if (pos in args && pos > 0) {
            return args[pos];
        } else {
            return match;
        }
    });
    return result;
}

/**
 * Confirm Dialog.
 *
 * Ask the User something.
 *
 * @param {string} message (Translated!)
 * @param {callback} callback function to be executed
 */
function confirm(message, callback) {
    var src = '<div class="modal fade" tabindex="-1" role="dialog" data-id="confirm-dialog" data-name="confirm">' +
        '<div class="modal-dialog" role="document">' +
        '<div class="modal-content">' +
        '<div class="modal-body">' +
        '<p>{{message}}</p>' +
        '</div>' +
        '<div class="modal-footer">' +
        '<button type="button" class="btn btn-danger" data-dismiss="modal" data-id="fails">{{buttonTrue}}</button>' +
        '<button type="button" class="btn btn-default" data-dismiss="modal" data-id="abort">{{buttonFalse}}</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    var dialog = Mustache.render(src, {
        'message': message,
        'buttonTrue': __("OK"),
        'buttonFalse': __("Cancel")
    });

    var html = $(dialog);
    var result = false;

    html.on("hidden.bs.modal", function () {
        callback(result);
        html.remove();
    });

    html.find("[data-id=fails]").on("click", function (e) {
        e.preventDefault();
        result = true;
    });
    html.modal();
}

/**
 * Redirect function.
 *
 * @param {string} url
 */
function redirectTo(url) {
    window.location.replace(baseurl() + url);
}
