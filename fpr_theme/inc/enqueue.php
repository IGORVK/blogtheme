<?php

/*
@package fpr_theme
   =====================================
          ADMIN ENQUEUE FUNCTIONS
   =====================================
*/

function fpr_theme_load_admin_scripts( $hook ){
    // echo '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t' . $hook;

    //register css admin section
    wp_enqueue_style('raleway-admin', 'https://fonts.googleapis.com/css?family=Raleway:200,300,500');
    wp_register_style('fpr_theme_admin', get_template_directory_uri() . '/css/fpr_theme.admin.css', array(), '1.0.0', 'all');

    //register js admin section
    wp_register_script('fpr_theme_admin_script', get_template_directory_uri() . '/js/fpr_theme.admin.js', array('jquery'), '1.0.0', true);

    $pages_array = array(
        'toplevel_page_igor_fpr_theme' ,
        'fpr-theme_page_igor_fpr_theme_theme',
        'fpr-theme_page_igor_fpr_theme_contact_form',
    );

    if( in_array( $hook, $pages_array  )){
        wp_enqueue_style('raleway-admin');
        wp_enqueue_style('fpr_theme_admin');



    }

    if ( 'toplevel_page_igor_fpr_theme' == $hook ){

        wp_enqueue_media();
        wp_enqueue_script('fpr_theme_admin_script');

    }

    if ('fpr-theme_page_igor_fpr_theme_css' == $hook){



        wp_enqueue_style('ace', get_template_directory_uri() . '/css/fpr_theme.ace.css', array(), '1.0.0', 'all');
        wp_enqueue_script('ace', get_template_directory_uri().'/js/ace/ace.js', array('jquery'), '1.2.5', true );
        wp_enqueue_script('fpr_theme-custom-css-script', get_template_directory_uri().'/js/fpr_theme.custom-css.js', array('jquery'), '1.0.0', true );
    }

}
add_action( 'admin_enqueue_scripts', 'fpr_theme_load_admin_scripts' );



/*
@package fpr_theme
   =====================================
          FRONT-END ENQUEUE FUNCTIONS
   =====================================
*/

function fpr_theme_load_scripts(){
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7', 'all');
        wp_enqueue_style('fpr_theme', get_template_directory_uri() . '/css/fpr_theme.css', array(), '1.0.0', 'all');
        wp_enqueue_style('raleway', 'https://fonts.googleapis.com/css?family=Raleway:200,300,500');

        wp_deregister_script('jquery');
        wp_register_script('jquery',  get_template_directory_uri().'/js/jquery.min.js', false, '1.12.4', true);
        wp_enqueue_script('jquery');

        wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'), '3.3.7', true );
        wp_enqueue_script('fpr_theme', get_template_directory_uri().'/js/fpr_theme.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'fpr_theme_load_scripts' );




























