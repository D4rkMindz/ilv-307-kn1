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
    options  = $.extend({
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
      if (response.status === 1){
          notify({type:'success', msg: 'Artikel hinzugefügt'});
          location.reload();
      }
    }).fail((xhr) =>{
        if (xhr.status === 422){
            notify({type:'error', msg:'Falsche Daten Eingegeben.'});
        }
    });
}
