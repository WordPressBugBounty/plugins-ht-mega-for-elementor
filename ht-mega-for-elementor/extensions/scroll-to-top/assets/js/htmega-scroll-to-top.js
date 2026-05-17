;jQuery(document).ready(function($) {
    var sttm = {};
    if (typeof sttData !== "undefined") {
        sttm = sttData;
    }

    function sanitizeIconClasses(str) {
        return String(str || "").split(/\s+/).map(function (t) {
            return t.replace(/[^a-zA-Z0-9_-]/g, "");
        }).filter(Boolean).slice(0, 25).join(" ");
    }

    var iconConf = (sttm['buton_icon'] ) ? sttm['buton_icon'] : 'fa fa-facebook';
    var stt_icon_type = (sttm['stt_icon_type'] ) ? sttm['stt_icon_type'] : '';

    var $iconWrap = $('<span>', { class: 'htmega-stt-icon', 'aria-hidden': 'true' });

    // icon generate
    if ('icon' === stt_icon_type && iconConf && typeof iconConf === 'object' && 'svg' !== iconConf['library'] && '' !== iconConf['value']) {
        var ii = document.createElement('i');
        ii.setAttribute('class', sanitizeIconClasses(iconConf['value']));
        ii.setAttribute('aria-hidden', 'true');
        $iconWrap.append(ii);

    } else if ('icon' === stt_icon_type && iconConf && typeof iconConf === 'object' && 'svg' === iconConf['library'] && '' !== iconConf['value']['url']) {
        var im = document.createElement('img');
        im.alt = '';
        im.src = String(iconConf['value']['url'] || '');
        $iconWrap.append(im);

    } else if ( 'icon' === stt_icon_type && typeof iconConf === 'string' && $.trim(iconConf) !== '') {
        var isc = document.createElement('i');
        isc.setAttribute('class', sanitizeIconClasses(iconConf));
        isc.setAttribute('aria-hidden', 'true');
        $iconWrap.append(isc);

    } else if ( 'image' === stt_icon_type && iconConf && typeof iconConf === 'object' && '' !== iconConf['url'] ) {
        var pic = document.createElement('img');
        pic.alt = '';
        pic.src = String(iconConf['url'] || '');
        $iconWrap.append(pic);

    } else {
        $iconWrap.append(
            $('<div/>').html(
                '<svg id="svg8" clip-rule="evenodd" fill-rule="evenodd" height="25" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" width="25" xmlns="http://www.w3.org/2000/svg"><path id="path2" d="m12 9.414-6.293 6.293c-.39.39-1.024.39-1.414 0s-.39-1.024 0-1.414l7-7c.39-.391 1.024-.391 1.414 0l7 7c.39.39.39 1.024 0 1.414s-1.024.39-1.414 0z"/></svg>'
            ).contents()
        );
    }

    var $scrollToTopButton = $('<div class="htmega-stt-wrap" id="htmegaScrollToTopBtn"></div>')
        .append($('<span class="htmega-stt-btn-label"></span>').html(typeof DOMPurify !== 'undefined' ? DOMPurify.sanitize(sttm['stt_button_text'] || '') : sttm['stt_button_text'] || '' ))
        .append(document.createTextNode(' '))
        .append($iconWrap)
        .appendTo('body');

    // Global Settings
    var sttG = {};
    if (typeof stt !== "undefined") {
        sttG = stt;
    }
    var stt_color = (sttG['stt_color']) ? sttG['stt_color'] : '#ffffff';
    var stt_bg_color = (sttG['stt_bg_color']) ? sttG['stt_bg_color'] : '#000000';

    var stt_bg_color_hover = (sttG['stt_bg_color_hover']) ? sttG['stt_bg_color_hover'] : '#ffffff';
    var stt_color_hover = (sttG['stt_color_hover']) ? sttG['stt_color_hover'] : '#000000';
    var stt_bottom_space = (sttG['stt_bottom_space']) ? sttG['stt_bottom_space'] : '30';
    var position = (sttG['position']) ? sttG['position'] : 'bottom_right';
    var position2 = ('left' === position ) ? 'right': 'left';

    $scrollToTopButton.css('background', stt_bg_color).css('color', stt_color).css(position, '15px').css(position2, 'auto').css('bottom', stt_bottom_space + 'px');
    $(".htmega-stt-wrap svg path").css('fill', stt_color);

    // Button hover
    $('.htmega-stt-wrap').on("mouseenter", function() {
        $(this).css("background", stt_bg_color_hover).css('color', stt_color_hover);
        $(".htmega-stt-wrap svg path").css('fill', stt_color_hover);
    }).on("mouseleave", function() {
        $(this).css("background", stt_bg_color).css('color', stt_color);
        $(".htmega-stt-wrap svg path").css('fill', stt_color);
    });

    $(window).on("scroll", function() {

        if ($(this).scrollTop() > 20) {
            $('.htmega-stt-wrap').css('visibility', 'visible').css('opacity',1);

        } else {
            $('.htmega-stt-wrap').css('visibility', 'hidden').css('opacity',0);
        }
    });

    $('.htmega-stt-wrap').on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 1000);
        return false;
    });

});

