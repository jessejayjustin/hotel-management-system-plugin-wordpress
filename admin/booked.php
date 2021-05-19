<?php 
$cat = $wpdb->get_results("SELECT * FROM wp_room_categories", ARRAY_A);
$cat_arr = array();
foreach($cat as $row){
	$cat_arr[$row['id']] = $row;
}
$room = $wpdb->get_results("SELECT * FROM wp_rooms", ARRAY_A);
$room_arr = array();
foreach($room as $row){
	$room_arr[$row['id']] = $row;
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row mt-3">
			<div class="col-md-12">
				<div class="card-container">
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th>#</th>
								<th>Category</th>
								<th>Reference</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody>
						    <?php 
								$checked = $wpdb->get_results("SELECT * FROM wp_checked where status = 0 order by status desc, id asc", ARRAY_A);
								foreach($checked as $row) {
								    $i=1;
								?>
								<tr>
									<td class="text-center"><?php echo $i++; ?></td>
									<td class="text-center"><?php echo $cat_arr[$row['booked_cid']]['name']; ?></td>
									<td class=""><?php echo $row['ref_no'] ?></td>
										<td class="text-center"><span class="badge badge-warning">Booked</span></td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary check_out" type="button" data-id="<?php echo $row['id']; ?>">View</button>
									</td>
								</tr>
							<?php 
							  }
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<?php
   include($_SERVER['DOCUMENT_ROOT'] .'/wordpress/wp-content/plugins/hotel-booking/admin/modal.php');
?>

<script>
	var $j = jQuery.noConflict();

    $j(document).ready(function() {
		$j('table').dataTable()
		$j('.check_out').click(function(){
			uni_modal("Check Out","http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/manage_check_out.php?checkout=1&id="+$j(this).attr("data-id"));
		});
		$j('#filter').submit(function(e){
			e.preventDefault()
			location.replace('index.php?page=check_in&category_id='+$j(this).find('[name="category_id"]').val()+'&status='+$j(this).find('[name="status"]').val());
		});
	});
</script>