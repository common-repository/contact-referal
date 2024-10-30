<?php 

/*
Define Metabox
 */

function cref_metabox( array $meta_boxes) {
	$cr_meta_fields = array(
		array(
		'id' 	=> 'name',
		'name'	=>	__( 'Full Name', 'contact-reference' ),
		'type'	=> 'text'
		),
		array(
		'id' 	=> 'address',
		'name'	=>	__( 'Address', 'contact-reference' ),
		'type'	=> 'text'
		),
		array(
		'id' 	=> 'phone',
		'name'	=>	__( 'Phone', 'contact-reference' ),
		'type'	=> 'text'
		),
		array(
		'id' 	=> 'email',
		'name'	=>	__( 'Email', 'contact-reference' ),
		'type'	=> 'text'
		),
			
	);

	$meta_boxes[] = array(
		'title' => __('Referal Contact Detail', 'contact-reference'),
		'pages' => 'refcontact',
		'fields' => $cr_meta_fields
	);

	$cr_meta_social = array(

		array(
		'id' 	=> 'yahoo_messenger',
		'name'	=>	__( 'Yahoo Messenger', 'contact-reference' ),
		'type'	=> 'text'
		),
		array(
		'id' 	=> 'gplus',
		'name'	=>	__( 'Google Plus', 'contact-reference' ),
		'type'	=> 'text_url'
		),
		array(
		'id' 	=> 'facebook_url',
		'name'	=>	__( 'Facebook URL', 'contact-reference' ),
		'type'	=> 'text_url'
		),
		array(
		'id' 	=> 'twitter_username',
		'name'	=>	__( 'Twitter Username', 'contact-reference' ),
		'type'	=> 'text'
		),

	);

	$meta_boxes[] = array(
		'title' => __('Social Media', 'contact-reference'),
		'pages' => 'refcontact',
		'fields' => $cr_meta_social
	);

	$cr_meta_photo = array(

		array(
		'id' 	=> 'photo',
		'name'	=>	__( 'Photo', 'contact-reference' ),
		'type'	=> 'image'
		),

	);

	$meta_boxes[] = array(
		'title' => __('Contact Photo', 'contact-reference'),
		'pages' => 'refcontact',
		'context' => 'side',
		'fields' => $cr_meta_photo
	);

	return $meta_boxes;
}

add_filter( 'cmb_meta_boxes', 'cref_metabox' );