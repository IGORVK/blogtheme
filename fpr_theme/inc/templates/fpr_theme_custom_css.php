<h1>FPR Theme Custom CSS</h1>
<?php settings_errors(); ?>

<form id="save-custom-css-form" action="options.php" method="post" class="fpr_theme-general-form" >
    <?php settings_fields( 'fpr_theme-custom-css-options' ); ?>
    <?php do_settings_sections( 'igor_fpr_theme_css' ); ?>
    <?php submit_button(); ?>
</form>