<?php

/*
@package fpr_theme
   =====================================
                ADMIN PAGE
   =====================================
*/

function fpr_theme_add_admin_page(){

    //Generate FPR Theme Admin Page
    add_menu_page( 'FPR Theme Options', 'FPR Theme', 'manage_options',
        'igor_fpr_theme', 'fpr_theme_create_page',
        get_template_directory_uri() . '/img/fpr_theme-icon.png', 110);

    //Generate FPR Theme Admin Sub Page
    add_submenu_page('igor_fpr_theme', 'FPR Theme Options', 'General',
     'manage_options',  'igor_fpr_theme', 'fpr_theme_create_page' );
    add_submenu_page('igor_fpr_theme', 'FPR Theme Options', 'Theme Options',
        'manage_options',  'igor_fpr_theme_theme', 'fpr_theme_support_page' );
    add_submenu_page('igor_fpr_theme', 'FPR Theme Contact Form', 'Contact Form',
        'manage_options',  'igor_fpr_theme_contact_form', 'fpr_theme_contact_form_page' );
    add_submenu_page('igor_fpr_theme', 'FPR Theme CSS Options', 'Custom CSS',
        'manage_options',  'igor_fpr_theme_css', 'fpr_theme_settings_page' );


    //Activate custom settings
    add_action('admin_init', 'fpr_theme_custom_settings');


}
add_action( 'admin_menu', 'fpr_theme_add_admin_page' );




function fpr_theme_custom_settings(){
    //Sidebar Options
    register_setting('fpr_theme-settings-group', 'profile_picture');
    register_setting('fpr_theme-settings-group', 'first_name');
    register_setting('fpr_theme-settings-group', 'last_name');
    register_setting('fpr_theme-settings-group', 'user_description');
    register_setting('fpr_theme-settings-group', 'twitter_handler', 'fpr_theme_sanitize_twitter_handler');
    register_setting('fpr_theme-settings-group', 'facebook_handler');
    register_setting('fpr_theme-settings-group', 'gplus_handler');

    add_settings_section('fpr_theme-sidebar-options', 'Sidebar Option', 'fpr_theme_sidebar_options', 'igor_fpr_theme');

    add_settings_field( 'sidebar-profile-picture' , 'Profile Picture', 'fpr_theme_sidebar_profile', 'igor_fpr_theme', 'fpr_theme-sidebar-options' );
    add_settings_field( 'sidebar-name' , 'Full Name', 'fpr_theme_sidebar_name', 'igor_fpr_theme', 'fpr_theme-sidebar-options' );
    add_settings_field( 'sidebar-description' , 'Description', 'fpr_theme_sidebar_description', 'igor_fpr_theme', 'fpr_theme-sidebar-options' );
    add_settings_field('sidebar-twitter', 'Twitter handler', 'fpr_theme_sidebar_twitter', 'igor_fpr_theme', 'fpr_theme-sidebar-options');
    add_settings_field('sidebar-facebook', 'Facebook handler', 'fpr_theme_sidebar_facebook', 'igor_fpr_theme', 'fpr_theme-sidebar-options');
    add_settings_field('sidebar-gplus', 'Google+ handler', 'fpr_theme_sidebar_gplus', 'igor_fpr_theme', 'fpr_theme-sidebar-options');

    //Theme Support Options
    register_setting('fpr_theme-theme-support', 'post_formats');
    register_setting('fpr_theme-theme-support', 'custom_header');
    register_setting('fpr_theme-theme-support', 'custom_background');

    add_settings_section('fpr_theme-theme-options', 'Theme Options', 'fpr_theme_theme_options', 'igor_fpr_theme_theme');

    add_settings_field('post-formats', 'Post Formats', 'fpr_theme_post_formats', 'igor_fpr_theme_theme', 'fpr_theme-theme-options');
    add_settings_field('custom-header', 'Custom Header', 'fpr_theme_custom_header', 'igor_fpr_theme_theme', 'fpr_theme-theme-options');
    add_settings_field('custom-background', 'Custom Background', 'fpr_theme_custom_background', 'igor_fpr_theme_theme', 'fpr_theme-theme-options');

    //Contact Form Options
    register_setting( 'fpr_theme-contact-options', 'activate_contact');

    add_settings_section( 'fpr_theme-contact-section', 'Contact Form', 'fpr_theme_contact_section', 'igor_fpr_theme_contact_form' );

    add_settings_field( 'activate-form', 'Activate Contact Form', 'fpr_theme_activate_contact', 'igor_fpr_theme_contact_form', 'fpr_theme-contact-section' );

    //Custom CSS Options
    register_setting( 'fpr_theme-custom-css-options', 'fpr_theme_css', 'fpr_theme_sanitize_custom_css');

    add_settings_section( 'fpr_theme-custom-css-section', 'Custom CSS', 'fpr_theme_custom_css_section_callback', 'igor_fpr_theme_css' );

    add_settings_field( 'custom-css', 'Insert your Custom CSS', 'fpr_theme_custom_css_callback', 'igor_fpr_theme_css', 'fpr_theme-custom-css-section' );

}

//Post Formats Callback Function

function fpr_theme_custom_css_section_callback(){
    echo 'Customize your FPR Theme with your own CSS';
}

function fpr_theme_custom_css_callback(){
    $css = get_option( 'fpr_theme_css' );
    $css = ( empty($css) ? '/*FPR Theme Custom CSS*/' : $css );
    echo '<div id="customCss">'.$css.'</div><textarea id="fpr_theme_css" name="fpr_theme_css" style="display:none; visibility: hidden;">'.$css.'</textarea>';
}

function fpr_theme_theme_options(){
    echo 'Activate and Deactivate specific Theme Support Options';
}

function fpr_theme_contact_section(){
    echo 'Activate and Deactivate the Built-in Contact Form';
}

function fpr_theme_activate_contact(){
    $options = get_option( 'activate_contact' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="activate_contact" name="activate_contact" value="1" '.$checked.' /></label>';
}

function fpr_theme_post_formats(){
    $options = get_option( 'post_formats' );
    $formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
    $output = '';
    foreach ( $formats as $format ){
        $checked = ( @$options[$format] == 1 ? 'checked' : '' );
        $output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.' /> '.$format.'</label><br>';
    }
    echo $output;
}


function fpr_theme_custom_header(){
    $options = get_option( 'custom_header' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.' />Activate the Custom Header</label>';
}

function fpr_theme_custom_background(){
    $options = get_option( 'custom_background' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.' />Activate the Custom Background</label>';
}




//Sidebar Options Functions
function fpr_theme_sidebar_options(){
    echo 'Customize your Sidebar information';
}

function fpr_theme_sidebar_profile(){
    $picture = get_option('profile_picture');
    if ( empty($picture) ){
        echo '<button type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button"><span class="fpr_theme_icon_button_image dashicons-before dashicons-format-image"></span>Upload Profile Picture</button>
              <input type="hidden" name="profile_picture" value="" id="profile-picture">';

    }else{
        echo '<button type="button" class="button button-secondary" value="Replace Profile Picture" id="upload-button"><span class="fpr_theme_icon_button_image dashicons-before dashicons-format-image"></span>Replace Profile Picture</button>
              <input type="hidden" name="profile_picture" value="'.$picture.'" id="profile-picture">
              <button type="button" class="button button-secondary" value="Remove" id="remove-picture" ><span class="fpr_theme_icon_button dashicons-before dashicons-no"></span>Remove</button>';

    }
   }
function fpr_theme_sidebar_name(){
    $firstName = get_option('first_name');
    $lastName = get_option('last_name');
    echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name">
          <input type="text" name="last_name" value="'.$lastName.'" placeholder="Last Name">';
}
function fpr_theme_sidebar_description(){
    $description = get_option('user_description');
    echo '<input type="text" name="user_description" value="'.$description.'" placeholder="Description">
          <p class="description">Write something smart.</p>';
}
function fpr_theme_sidebar_twitter(){
    $twitter = get_option('twitter_handler');
    echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter handler">
          <p class="description">Input your Twitter username without the @ character.</p>';
}
function fpr_theme_sidebar_facebook(){
    $facebook = get_option('facebook_handler');
    echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook handler">';
}
function fpr_theme_sidebar_gplus(){
    $gplus = get_option('gplus_handler');
    echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Google+ handler">';
}


//Sanitization settings
function fpr_theme_sanitize_twitter_handler( $input ){
    $output = sanitize_text_field($input);
    $output = str_replace('@', '', $output);
    return $output;
}
function fpr_theme_sanitize_custom_css( $input ){
    $output = esc_textarea($input);
    return $output;
}

//Template submenu functions
function fpr_theme_create_page(){
        require_once ( get_template_directory() . '/inc/templates/fpr_theme_admin.php');
}

function fpr_theme_support_page(){
    require_once ( get_template_directory() . '/inc/templates/fpr_theme_support.php' );
}

function fpr_theme_contact_form_page(){
    require_once ( get_template_directory() . '/inc/templates/fpr_theme_contact_form.php' );
}

function fpr_theme_settings_page(){
    require_once ( get_template_directory() . '/inc/templates/fpr_theme_custom_css.php' );
}

