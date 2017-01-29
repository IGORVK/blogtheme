<?php
/*
    @package fpr_theme
*/

if( ! is_active_sidebar( 'fpr_theme-sidebar' ) ){
    return;
}?>
<aside id="secondary" class="widget_area" role="complementary">

    <?php dynamic_sidebar( 'fpr_theme-sidebar' ); ?>

</aside>


