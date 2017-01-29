<?php

/*
@package fpr_theme
   =====================================
            THEME CUSTOM POST TYPES
   =====================================
*/

$contact = get_option( 'activate_contact' );
if( @$contact == 1 ){

    add_action( 'init', 'fpr_theme_contact_custom_post_type');

    add_filter( 'manage_fpr_theme-contact_posts_columns', 'fpr_theme_set_contact_columns' );
    add_action( 'manage_fpr_theme-contact_posts_custom_column', 'fpr_theme_contact_custom_column', 10, 2);

    add_action( 'add_meta_boxes', 'fpr_theme_contact_add_meta_box');
    add_action( 'save_post', 'fpr_theme_save_contact_email_data' );

}
/* CONTACT Custom Post Type */
function fpr_theme_contact_custom_post_type(){
    $labels = array(
        'name'              => 'Messages',
        'singular_name'     => 'Message',
        'menu_name'         => 'Messages',
        'name_admin_bar'    => 'Messages',
    );

    $args = array(
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'capability_type'   => 'post',
        'hierarchical'      => false,
        'menu_position'     => 26,
        'menu_icon'         => 'dashicons-email-alt',
        'supports'          => array( 'title', 'editor', 'author' )
    );

    register_post_type( 'fpr_theme-contact', $args );
}

function fpr_theme_set_contact_columns( $columns ){

    $newColumns = array();
    $newColumns['title'] = 'Full Name';
    $newColumns['message'] = 'Message';
    $newColumns['email'] = 'Email';
    $newColumns['date'] = 'Date';

    return $newColumns;
}

function fpr_theme_contact_custom_column( $column, $post_id ){

    switch ( $column ){

        case 'message':
            echo get_the_excerpt();
            break;
        case 'email':
            $email = get_post_meta( $post_id, '_contact_email_value_key', true);
            echo '<a href="mailto:' . $email . '">' . $email . '</a>';
            break;
    }

}

/* CONTACT META BOXES */

function fpr_theme_contact_add_meta_box(){
    add_meta_box( 'contact_email', 'User Email', 'fpr_theme_contact_email_callback', 'fpr_theme-contact' , 'side' );
}

function fpr_theme_contact_email_callback( $post ){
    wp_nonce_field( 'fpr_theme_save_contact_email_data', 'fpr_theme_contact_email_meta_box_nonce' );

    $value = get_post_meta( $post->ID, '_contact_email_value_key', true);

    echo '<label for="fpr_theme_contact_email_field">User Email Adress: </label>';
    echo '<input type="email" id="fpr_theme_contact_email_field" name="fpr_theme_contact_email_field" value="' . esc_attr( $value ) . '">';
}

function fpr_theme_save_contact_email_data( $post_ID ){

    if( ! isset( $_POST['fpr_theme_contact_email_meta_box_nonce'] ) ){
        return;
    }

    if ( ! wp_verify_nonce($_POST['fpr_theme_contact_email_meta_box_nonce'] , 'fpr_theme_save_contact_email_data' ) ){
        return;
    }

    if (  defined('DOING_AUTOSAVE')&& DOING_AUTOSAVE ){
        return;
    }

    if ( ! current_user_can( 'edit_post' , $post_ID )){
        return;
    }

    if( ! isset( $_POST['fpr_theme_contact_email_field'] ) ){
        return;
    }

    $my_data = sanitize_text_field($_POST['fpr_theme_contact_email_field']);

    update_post_meta($post_ID, '_contact_email_value_key', $my_data );
}