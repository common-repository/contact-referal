<?php

function cref_session_init() {
	if (!session_id()) {
        session_start();
    }
}
add_action( 'init', 'cref_session_init' );

function cref_session_start() {
	if(isset($_GET['id']) == NULL) {
		$_SESSION['cref_view'];
	} else {
		$_SESSION['cref_view'] = $_GET['id']; 
	}
}
add_action( 'init', 'cref_session_start' );
