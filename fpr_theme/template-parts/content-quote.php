<?php
/*

@package fpr_theme
--Quote Post Format

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fpr_theme-format-quote'); ?>>
    <header class="entry-header text-center">

        <div class="row">
            <div class="col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">

                <h1 class="quote-content"><a href="<?php esc_url(the_permalink()); ?>" rel="bookmark"><?php echo get_the_content(); ?></a></h1>
                <?php the_title( '<h2 class="quote-author">- ', ' -</h2>'); ?>

            </div><!--.col-md-8-->
        </div><!--.row-->

    </header>



    <footer class="entry-footer">
        <?php echo fpr_theme_posted_footer(); ?>
    </footer>

</article>
