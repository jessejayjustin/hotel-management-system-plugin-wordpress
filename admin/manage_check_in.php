<?php 
define( 'SHORTINIT', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-load.php' );
global $wpdb;
ob_start();

$rid = $_GET['rid'];
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$qry = $wpdb->get_results("SELECT * FROM wp_checked where id =".$id, ARRAY_A);
	if($wpdb->num_rows > 0){
		foreach($qry as $k => $v){
			$meta[$k]=$v;
		}
	}
	$calc_days = abs(strtotime($meta[0]['date_out']) - strtotime($meta[0]['date_in'])) ; 
    $calc_days =floor($calc_days / (60*60*24)  );
    $cat = $wpdb->get_results("SELECT * FROM wp_room_categories", ARRAY_A);
	$cat_arr = array();
	foreach($cat as $row){
		$cat_arr[$row['id']] = $row;
	}
}

?>
<div class="container-fluid">
	
	<form action="" id="manage-check">
		<input type="hidden" name="id" id="id" value="<?php echo isset($meta[0]['id']) ? $meta[0]['id']: '' ?>">
		<?php if(isset($_GET['id'])):
			$rooms = $wpdb->get_results("SELECT * FROM wp_rooms where status=0 or id = $rid order by id asc", ARRAY_A);
		?>

		<div class="form-group">
			<label for="name">Room</label>
			<select name="rid" id="rid" class="custom-select browser-default">
				<?php 
				foreach($rooms as $row) {
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo $row['id'] == $rid ? "selected": '' ?>><?php echo $row['room'] . " | ". ($cat_arr[$row['category_id']]['name']) ?></option>
				<?php 
				  }
				?>
			</select>
		</div>

		<?php else: ?>
		<input type="hidden" name="rid" id="rid" value="<?php echo isset($_GET['rid']) ? $_GET['rid']: '' ?>">
		<?php endif; ?>


		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta[0]['name']) ? $meta[0]['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="contact">Contact #</label>
			<input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta[0]['contact_no']) ? $meta[0]['contact_no']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="date_in">Check-in Date</label>
			<input type="date" name="date_in" id="date_in" class="form-control" value="<?php echo isset($meta['date_in']) ? date("Y-m-d",strtotime($meta['date_in'])): date("Y-m-d") ?>" required>
		</div>
		<div class="form-group">
			<label for="date_in_time">Check-in Date</label>
			<input type="time" name="date_in_time" id="date_in_time" class="form-control" value="<?php echo isset($meta['date_in']) ? date("H:i",strtotime($meta['date_in'])): date("H:i") ?>" required>
		</div>
		<div class="form-group">
			<label for="days">Days of Stay</label>
			<input type="number" min="1" name="days" id="days" class="form-control" value="<?php echo isset($meta['date_in']) ? $calc_days: 1 ?>" required>
		</div>
	</form>
</div>
<script>
	$j('#manage-check').submit(function(e) {
		e.preventDefault();
		start_load()
		$j.ajax({
			url:'http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/save_check_in.php?action=save_check_in',
			method:'POST',
			data:
			{
		        id: $j("#id").val(),
		        rid: $j("#rid").val(),
		        name: $j("#name").val(),
		        contact: $j("#contact").val(),
		        date_in: $j("#date_in").val(),
		        date_in_time: $j("#date_in_time").val(),
		        days: $j("#days").val()
		    },
			success:function(resp){
				console.log(resp);
				if(resp > 0){
					//alert("Data successfully saved",'success')
					uni_modal("Check-in Details","http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/manage_check_out.php?id="+resp)
					setTimeout(function(){
					end_load()
					},1500)
				}
			}
		})
	});
</script>