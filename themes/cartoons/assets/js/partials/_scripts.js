jQuery(function($){
    // MOBILE ONLY
    if(Modernizr.mq('only screen and (max-width: 767px)')) {
        $('.nav-wrap .main-nav > li').each(function(){
            if( $(this).find('> .sub-menu').length ) {
                var opener = $(this).find('> a').clone().empty().addClass('opener');
                $(this).append(opener);
                $(this).find('> a.opener').on('click',function(e){
                    e.preventDefault();
                    $(this).parent().siblings().removeClass('open');
                    $(this).parent().toggleClass('open');
                }).next('.sub-menu').prepend($('<li/>'));
            }

        });
    }

    // DESKTOP ONLY
    if(Modernizr.mq('only screen and (min-width: 768px)')) {
        $(window).scroll(function(){
            if ($(window).scrollTop() >= 130) {
                $('body').addClass('sticky');
            } else {
                $('body').removeClass('sticky');
            }
        });
    }

    // SEARCH
    $('.main-nav .search-toggle').on('click', function(e) {
        e.preventDefault();
        $('html').toggleClass('search-open');
        $(this).toggleClass('active');
    });

    // SAMPLE AJAX ON CLICK EXAMPLE
    $('.AJAX_FILTER').on('click','a',function(e){
        e.preventDefault();
        var theData = $(this).data('type');
    
        $(this).addClass('active').siblings().removeClass('active');

        results = $('.results-wrap .ajax-results');

        ajaxSimple('ajax_function_name',theData,results);
    });
});