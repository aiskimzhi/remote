/**
 * Gets the image path
 *
 * @param i
 * @returns {*|jQuery}
 */
function getImage(i)
{
    var sel = 'div#car' + i + ' div div.active img';
    var sel2 = '#avatar_' + i;
    var im = $(sel).attr('src');
    return $(sel2).attr('value', im);
}

/**
 * Inserts path of the avatar into database
 *
 * @param id
 * @param i
 */
function setAvatar(id, i)
{
    var sel1 = '#avatar_' + i;
    var p = $(sel1).attr('value');
    $.ajax({
        url: 'modal?id=' + id,
        type: 'post',
        data: 'img=' + p
    });
}

/**
 * this method always opens the first picture in the list when you view an advert
 *
 * @param i
 * @returns {boolean}
 */
function carouselOpen(i)
{
    var sel = '#' + i + '0';
    var sel2 = 'div#car' + i + ' div div.item.active';
    $(sel2).attr('class', 'item');
    $(sel).parent().attr('class', 'item active');
    return true;
}

/**
 * Gets the image path
 *
 * @param i
 * @returns {*|jQuery}
 */
function trash(i)
{
    var sel = 'div#car' + i + ' div div.active img';
    var sel2 = '#avatar_' + i;
    var im = $(sel).attr('src');
    return $(sel2).attr('value', im);
}

function insertCurrency()
{

    var currency = $('#select-currency option:selected').val();
    var a = 'currency=' + currency;
    var url = $('#select-currency').attr("name");
    var style = 'border: solid #4d9f52 3px; ' +
                '-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075); ' +
                'box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075); width: 100px; margin-top: 10px;';
    $.ajax({
        url: url,
        type: 'post',
        data: a,
        success: function () {
            $('#select-currency').attr('style', style);
            setTimeout(renew(), 100000);
        }
    });
}

function renew() {
    window.location.reload();
}

function setMinDate()
{
    var selected = $('#before-field').datepicker('getDate');
    var n = selected.toString();
    var a = [];
    a = n.split(' ');
    var b = a[1] + ' ' + a[2] + ', ' + a[3];

    return $('#after-field').datepicker('option', 'minDate', b);
}

function resetDate()
{
    $('#before-field').datepicker('setDate', null);
    $('#after-field').datepicker('setDate', null);
}