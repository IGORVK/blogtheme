<nav  class="comment-navigation" role="navigation">
    <h3><?php esc_html_e( 'Comment navigation', 'fpr_theme' ) ?></h3>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="post-link-nav">
                <span class="fpr_theme-icon fpr_theme-chevron-left" aria-hidden="true"></span>
                <?php previous_comments_link( esc_html__( 'Older Comments', 'fpr_theme' ) ) ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 text-right">
            <div class="post-link-nav">
                <?php next_comments_link( esc_html__( 'Newer Comments', 'fpr_theme' ) ) ?>
                <span class="fpr_theme-icon fpr_theme-chevron-right" aria-hidden="true"></span>
            </div>
        </div>
    </div><!--.row-->

</nav>