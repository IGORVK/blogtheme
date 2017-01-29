<?php
/*

@package fpr_theme
--Link Post Format

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fpr_them-format-link'); ?>>

    <header class="entry-header text-center">

        <?php
        $link = fpr_theme_grab_url();
            the_title( '<h1 class="entry-title"><a href="'. $link .'" target="_blank">', '<div class="link-icon"><span class="fpr_theme-icon fpr_theme-link"></span></div></a></h1>');
        ?>

    </header>

</article>
