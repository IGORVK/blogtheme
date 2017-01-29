jQuery(document).ready(function($){
// custom FPR theme scripts

    /* init functions */
    revealPosts();

    /* variable declarations */
   // var carousel = '.fpr_theme-carousel-thumb';
    var last_scroll = 0;

    /* carousel functions */
    //fpr_theme_get_bs_thumbs(carousel);

    $(document).on('click', '.fpr_theme-carousel-thumb', function(){
        var id = $("#" + $(this).attr("id"));
        $(id).on('slid.bs.carousel', function () {
            fpr_theme_get_bs_thumbs(id);
        })

    });

    $(document).on('mouseenter', '.fpr_theme-carousel-thumb', function(){
        var id = $("#" + $(this).attr("id"));
        $(id).on('slid.bs.carousel', function () {
            fpr_theme_get_bs_thumbs(id);
        })

    });

    function fpr_theme_get_bs_thumbs( id ){

        $(id).each(function(){

            var nextThumb = $(id).find('.item.active').find('.next-image-preview').data('image');
            var prevThumb = $(id).find('.item.active').find('.prev-image-preview').data('image');
            $(id).find('.carousel-control.right').find('.thumbnail-container').css({ 'background-image' : 'url('+nextThumb+')' });
            $(id).find('.carousel-control.left').find('.thumbnail-container').css({ 'background-image' : 'url('+prevThumb+')' });

        });
    }


    /* Ajax functions */
    $(document).on('click','.fpr_theme-load-more:not(.loading)', function(){

        var that = $(this);
        var page = $(this).data('page');
        var newPage = page+1;
        var ajaxurl = that.data('url');
        var prev = that.data('prev');
        var archive = that.data('archive');

        if( typeof prev === 'undefined' ){
            prev = 0;
        }

        if( typeof archive === 'undefined' ){
            archive = 0;
        }

        that.addClass('loading').find('.text').slideUp(320);
        that.find('.fpr_theme-icon').addClass('spin');

        $.ajax({

            url : ajaxurl,
            type : 'post',
            data : {

                page : page,
                prev : prev,
                archive : archive,
                action: 'fpr_theme_load_more'

            },
            error : function( response ){
                console.log(response);
            },
            success : function( response ){

                if( response == 0 ){

                    $('.fpr_theme-posts-container').append( '<div class="text-center"><h3>You reached the end of the line!</h3><p>No more posts to load</p></div>' );
                    that.slideUp(320);

                }else{

                    setTimeout(function(){

                        if( prev == 1 ){
                            $('.fpr_theme-posts-container').prepend( response );
                            newPage = page - 1;
                        }else{
                            $('.fpr_theme-posts-container').append( response );
                        }

                        if( newPage == 1){

                            that.slideUp(320);

                        }else {

                            that.data('page', newPage);

                            that.removeClass('loading').find('.text').slideDown(320);
                            that.find('.fpr_theme-icon').removeClass('spin');
                        }

                        revealPosts();

                    }, 1000);

                }


            }

        });

    });

    /* scroll functions */
    $(window).scroll( function () {

        var scroll = $(window).scrollTop();

        if( Math.abs( scroll - last_scroll ) > $(window).height()*0.1 ){
            last_scroll = scroll;

            $('.page-limit').each(function ( index ) {

                if( isVisible( $(this) ) ){

                    //console.log('visible');
                    history.replaceState( null, null, $(this).attr("data-page") );
                    return( false );

                }

            });
        }


    } );


    /* helper functions */
    function revealPosts(){

        //activation shortcode tooltip for word editor
        $('[data-toggle="tooltip"]').tooltip();
        //activation shortcode popover for word editor
        $('[data-toggle="popover"]').popover()

        var posts = $('article:not(.reveal)');
        var i = 0;

        setInterval(function(){

            if( i >= posts.length ) return false;

            var el = posts[i];
            $(el).addClass('reveal').find('.fpr_theme-carousel-thumb').carousel();

            fpr_theme_get_bs_thumbs(el);

            i++

        }, 200);

    }
    
    function  isVisible( element ) {

        var scroll_pos = $(window).scrollTop();
        var window_height = $(window).height();
        var el_top = $(element).offset().top;
        var el_height = $(element).height();
        var el_bottom = el_top + el_height;
        return ( ( el_bottom - el_height*0.25 > scroll_pos ) && ( el_top < ( scroll_pos+0.5*window_height ) ) );
    }

    /* Sidebar functions */
    $(document).on('click', '.js-toggleSidebar', function(){
        $( '.fpr_theme-sidebar' ).toggleClass( 'sidebar-closed' );
        $( 'body' ).toggleClass('no-scroll');
        $( '.sidebar-overlay' ).fadeToggle( 320 );

    });

    /* contact form submission */
    $( '#fpr_themeContactForm' ).on( 'submit', function (e) {

        e.preventDefault();

        $( '.has-error' ).removeClass( 'has-error' );

        var form = $(this),
            name = form.find( '#name' ).val(),
            email = form.find( '#email' ).val(),
            message= form.find( '#message' ).val(),
            ajaxurl = form.data('url');

        //secure fields
        if( name === '' ){
            //console.log( 'Require Inputs are empty' );
            $('#name').parent('.form-group').addClass('has-error');

            return;
        }
        if( email === '' ){
            //console.log( 'Require Inputs are empty' );
            $('#email').parent('.form-group').addClass('has-error');

            return;
        }
        if( message === '' ){
            //console.log( 'Require Inputs are empty' );
            $('#message').parent('.form-group').addClass('has-error');

            return;

        }


        form.find('input, button, textarea').attr('disabled','disabled');

        $('.js-form-submission').addClass('js-show-feedback');




        $.ajax({

            url : ajaxurl,
            type : 'post',
            data : {

                name : name,
                email : email,
                message : message,
                action: 'fpr_theme_save_user_contact_form'

            },
            error : function( response ){
                $('.js-form-submission').removeClass('js-show-feedback');
                $('.js-form-error').addClass('js-show-feedback');
                form.find('input, button, textarea').removeAttr('disabled');
            },
            success : function( response ){

            if( response == 0 ){

                setTimeout(function () {

                    $('.js-form-submission').removeClass('js-show-feedback');
                    $('.js-form-error').addClass('js-show-feedback');
                    form.find('input, button, textarea').removeAttr('disabled');

                }, 1500);

            }else {
                setTimeout(function () {

                    $('.js-form-submission').removeClass('js-show-feedback');
                    $('.js-form-success').addClass('js-show-feedback');
                    form.find('input, button, textarea').removeAttr('disabled').val('');

                }, 1500);

            }

            }

        });


    } );


});

$(window).load(function() {

    $(".loader_inner").fadeOut();
    $(".loader").delay(400).fadeOut("slow");


});























