<?php
/*

@package fpr_theme
--Video Post Format

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'fpr_theme-format-video' ); ?>>


    <header class="entry-header text-center">

        <div class="embed-responsive embed-responsive-16by9">
            <?php echo fpr_theme_get_embedded_media( array( 'video' , 'iframe') ); ?>
        </div>

        <?php the_title( '<h1 class="entry-title"><a href="'. esc_url( get_permalink() ).'" rel="bookmark">', '</a></h1>'); ?>

        <div class="entry-meta">
            <?php echo fpr_theme_posted_meta(); ?>
        </div>

    </header>

    <div class="entry-content">

        <?php if( has_post_thumbnail() ):
            $featured_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
            ?>

            <a href="<?php esc_url(the_permalink()); ?>" class="standart-featured-link">
                <div class="standard-featured background-image" style="background-image: url(<?php echo $featured_image; ?>);"></div>
            </a>
        <?php endif; ?>

        <div class="entry-excerpt">
            <?php the_excerpt(); ?>
        </div><!--.entry-excerpt-->
        <div class="button-container text-center">
            <a href="<?php esc_url(the_permalink()); ?>" class="btn btn-fpr_theme"><?php _e( 'Read More' ); ?></a>
        </div>

    </div><!--.entry-content-->

    <footer class="entry-footer">
        <?php echo fpr_theme_posted_footer(); ?>
    </footer>

</article>
