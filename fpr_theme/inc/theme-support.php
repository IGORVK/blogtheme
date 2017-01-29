<?php

/*
@package fpr_theme
   =====================================
            THEME SUPPORT OPTIONS
   =====================================
*/

$options = get_option( 'post_formats' );
$formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
$output = array();
foreach ( $formats as $format ){
    $output[] = ( @$options[$format] == 1 ? $format : '' );
}
if( !empty( $options ) ){
    add_theme_support( 'post-formats', $output );
}

$header = get_option( 'custom_header' );
if( @$header == 1 ){
    add_theme_support( 'custom-header' );
}

$background = get_option( 'custom_background' );
if( @$background == 1 ){
    add_theme_support( 'custom-background' );
}


//add Featured Image for Posts and Pages
add_theme_support('post-thumbnails');


/* Activate Nav Menu Option */

function fpr_theme_register_nav_menu(){
        register_nav_menu('primary', 'Header Navigation Menu');
}
add_action('after_setup_theme', 'fpr_theme_register_nav_menu');
/*Activate HTML5 features */
add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ));
/*
   =====================================
        SIDEBAR FUNCTIONS
   =====================================
*/

function fpr_theme_sidebar_init(){
    register_sidebar(

        array(
            'name' => esc_html__( 'FPR_theme Sidebar', 'fpr_theme' ),
            'id' => 'fpr_theme-sidebar',
            'description' => 'Dynamic Right Sidebar',
            'before_widget' => '<section id="%1$s" class="fpr_theme-widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="fpr_theme-widget-title">',
            'after_title'   => '</h2>'
        )

    );
}
add_action('widgets_init','fpr_theme_sidebar_init');


/*
   =====================================
        BLOG LOOP CUSTOM FUNCTIONS
   =====================================
*/
function fpr_theme_posted_meta(){

    $posted_on = human_time_diff( get_the_time('U') , current_time('timestamp')) . ' ago';

    $categories = get_the_category();
    $separator = ', ';
    $output = '';
    $i = 1;

    if( !empty($categories) ):
        foreach ( $categories as $category ):

            if( $i > 1 ): $output .= $separator; endif;

            $output .='<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( 'View all posts in%s', $category->name ) . '">' . esc_html( $category->name ) . '</a>';

            $i++;

        endforeach;
    endif;

    return '<span class="posted-on"> Posted <a href="'. esc_url( get_permalink() ).'">' . $posted_on . '</a></span> / <span class="posted-in">' . $output . '</span>';

}

function fpr_theme_posted_footer(){

    $comments_num = get_comments_number();

        if( comments_open() ){
            //get comments link
            if( $comments_num == 0 ){
                $comments = __('No Comments');
            }elseif ( $comments_num > 1 ) {

                $comments = $comments_num . __(' Comments');
            }else{
                $comments = __('1 Comment');
            }
            $comments = '<a class="comments-link" href="' . get_comments_link() . '">'
                        . $comments . ' <span class="fpr_theme-icon fpr_theme-comment"></span></a>';
        }else{
            $comments = _('Comments are closed');
        }


    return '<div class="post-footer-container"><div class="row"><div class="col-xs-12 col-sm-6">'
        . get_the_tag_list( '<div class="tags-list"><span class="fpr_theme-icon fpr_theme-tag"></span>', ', ' ,'</div>')
        . '</div><div class="col-xs-12 col-sm-6 text-right">' . $comments . '</div></div></div>';
}


function fpr_theme_get_attachment ( $num = 1 ){

    $output = '';
    if( has_post_thumbnail() && $num == 1 ):
        $output = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
    else:
        $attachments = get_posts( array(
            'post_type' => 'attachment',
            'post_per_page' => $num,
            'post_parent' => get_the_ID()
        ) );

        // var_dump($attachments);

        if ( $attachments && $num == 1 ):

            foreach ( $attachments as $attachment ):

                $output = wp_get_attachment_url( $attachment->ID );

            endforeach;
        elseif ($attachments && $num > 1):
            $output = $attachments;
        endif;

        wp_reset_postdata();

    endif;

    return $output;
}


function fpr_theme_get_embedded_media( $type = array() ){
    $content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
    $embed = get_media_embedded_in_content( $content, $type );

    if( in_array( 'audio' , $type) ):
        $output = str_replace( 'visual=true', 'visual=false', $embed[0] );
    else:
        $output = $embed[0];
    endif;

    return $output;
}

function fpr_theme_get_bs_slides( $attachments ){

    $output = array();
    $count = count($attachments)-1;

    for( $i = 0; $i <= $count; $i++ ):

        $active = ( $i == 0 ? ' active' : '' );

        $n = ( $i == $count ? 0 : $i+1 );
        $nextImg = wp_get_attachment_thumb_url( $attachments[$n]->ID );
        $p = ( $i == 0 ? $count : $i-1 );
        $prevImg = wp_get_attachment_thumb_url( $attachments[$p]->ID );

        $output[$i] = array(
            'class'		=> $active,
            'url'		=> wp_get_attachment_url( $attachments[$i]->ID ),
            'next_img'	=> $nextImg,
            'prev_img'	=> $prevImg,
            'caption'	=> $attachments[$i]->post_excerpt
        );

    endfor;

    return $output;

}

function fpr_theme_grab_url(){
    if( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', get_the_content(), $links ) ){
        return false;
    }
    return esc_url_raw( $links[1] );
}

function fpr_theme_grab_current_uri(){

    $http = ( isset( $_SERVER["HTTP"] ) ? 'https://' : 'http://' );
    $referer = $http . $_SERVER["HTTP_HOST"];
    $archive_url = $referer . $_SERVER["REQUEST_URI"];

    return $archive_url;
}

/*
   =====================================
        SINGLE POST CUSTOM FUNCTIONS
   =====================================
*/
function fpr_theme_post_navigation(){

    $nav = '';


    $nav =  '<div class="row">';

    $prev = get_previous_post_link( '<div class="post-link-nav"><span class="fpr_theme-icon fpr_theme-chevron-left" aria-hidden="true"></span>%link</div>', '%title' );
    $nav .=  '<div class="col-xs-12 col-sm-6">' . $prev . '</div>';

    $next = get_next_post_link( '<div class="post-link-nav">%link<span class="fpr_theme-icon fpr_theme-chevron-right" aria-hidden="true"></span></div>', '%title' );
    $nav .=  '<div class="col-xs-12 col-sm-6 text-right">' . $next . '</div>';

    $nav .=  '</div>';


    return $nav;

}

function fpr_theme_share_this( $content ){

    if( is_single() ) {

        $content .= '<div class="fpr_theme-shareThis"><h4>Share this</h4>';

        $title = get_the_title();
        $permalink = get_permalink();

        $twitterHandler = (get_option('twitter_handler') ? '&amp;via=' . esc_attr(get_option('twitter_handler')) : '');

        $twitter = 'https://twitter.com/intent/tweet?text=Hey!Read This:' . $title . '&amp;url=' . $permalink . $twitterHandler . '';
        $facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $permalink;
        $google = 'https://plus.google.com/share?url=' . $permalink;

        //echo $twitter;
        //echo $facebook;
        //echo $google;


        $content .= '<ul>';
        $content .= '<li><a href="' . $twitter . '" rel="nofollow" target="_blank"><span class="fpr_theme-icon fpr_theme-twitter"></span></a></li>';
        $content .= '<li><a href="' . $facebook . '" rel="nofollow" target="_blank"><span class="fpr_theme-icon fpr_theme-facebook"></span></a></li>';
        $content .= '<li><a href="' . $google . '" rel="nofollow" target="_blank"><span class="fpr_theme-icon fpr_theme-google-plus"></span></a></li>';
        $content .= '</ul></div><!--.fpr_theme-share-->';

        return $content;
    }else{
        return $content;
    }
}
add_filter('the_content', 'fpr_theme_share_this');

function fpr_theme_get_post_navigation(){

    //if( get_comment_pages_count() > 1 && get_option( 'page_comments' )):

        require ( get_template_directory() . '/inc/templates/fpr_theme-comment-nav.php' );

   // endif;

}


/*
   =====================================
        POPULAR POST CUSTOM FUNCTIONS
   =====================================
*/

function fpr_theme_popular_posts_number_comments(){

    $comments_num = get_comments_number();

    if( comments_open() ){
        //get comments link
        if( $comments_num == 0 ){
            $comments = __('No Comments');
        }elseif ( $comments_num > 1 ) {

            $comments = $comments_num . __(' Comments');
        }else{
            $comments = __('1 Comment');
        }
        $comments = '<a class="comments-link" href="' . get_comments_link() . '">'
            . $comments . ' <span class="fpr_theme-icon fpr_theme-comment"></span></a>';
    }else{
        $comments = _('Comments are closed');
    }


    return '<div class="post-footer-container"><div class="row"><div class="col-xs-12 style-comments">' . $comments . '</div></div></div>';
}
















