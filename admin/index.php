<div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-body text-white">
  </div>
</div>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-5">
			<form action="" id="manage-category">
				<div class="card">
					<div class="card-header">
						Room Category Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Category</label>
								<input type="text" id="name" class="form-control" name="name" required>
							</div>
							<div class="form-group">
								<label class="control-label">Price</label>
								<input type="number" class="form-control text-right" name="price" step="any" required>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Image</label>
								<input type="file" class="form-control" id="file" name="img" onchange="displayImg(this,$j(this))" required>
							</div>
							<div class="form-group">
								<img src="" alt="" id="cimg" width="100px">
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$j('#manage-category').get(0).reset()"> Cancel</button>
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
			<div class="col-md-8">
				<div class="">
					<div class="">
						<br>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Img</th>
									<th class="text-center">Room</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 

							    global $wpdb;
							  
		                        $cats = $wpdb->get_results("SELECT * FROM wp_room_categories  order by id asc", ARRAY_A);
								foreach ($cats as $row) {	
                                 
								?>
								<tr>
									<td class="text-center"><?php echo $row['id'] ?></td>
								
									<td class="text-center">
										<img src='http://localhost/wordpress/wp-content/plugins/hotel-booking/assets/img/<?php echo $row['cover_img'] ?>' alt="" id="cimg" width="100px">
									</td>
									<td class="">
										<p>Name : <b><?php echo $row['name'] ?></b></p>
										<p>Price : <b><?php echo "$".number_format($row['price'],2) ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_cat" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-price="<?php echo $row['price'] ?>" data-cover_img="<?php echo $row['cover_img'] ?>">Edit</button>
										<button class="btn btn-sm btn-danger delete_cat" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
    function displayImg(input,_this) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $j('#cimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $j('#manage-category').submit(function(e){
        e.preventDefault()
        //start_load()
   
        $j.ajax({
          url: 'http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/save_cat.php?action=save_category',
          type: 'post',
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(resp){
	        if(resp==1){
	            alert("Data successfully added",'success');
	            $j('#manage-category').get(0).reset();
	            setTimeout(function(){
	              location.reload()
	            },1500)
	        }
	        else if(resp==2){
	            alert("Data successfully updated",'success');
	            $j('#manage-category').get(0).reset();
	            setTimeout(function(){
	              location.reload()
	            },1500)
	        }
	       }
	    });
    });
    $j('.edit_cat').click(function(){
		start_load()
		var cat = $j('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($j(this).attr('data-id'))
		cat.find("[name='name']").val($j(this).attr('data-name'))
		cat.find("[name='price']").val($j(this).attr('data-price'))
		cat.find("#cimg").attr('src','http://localhost/wordpress/wp-content/plugins/hotel-booking/assets/img/'+$j(this).attr('data-cover_img'))
		end_load()
	});
	$j('.delete_cat').click(function(){
		var id = $j(this).attr('data-id');
		$j('#confirm_modal .modal-body').html("Are you sure to delete this category?")
	    $j('#confirm_modal').modal('show')
        confirm_del(id);
	});
	function confirm_del($id) {
		$j('#confirm').click(function(){
			delete_cat($id);
			$j('#confirm_modal').modal('hide');
		});
    }
	function delete_cat($id){
		start_load()
		$j.ajax({
			url:'http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/delete_cat.php?action=delete_category',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					//alert("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
});

</script>