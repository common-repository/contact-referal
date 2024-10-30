<?php 

function cref_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'style' => 'full'
	), $atts ) );

	$cr_code = the_widget( 'cref_Widget', array('widget_style' => $style), array('before_widget' => '<div class="cref_shortcode">', 'after_widget' => '</div>') );
	return $cr_code;
}
add_shortcode( 'c_referal', 'cref_shortcode' );