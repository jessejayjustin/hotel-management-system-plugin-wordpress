<?php
    define( 'SHORTINIT', true );
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-load.php' );
    //require_once('http://localhost/wordpress/wp-load.php');
    global $wpdb;

    $cid = $_POST['cid'];
    $rid = $_POST['rid'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $date_in = $_POST['date_in'];
    $date_in_time = $_POST['date_in_time'];
    $days = $_POST['days'];

	$data = " booked_cid = '$cid' ";
    $data .= ", name = '$name' ";
    $data .= ", contact_no = '$contact' ";
    $data .= ", status = 0 ";

    $data .= ", date_in = '".$date_in.' '.$date_in_time."' ";
    $out= date("Y-m-d H:i",strtotime($date_in.' '.$date_in_time.' +'.$days.' days'));
    $data .= ", date_out = '$out' ";
	$i = 1;
	while($i== 1){
		$ref  = sprintf("%'.04d\n",mt_rand(1,9999999999));
		$wpdb->get_results("SELECT * FROM wp_checked where ref_no ='$ref'");
	    if($wpdb->num_rows <= 0)
        $i=0;
	}
	$data .= ", ref_no = '$ref' ";

		$save = $wpdb->query("INSERT INTO wp_checked set ".$data);
		$id=$wpdb->insert_id;
	
	if($save){
	   echo 1;
	}
?>
