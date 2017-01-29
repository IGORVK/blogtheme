<?php
/*

@package fpr_theme
--Gallery Post Format

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'fpr_theme-format-gallery' ); ?>>
    <header class="entry-header text-center">

       <?php  if(fpr_theme_get_attachment()) :


           // var_dump($attachments);
           ?>
           <div id="post-gallery-<?php the_ID(); ?>" class="carousel slide fpr_theme-carousel-thumb" data-ride = "carousel">

               <div class="carousel-inner" role="listbox">

                   <?php

                   $attachments = fpr_theme_get_bs_slides( fpr_theme_get_attachment(7) );
                   foreach( $attachments as $attachment ):
                       ?>

                       <div class="item<?php echo $attachment['class']; ?> background-image standard-featured" style="background-image: url( <?php echo $attachment['url']; ?> );">

                           <div class="hide next-image-preview" data-image="<?php echo $attachment['next_img']; ?>"></div>
                           <div class="hide prev-image-preview" data-image="<?php echo $attachment['prev_img']; ?>"></div>

                           <div class="entry-excerpt image-caption">
                               <p><?php echo $attachment['caption']; ?></p>
                           </div>

                       </div>

                   <?php endforeach; ?>

               </div><!--.carousel-inner-->

               <a class="carousel-control left" href="#post-gallery-<?php the_ID(); ?>" role="button" data-slide="prev">
                  <div class="table">
                      <div class="table-cell">

                          <div class="preview-container">
                                <span class="thumbnail-container background-image"></span>
                                <span class="fpr_theme-icon fpr_theme-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                          </div><!--.preview-container-->

                      </div><!--.table-cell-->
                  </div><!--.table-->
               </a>
               <a class="carousel-control right" href="#post-gallery-<?php the_ID(); ?>" role="button" data-slide="next">
                   <div class="table">
                       <div class="table-cell">

                           <div class="preview-container">
                                <span class="thumbnail-container background-image"></span>
                                <span class="fpr_theme-icon fpr_theme-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                           </div><!--.preview-container-->

                       </div><!--.table-cell-->
                   </div><!--.table-->
               </a>

           </div><!--.carousel-->


        <?php endif; ?>



        <?php the_title( '<h1 class="entry-title"><a href="'. esc_url( get_permalink() ).'" rel="bookmark">', '</a></h1>'); ?>

        <div class="entry-meta">
            <?php echo fpr_theme_posted_meta(); ?>
        </div>

    </header>

    <div class="entry-content">

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
