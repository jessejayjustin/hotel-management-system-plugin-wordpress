<?php 

$rid = '';

$calc_days = abs(strtotime($_GET['out']) - strtotime($_GET['in'])); 
$calc_days =floor($calc_days / (60*60*24)  );
?>
<div class="container-fluid">
	
	<form action="" id="manage-check">
		<input type="hidden" name="cid" id="cid" value="<?php echo isset($_GET['cid']) ? $_GET['cid']: '' ?>">
		<input type="hidden" name="rid" id="rid" value="<?php echo isset($_GET['rid']) ? $_GET['rid']: '' ?>">

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="contact">Contact #</label>
			<input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['contact_no']) ? $meta['contact_no']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="date_in">Check-in Date</label>
			<input type="date" name="date_in" id="date_in" class="form-control" value="<?php echo isset($_GET['in']) ? date("Y-m-d",strtotime($_GET['in'])): date("Y-m-d") ?>" required readonly>
		</div>
		<div class="form-group">
			<label for="date_in_time">Check-in Date</label>
			<input type="time" name="date_in_time" id="date_in_time" class="form-control" value="<?php echo isset($_GET['date_in']) ? date("H:i",strtotime($_GET['date_in'])): date("H:i") ?>" required>
		</div>
		<div class="form-group">
			<label for="days">Days of Stay</label>
			<input type="number" min="1" name="days" id="days" class="form-control" value="<?php echo isset($_GET['in']) ? $calc_days: 1 ?>" required readonly>
		</div>
	</form>
</div>

<script>
var $j = jQuery.noConflict();

$j(document).ready(function() {
  $j('#manage-check').submit(function(e){
    e.preventDefault();
    alert();
    start_load()
    $j.post("http://localhost/wordpress/wp-content/plugins/hotel-booking/admin/admin_class.php?action=save_book",
      {
        cid: $j("#cid").val(),
        rid: $j("#rid").val(),
        name: $j("#name").val(),
        contact: $j("#contact").val(),
        date_in: $j("#date_in").val(),
        date_in_time: $j("#date_in_time").val(),
        days: $j("#days").val()
      },
      function(resp){
        console.log(resp);
        if(resp > 0){
            alert_toast("Data successfully saved",'success')
            setTimeout(function(){
            end_load()
            $j('.modal').modal('hide')
          },1500)
        }
      }
    );  
  });
});

</script>