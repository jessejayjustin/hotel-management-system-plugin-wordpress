<?php
    define( 'SHORTINIT', true );
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-load.php' );
    global $wpdb;
	ob_start();
	
	$action = $_GET['action'];
    $id = $_POST['id'];

    $delete = $wpdb->query("DELETE FROM wp_room_categories where id = ".$id);
    if($delete) {
       echo 1;
    }

?>