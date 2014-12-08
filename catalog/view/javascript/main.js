function hideMore() {
    $('.more-text').slideUp("fast");
    $('.main-txt-more').css('display', 'block');
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    return false;
}

function showMore() {
    $('.main-txt-more').css('display', 'none');
    $('.more-text').slideDown("fast");
    return false;
}

function arrangeItem() {

    var tcount;
    $('.b-item:visible').each(function() {
        title  = $(this).find('.item-title');
        text   = $(this).find('p.item-info');
        tcount = title.height()/parseInt(title.children('a').css('line-height'));

        if (tcount > 3) {
            title.addClass('item-title3');
            text.css('height', '14px');
        } else {
            if (tcount > 2) {
                title.addClass('item-title2');
                text.css('height', '28px');
            } else {
                text.css('height', '42px');
            }
        }

        //alert(tcount);
    });

    return true;
}

