<h1>FPR Theme Options</h1>
<?php settings_errors(); ?>
<?php
    $picture = esc_attr(get_option( 'profile_picture' ));
    $firstName = esc_attr(get_option( 'first_name' ));
    $lastName = esc_attr(get_option( 'last_name' ));
    $fullName = $firstName . ' ' . $lastName;
    $description = esc_attr(get_option( 'user_description' ));

    $twitter_icon = esc_attr(get_option('twitter_handler'));
    $facebook_icon = esc_attr(get_option('facebook_handler'));
    $gplus_icon = esc_attr(get_option('gplus_handler'));
?>

<div class="fpr_theme-sidebar-preview">
    <div class="fpr_theme-sidebar">
        <div class="image-container">
            <div id="profile-picture-preview" class="profile-picture" style="background-image: url( <?php print $picture ?> );"></div>
        </div>
        <h1 class="fpr_theme-username"><?php print $fullName; ?></h1>
        <h2 class="fpr_theme-description"><?php print $description; ?></h2>
        <div class="icons-wrapper">
            <?php if( !empty( $twitter_icon ) ): ?>
                <span class="fpr_theme_icon_sidebar dashicons-before dashicons-twitter"></span>
            <?php endif; ?>
            <?php if( !empty( $facebook_icon ) ): ?>
                <span class="fpr_theme_icon_sidebar dashicons-before dashicons-facebook-alt fpr_theme_icon_sidebar__facebook"></span>
            <?php endif; ?>
            <?php if( !empty( $gplus_icon ) ): ?>
                <span class="fpr_theme_icon_sidebar dashicons-before dashicons-googleplus"></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<form action="options.php" method="post" class="fpr_theme-general-form" >
    <?php settings_fields( 'fpr_theme-settings-group' ); ?>
    <?php do_settings_sections( 'igor_fpr_theme' ); ?>
    <?php submit_button( 'Save Changes', 'primary', 'btnSubmit' ); ?>
</form>
