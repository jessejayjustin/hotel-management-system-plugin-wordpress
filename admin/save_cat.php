<?php
    define( 'SHORTINIT', true );
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-load.php' );
    global $wpdb;
	ob_start();
	
	$action = $_GET['action'];

    $name = $_POST['name'];
    $price = $_POST['price'];
    $id = $_POST['id'];
    $filename = $_FILES['img']['name'];

    $data = " name = '$name' ";
	$data .= ", price = '$price' ";
	if($_FILES['img']['tmp_name'] != ''){
					$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
					$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
				$data .= ", cover_img = '$fname' ";
	}
	if(empty($id)){
		$save = $wpdb->query("INSERT INTO wp_room_categories set ".$data);
	}else{
		$save = $wpdb->query("UPDATE wp_room_categories set ".$data." where id=".$id);
		echo 2;
	}
	if($save) {
		echo 1;
	}

?>