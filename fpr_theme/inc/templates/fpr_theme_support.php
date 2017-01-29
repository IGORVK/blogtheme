<h1>FPR Theme Support</h1>
<?php settings_errors(); ?>
<?php
//$picture = esc_attr(get_option( 'profile_picture' ));


?>



<form action="options.php" method="post" class="fpr_theme-general-form" >
    <?php settings_fields( 'fpr_theme-theme-support' ); ?>
    <?php do_settings_sections( 'igor_fpr_theme_theme' ); ?>
    <?php submit_button(); ?>
</form>
