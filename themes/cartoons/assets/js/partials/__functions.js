var ltgscripts = {};
jQuery(function($){
    $('.schema-faq-section').expand();
    /* - - - - - - - - - - - - - - - - - - - - - - - - - -
    /* HAMBURGER
    */
    $('header .hamburger').on('click', function(e) {
        e.preventDefault();
        $('html').toggleClass('nav-open');
        $(this).toggleClass('is-active');
    });

    /* - - - - - - - - - - - - - - - - - - - - - - - - - -
    /* GETURLVARS
    // function to get the url and split it up by query strings (?'s)
    */
    ltgscripts.getUrlVars = function() {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    /* - - - - - - - - - - - - - - - - - - - - - - - - - -
    /* SOCIAL SHARING NEW WINDOWS
    */
    $('.social-share .nw').click(function(){
        var left  = ($(window).width() / 2) - (900 / 2),
            top   = ($(window).height() / 2) - (600 / 2);
        window.open($(this).attr('href'), "Share!", "width=900, height=600, top=" + top + ", left=" + left);
        return false;
      });

    /* - - - - - - - - - - - - - - - - - - - - - - - - - -
    /* BACK TO TOP
    */
    var backtotop = $('.back-to-top');
    $(window).scroll(function() {
        if ($(window).scrollTop() > 900) {
            backtotop.addClass('show');
        } else {
            backtotop.removeClass('show');
        }
    });
    backtotop.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '400');
    });

    /* - - - - - - - - - - - - - - - - - - - - - - - - - -
    /* AJAX FILTER
    functionName = the php function name that gets passed into the data:action
    
    queryVar = post type that's being passed into the data:query
  
    postType = the post type

    results = results wrap div / i.e. - results = $('.results-wrap .ajax-results')

    loadMore = the load more button ID. Set to false if not using the loadMore
    */
    ltgscripts.ajaxSimple = function(functionName,queryVar,postType='post',results,loadMore) {
        var loaderWrap = $('.results-wrap .loader-wrap');
      
        $.ajax({
            type:'post',
            url:bloginfo.ajax_url,
            dataType: 'json',
            data: {
                action:functionName,
                query:queryVar,
                post_type:postType
            },
            beforeSend: function(xhr){
                loaderWrap.addClass('loading');
            },
            success:function(data){
                if(data) {         
                    var html = data.content;

                    bloginfo.current_page = 1;
                    bloginfo.posts = data.posts;
                    bloginfo.max_page = data.max_page;

                    if(html != ''){
                        setTimeout(function () {
                            results.html(html);
                            loaderWrap.removeClass('loading');
                        }, 1200);
                    }

                    //if the load more button exists
                    if(loadMore.length > 0) {
                        if ( data.max_page < 2 ) {
                            loadMore.hide();
                        } else {
                            loadMore.show();
                        }
                    }
                }
            },
        });
    } // ajaxSimple
});
'use strict';

;( function( $, window, document, undefined ) {
    $( '.gfield.fileupload input' ).each( function() {
        var $input   = $( this ),
            $label   = $input.closest('.gfield').find('.gfield_label'),
            labelVal = $label.html();

        $input.on( 'change', function( e ) {
            var fileName = '';

            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else if( e.target.value )
                fileName = e.target.value.split( '\\' ).pop();

            $label.html( fileName );
        });

        // Firefox bug fix
        $input
        .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
        .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
    });
})( jQuery, window, document );