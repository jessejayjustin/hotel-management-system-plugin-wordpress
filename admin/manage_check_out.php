<?php 
define( 'SHORTINIT', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-load.php' );
global $wpdb;
ob_start();

if($_GET['id']){
	$id = $_GET['id'];
	$qry = $wpdb->get_results("SELECT * FROM wp_checked where id =".$id, ARRAY_A);
	if($wpdb->num_rows > 0){
		foreach($qry as $k => $v){
			$$k=$v;
		}
	}
	$room_id = $$k['room_id'];
	$booked_cid = $$k['booked_cid'];
	//var_dump($booked_cid);
	if($room_id > 0){
		$room = $wpdb->get_results("SELECT * FROM wp_rooms where id =".$room_id, ARRAY_A);
		$cat = $wpdb->get_results("SELECT * FROM wp_room_categories where id =".$room['category_id'], ARRAY_A);
	}else{
		$cat = $wpdb->get_results("SELECT * FROM wp_room_categories where id =".$booked_cid, ARRAY_A);
	}
	foreach($cat as $row){
	}
	$calc_days = abs(strtotime($$k['date_out']) - strtotime($$k['date_in'])); 
	$calc_days =floor($calc_days / (60*60*24)  );
}
?>
<style>
	.container-fluid p{
		margin: unset
	}
	#uni_modal .modal-footer{
		display: none;
	}
</style>
<div class="container-fluid">
	<p><b>Room : </b><?php echo isset($room['room']) ? $room['room'] : 'NA' ?></p>
	<p><b>Room Category : </b><?php echo $row['name'] ?></p>
	<p><b>Room Price : </b><?php echo '$'.number_format($row['price'],2) ?></p>
	<p><b>Reference no : </b><?php echo $$k['ref_no'] ?></p>
	<p><b>Checked In : </b><?php echo $$k['name'] ?></p>
	<p><b>Contact no : </b><?php echo $$k['contact_no'] ?></p>
	<p><b>Check-in Date/Time : </b><?php echo date("M d, Y h:i A",strtotime($$k['date_in'])) ?></p>
	<p><b>Check-out Date/Time : </b><?php echo date("M d, Y h:i A",strtotime($$k['date_out'])) ?></p>
	<p><b>Days : </b><?php echo $calc_days ?></p>
	<p><b>Amount (Price * Days) : </b><?php echo '$'.number_format($row['price'] * $calc_days ,2) ?></p>
	
		<div class="row">
			<?php if(isset($_GET['checkout']) && $$k['status'] != 2): ?>
				<div class="col-md-3">
					<button type="button" class="btn btn-primary" id="checkout">Checkout</button>
				</div>
				<div class="col-md-3">
					<button type="button" class="btn btn-primary" id="edit_checkin">Edit</button>
				</div>
		<?php endif; ?>	
				<div class="col-md-3">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
		
		</div>
</div>
<script>
	$j('#edit_checkin').click(function(){
		uni_modal("Edit Check In","http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/manage_check_in.php?id=<?php echo $id ?>&rid=<?php echo $room_id ?>");
	});
	$j('#checkout').click(function(){
		start_load()
		$j.ajax({
			url:'ajax.php?action=save_checkout',
			method:'POST',
			data:{id:'<?php echo $id ?>',rid:'<?php echo $room_id ?>'},
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	});
</script>