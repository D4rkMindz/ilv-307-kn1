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
 * Redirect function.
 *
 * @param {string} url
 */
function redirectTo(url) {
    window.location.replace(baseurl() + url);
}

/**
 * Get baseurl.
 *
 * @param route
 * @returns {*}
 */
function baseurl(route) {
    route = route || '';
    let base = $('head base').attr('href');
    return base + route;
}

/**
 * Notify
 *
 * @param options
 * @returns {*|{destroy, dismiss}}
 */
function notify(options) {
    options = $.extend({
        position: 'center',
        multiline: true,
        zindex: 999999,
        opacity: 0.9
    }, options);
    return notif(options);
}

/**
 * Add element to shoppingcart
 */
function addToShoppingCart(context) {
    var el = $(context).closest('div.counter').find('input');
    var id = $(el).attr('id');
    var val = $(el).val();
    var data = {
        id: id,
        count: val
    };
    $.ajax({
        method: 'POST',
        contentType: 'application/json',
        processData: true,
        url: baseurl('warenkorb'),
        data: JSON.stringify(data),
    }).done((response) => {
        if (response.status === 1) {
            notify({type: 'success', msg: 'Artikel hinzugefügt'});
            location.reload();
        }
    }).fail((xhr) => {
        if (xhr.status === 422) {
            notify({type: 'error', msg: 'Falsche Daten Eingegeben.'});
        }
    });
}

function edit(context) {
    var $this = $(context);
    var p = $this.parent();
    let val = $this.data('value');
    p.find('[data-id=count]').addClass('hidden');
    p.find('input[type=number]').removeClass('hidden').val(val);
    $this.addClass('hidden');
    p.find('[data-id=save]').removeClass('hidden');
}

function save(context) {
    var $this = $(context);
    var input = $this.parent().find('input[type=number]');
    let id = input.data('item-id');
    let val = input.val();
    var data = {
        id: id,
        count: val
    };
    $.ajax({
        method: 'PUT',
        contentType: 'application/json',
        processData: true,
        url: baseurl('warenkorb'),
        data: JSON.stringify(data),
    }).done((response) => {
        if (response.status === 1) {
            notify({type: 'success', msg: 'Artikel geändert'});
            location.reload();
        }
    }).fail((xhr) => {
        if (xhr.status === 422) {
            notify({type: 'error', msg: 'Falsche Daten Eingegeben.'});
        }
    });
}

function deleteItem(context) {
    var $this = $(context);
    var id = $this.parent().find('input[type=number]').data('item-id');
    var data = {
        id: id,
    };
    if (confirm('Wollen Sie den Artikel löschen?')) {
        $.ajax({
            method: 'DELETE',
            contentType: 'application/json',
            processData: true,
            url: baseurl('warenkorb'),
            data: JSON.stringify(data),
        }).done((response) => {
            if (response.status === 1) {
                notify({type: 'success', msg: 'Artikel gelöscht'});
                location.reload();
            }
        }).fail((xhr) => {
            if (xhr.status === 422) {
                notify({type: 'error', msg: 'Falsche Daten Eingegeben.'});
            }
        });
    }
}

function ajustPrice() {
    var total = 0;
    var b = $('body');

    b.find('[data-id=items] input[type=hidden]').each(function (i, el) {
        let price = $(el).val();
        total += parseFloat(price);
    });

    let p = b.find('input[name=delivery-type]:checked').val();
    total += parseFloat(p);
    getExchangeRate().then((exchangeRate) => {
        var chf = total.toFixed(2);
        var eur = (total * exchangeRate['EUR']).toFixed(2);
        var usd = (total * exchangeRate['USD']).toFixed(2);
        var prices = 'CHF ' + chf + ' EUR ' + eur + ' USD ' + usd;
        $('[data-id=price]').text(prices);
        $('[data-id=total]').val(total.toFixed(2));
    });
}

function getExchangeRate() {
    return new Promise((resolve) => {
        $.ajax({
            method: 'GET',
            contentType: 'application/json',
            cache: false,
            processData: true,
            url: 'https://api.fixer.io/latest?base=CHF',

        }).done((response) => {
            resolve(response.rates);
        });
    });
}

function order() {
    var form = $('[data-id=form]');
    var data = {};
    $('span.help-block').text('');
    $('.has-error').removeClass('has-error');
    data['salutation'] = form.find('select').val();
    var valid = true;
    form.find('input[required]').each(function (i, el) {
        let name = $(el).data('id');
        var val = $(el).val();
        if ($.trim(val) < 3) {
            valid = false;
            var e = $('[data-id=' + name + '-error]');
            e.text('Benötigt');
            e.parent().addClass('has-error');
        } else {
            data[name] = val;
        }
    });
    data['products'] = {};
    $('.cart-item').each(function (i, el) {
        var input = $(el).find('input[type=number]');
        let name = input.data('item-id');
        data['products'][i] = {};
        data['products'][i]['id'] = name;
        data['products'][i]['count'] = input.val();
    });
    if (valid) {
        $.ajax({
            method: 'POST',
            contentType: 'application/json',
            processData: true,
            url: baseurl('bestellen'),
            data: JSON.stringify(data),
        }).done((response) => {
            if (response.status === 1) {
                redirectTo('');
            }
        }).fail((xhr) => {
            if (xhr.status === 422) {
                notify({type: 'error', msg: 'Falsche Daten Eingegeben.'});
                xhr.errors.each(function (i, el) {
                    $('[data-id=' + el.field + ']').text(el.message).parent().addClass('has-error')
                });
            }
        });
    }
}