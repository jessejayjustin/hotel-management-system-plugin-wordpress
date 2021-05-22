<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-8">
			<form action="" id="manage-room">
				<div class="card">
					<div class="card-header">
						    Room Form
				  	</div>
					<div class="card-body">
							<input type="hidden" id="id" name="id">
							<div class="form-group">
								<label class="control-label">Room</label>
								<input type="text" class="form-control" id="room" name="room">
							</div>
							<div class="form-group">
								<label class="control-label">Category</label>
								<select class="custom-select browser-default" id="category_id" name="category_id">
									<?php 
									$cat = $wpdb->get_results("SELECT * FROM wp_room_categories order by name asc", ARRAY_A);
									foreach($cat as $row) {
										$cat_name[$row['id']] = $row['name'];
										?>
										<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Availability</label>
								<select class="custom-select browser-default" id="status" name="status">
									<option value="0">Available</option>
									<option value="1">Unavailable</option>

								</select>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$j('#manage-room').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Modal -->
			<?php
			   include($_SERVER['DOCUMENT_ROOT'] .'/wordpress/wp-content/plugins/hotel-booking/admin/modal.php');
			?>

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Category</th>
									<th class="text-center">Room</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$rooms = $wpdb->get_results("SELECT * FROM wp_rooms order by id asc", ARRAY_A);
								foreach($rooms as $row) {
                                ?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
			
									<td class="text-center"><?php echo $cat_name[$row['category_id']] ?></td>
									<td class=""><?php echo $row['room'] ?></td>
									<?php if($row['status'] == 0): ?>
										<td class="text-center"><span class="badge badge-success">Available</span></td>
									<?php else: ?>
										<td class="text-center"><span class="badge badge-default">Unavailable</span></td>
									<?php endif; ?>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_cat" type="button" data-id="<?php echo $row['id'] ?>" data-room="<?php echo $row['room'] ?>" data-category_id="<?php echo $row['category_id'] ?>" data-status="<?php echo $row['status'] ?>">Edit</button>
										<button style="margin-top: 6px;" class="btn btn-sm btn-danger delete_cat" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
			<!-- Table Panel -->
		</div>
	</div>	
</div>

<script>
var $j = jQuery.noConflict();

$j(document).ready(function() {
	$j('#manage-room').submit(function(e) {
		e.preventDefault();
		start_load();
		$j.ajax({
			url:'http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/save_room.php?action=save_room',
			method:"POST",
			data:
			{
		        id: $j("#id").val(),
		        room: $j("#room").val(),
		        category_id: $j("#category_id").val(),
		        status: $j("#status").val()
		    },
			success:function(resp){
				console.log(resp);
				if(resp==1){
					alert_toast("Data successfully added",'success');
					setTimeout(function(){
						location.reload()
					},1500);
				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success');
					setTimeout(function(){
						location.reload()
					},1500);
				}
			}
		})
	});
	$j('.edit_cat').click(function(){
		start_load();
		var cat = $j('#manage-room');
		cat.get(0).reset();
		cat.find("[name='id']").val($j(this).attr('data-id'));
		cat.find("[name='room']").val($j(this).attr('data-room'));
		cat.find("[name='category_id']").val($j(this).attr('data-category_id'));
		cat.find("[name='status']").val($j(this).attr('data-status'));
		end_load();
	});
	$j('.delete_cat').click(function(){
		var id = $j(this).attr('data-id');
		$j('#confirm_modal .modal-body').html("Are you sure to delete this category?")
	    $j('#confirm_modal').modal('show');
        confirm_del(id);
	});
	function confirm_del($id) {
		$j('#confirm').click(function(){
			delete_cat($id);
			$j('#confirm_modal').modal('hide');
		});
    }
	function delete_cat($id){
		start_load();
		$j.ajax({
			url:'http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/delete_room.php?action=delete_room',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					setTimeout(function(){
						location.reload()
					},1500);

				}
			}
		});
	}
	
	window.start_load = function(){
       $j('body').prepend('<div id="preloader2"></div>');
    }
    window.end_load = function(){
        $j('#preloader2').fadeOut('fast', function() {
          $j(this).remove();
        });
    }
});
</script>