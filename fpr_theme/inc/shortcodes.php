<?php
/*
 * @package fpr_theme
   =====================================
        SHORT CODE OPTIONS
   =====================================
*/
function fpr_theme_tooltip( $atts, $content = null  ){

    //get the attributes
    $atts = shortcode_atts(
        array(
            'placement' => 'top',
            'title' => '',
        ),
        $atts,
        'tooltip'
    );

    $title = ( $atts['title'] == '' ? $content : $atts['title']);

    //return HTML
    return '<span  class="fpr_theme_tooltip" data-toggle="tooltip" data-placement="'.$atts['placement'].'" title="' . $title . '">'. $content .'</span>';


}

add_shortcode( 'tooltip', 'fpr_theme_tooltip' );

/*
    [tooltip placement="top"  title="This is the title"]This is the content[/tooltip]
*/




function fpr_theme_popover( $atts, $content = null  ){
    /*
    [popover  placement="top" title="This is the title"  trigger="click"  content="This is the Popover content"]This is the clickable content[/popover]
*/
    //get the attributes
    $atts = shortcode_atts(
        array(
            'placement' => 'top',
            'title' => '',
            'trigger' => 'click',
            'content' => ''
        ),
        $atts,
        'popover'
    );


    //return HTML
    return '<span class="fpr_theme_popover" data-toggle="popover" data-placement="' . $atts['placement']
        . '" title="'. $atts['title'] .'" data-trigger="' . $atts['trigger'] . '" data-content="' . $atts['content'] . '">'. $content .'</span>';

}

add_shortcode( 'popover', 'fpr_theme_popover' );

/*
    [popover  placement="top" title="This is the title"  trigger="click"  content="This is the Popover content"]This is the clickable content[/popover]
*/
/*
 <button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-trigger="click"
data-content="And here's some amazing content. It's very engaging. Right?">Click to toggle popover</button>
 */


// Contact Form shortcode
function fpr_theme_contact_form( $atts, $content = null  ){

    //get the attributes
    $atts = shortcode_atts(
        array(),
        $atts,
        'contact_form'
    );


    //return HTML
    ob_start();
    @include 'templates/contact-form.php';
    return ob_get_clean();


}

add_shortcode( 'contact_form', 'fpr_theme_contact_form' );

/*
    [contact_form]
*/