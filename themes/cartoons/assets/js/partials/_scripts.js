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

    // CAROUSEL UNCOMMENT IF NEEDED 
    // var carousel_wrap = tns({
    //   container: '.carousel-wrap',
    //   items: 1,
    //   lazyLoad: true,
    //   autoplay: false,
    //   nav: true,
    //   loop: false,
    //   controls: false,
    //   mouseDrag: true
    // });

    // $('.main-nav li.popup a, .footer-text .popup').magnificPopup({
    //   type: 'inline',
    //   removalDelay: 300,
    //   mainClass: 'mfp-img-mobile',
    // });

    // $('.gallery-thumbnails').magnificPopup({
    //     delegate: 'a',
    //     type: 'image',
    //     closeOnContentClick: false,
    //     mainClass: 'mfp-with-zoom mfp-img-mobile',
    //     removalDelay: 300,
    //     image: {
    //         verticalFit: true
    //     },
    //     gallery: {
    //         enabled: true,
    //         navigateByImgClick: true,
    //         preload: [0,1]
    //     },
    // });

    // $('.some-link').on('click',function(e){
    //     e.preventDefault();
    //     $.magnificPopup.open({
    //         items: {
    //             src: '#some-popup'
    //         },
    //         type: 'inline',
    //         removalDelay: 300,
    //         mainClass: 'mfp-fade'
    //     });
    //     return false;
    // });
    
    // MAKING THINGS MOVEEEEEE
    // var els = false;
    // $(document).ready(function(){
    //     els = [
    //         $('.name-of-whats-moving'),
    //     ];
    //     doParallax();
    // });

    // // PARALLAX THINGS
    // $(window).on('scroll resize touchmove',doParallax);

    // function doParallax(){
    //     var dh = $(document).height();
    //     var sh = $(window).height();
    //     var st = $(window).scrollTop();

    //     for( i in els ) {
    //         var $el = els[i];
    //         $el.each(function(){
    //             var $e = $(this);
    //             if( $e.offset() ) {
    //                 if( $e.offset().top <= (st+sh + 50) ) {
    //                     $e.addClass('on');
    //                 }
    //             }
    //         });
    //     }
    // }
});