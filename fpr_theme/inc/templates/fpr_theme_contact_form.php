<h1>FPR Theme Support</h1>
<?php settings_errors(); ?>
<?php
//$picture = esc_attr(get_option( 'profile_picture' ));
?>

<p>Use this <strong>shortcode</strong> to activate the Contact Form inside a page or a Post</p>
<p><code>[contact_form]</code></p>

<form action="options.php" method="post" class="fpr_theme-general-form" >
    <?php settings_fields( 'fpr_theme-contact-options' ); ?>
    <?php do_settings_sections( 'igor_fpr_theme_contact_form' ); ?>
    <?php submit_button(); ?>
</form>
