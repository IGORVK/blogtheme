<?php
/*
@package fpr_theme
   =====================================
          AJAX FUNCTIONS
   =====================================
*/
add_action('wp_ajax_nopriv_fpr_theme_load_more', 'fpr_theme_load_more');
add_action('wp_ajax_fpr_theme_load_more', 'fpr_theme_load_more');

add_action('wp_ajax_nopriv_fpr_theme_save_user_contact_form', 'fpr_theme_save_contact');
add_action('wp_ajax_fpr_theme_save_user_contact_form', 'fpr_theme_save_contact');


function fpr_theme_load_more(){
    //load more posts

    $paged = $_POST["page"]+1;
    $prev = $_POST["prev"];
    $archive = $_POST["archive"];

    if( $prev == 1 && $_POST["page"] != 1 ){
        $paged = $_POST["page"]-1;
    }

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'paged' => $paged
    );

    if( $archive != '0' ){

        $archVal = explode( '/', $archive );
        $flipped = array_flip($archVal);

        switch( isset( $flipped ) ) {

            case $flipped["category"] :
                $type = "category_name";
                $key = "category";
                break;

            case $flipped["tag"] :
                $type = "tag";
                $key = $type;
                break;

            case $flipped["author"] :
                $type = "author";
                $key = $type;
                break;

        }

        $currKey = array_keys( $archVal, $key );
        $nextKey = $currKey[0]+1;
        $value = $archVal[ $nextKey ];

        $args[ $type ] = $value;




        //check page trail and remove "page" val
        if( isset( $flipped["page"] )  ){

            $pageVal = explode( 'page', $archive );
            $page_trail = $pageVal[0];
        } else {
            $page_trail = $archive;
        }


    } else {
        $page_trail = '/';
    }

    $query = new WP_Query( $args );

    if( $query->have_posts() ):

        echo '<div class="page-limit" data-page="' . $page_trail . 'page/' . $paged . '/">';

            while( $query->have_posts()): $query->the_post();

                get_template_part( 'template-parts/content', get_post_format() );

            endwhile;

        echo '</div>';

    else:

        echo 0;

    endif;

   wp_reset_postdata();


    die();//REALY IMPORTANT for AJAX  to call die(),because we need to close the connection!!!
}

function fpr_theme_check_paged( $num = null ){

    $output = '';

    if( is_paged() ){ $output = 'page/' . get_query_var( 'paged' ); }

    if( $num == 1 ) {
        $paged = ( get_query_var( 'paged' ) == 0 ? 1 : get_query_var( 'paged' ) );
        return $paged;
    }else{
        return $output;
    }
}

function fpr_theme_save_contact(){

    $title = wp_strip_all_tags( $_POST['name'] );
    $email = wp_strip_all_tags( $_POST['email'] );
    $message = wp_strip_all_tags( $_POST['message'] );

    $args = array(
        'post_title' => $title,
        'post_content' => $message,
        'post_author' => 1,
        'post_status' => 'publish',
        'post_type' => 'fpr_theme-contact',
        'meta_input' => array(
            '_contact_email_value_key' => $email
        )

    );


   $postID = wp_insert_post( $args );

   if( $postID !== 0 ) {

       $to = get_bloginfo('admin_email');
       $subject = 'FPR_theme Contact Form - ' . $title;
     
       $headers[] = 'From: ' . get_bloginfo('name') . ' <' . $to . '>'; //'From: Igor <me@example.com>'
       $headers[] .= 'Reply-to: ' . $title . ' <' .$email. '>';
       $headers[] .= 'Content-Type: text/html: charset=UTF-8';


       wp_mail( $to, $subject, $message, $headers);

       echo $postID;
   } else {
       echo 0;
   }

    die();//REALY IMPORTANT for AJAX  to call die(),because we need to close the connection!!!

}





































