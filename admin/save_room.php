<?php
    define( 'SHORTINIT', true );
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-load.php' );
    global $wpdb;
	ob_start();

	$action = $_GET['action'];

    $id = $_POST['id'];
    $room = $_POST['room'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];

    $data = " room = '$room' ";
	$data .= ", category_id = '$category_id' ";
	$data .= ", status = '$status' ";
	if(empty($id)){
		$save = $wpdb->query("INSERT INTO wp_rooms set ".$data);
	}else{
		$save = $wpdb->query("UPDATE wp_rooms set ".$data." where id=".$id);
	}
	if($save) {
		echo 1;
	}

?>