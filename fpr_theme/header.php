<?php
    /*
        This is the tamplate for the header

        @package fpr_theme
    */
?>
    <!doctype html>
    <html <?php language_attributes(); ?>>
        <head>
            <title><?php bloginfo('name'); wp_title(); ?></title>
            <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
            <meta content="utf-8" http-equiv="encoding">
            <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
            <meta name="description" content="<?php bloginfo('description'); ?>">
            <meta charset="<?php bloginfo( 'charset' ); ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="profile" href="http://gmpg.org/xfn/11">
            <?php if( is_singular() && pings_open( get_queried_object() ) ): ?>
                    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
            <?php endif; ?>
            <?php wp_head(); ?>
            <?php
            $custom_css = esc_attr(get_option('fpr_theme_css'));
            if( !empty( $custom_css ) ):
            echo  '<style>' . $custom_css . '</style>';
            endif;
            ?>
        </head>
    <body <?php body_class(); ?>>

    <div class="loader">
        <div class="loader_inner"></div>
    </div>

        <div class="fpr_theme-sidebar sidebar-closed">

            <div class="fpr_theme-sidebar-container">

                <a class="js-toggleSidebar sidebar-close">
                    <span class="fpr_theme-icon fpr_theme-close"></span>
                </a>

                <div class="sidebar-scroll">

                    <?php get_sidebar(); ?>

                </div><!--.sidebar-scroll-->

            </div><!--.fpr_theme-sidebar-container-->

        </div><!--.fpr_theme-sidebar-->

        <div class="sidebar-overlay js-toggleSidebar"></div>

        <div class="container-fluid">

            <div class="row">


                 <header class="header-container background-image text-center" style="background-image: url(<?php header_image(); ?>);">

                     <a class="js-toggleSidebar sidebar-open">
                         <span class="fpr_theme-icon fpr_theme-menu"></span>
                     </a>

                       <div class="header-content table">
                           <div class="table-cell">
                                 <h1 class="site-title fpr_theme-icon">
                                     <span class="fpr_theme-logo"></span>
                                     <span class="hide"><?php bloginfo( 'name' ); ?></span>
                                 </h1><!--.site-title-->
                                 <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2><!--.site-description-->
                             </div><!--.table-cell-->
                       </div><!--.header-content table-->
                       <div class="nav-container">
                           <nav class="navbar navbar-default navbar_fpr_theme">
                                 <?php
                                   wp_nav_menu( array(
                                         'theme_location'    => 'primary',
                                         'container'         => false,
                                         'menu_class'        => 'nav navbar-nav',
                                         'walker'            => new fpr_theme_Walker_Nav_Primary(),
                                     ) );
                                 ?>
                             </nav>
                       </div><!--.nav-container-->
                 </header><!--.header-container-->


            </div><!--.row-->

        </div><!--.container-->

























