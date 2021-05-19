<div id="preloader"></div>
<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
	    <div class="modal-content">
	        <div class="modal-header">
	        <h5 class="modal-title">Confirmation</h5>
	    </div>
	    <div class="modal-body">
	        <div id="delete_content"></div>
	    </div>
	    <div class="modal-footer">
	        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
    </div>
    </div>
    <div class="modal fade" id="uni_modal" role='dialog'>
	    <div class="modal-dialog modal-md" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	        <h5 class="modal-title"></h5>
	      </div>
	      <div class="modal-body">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" id='submit' onclick="$j('#uni_modal form').submit()">Save</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	      </div>
	    </div>
    </div>
</div>

<script>
var $j = jQuery.noConflict();

$j(document).ready(function() {
	window.start_load = function(){
      $j('.container-fluid').prepend('<div id="preloader2"></div>')
    }
    window.end_load = function(){
    $j('#preloader2').fadeOut('fast', function() {
        $j(this).remove();
      });
    }
    window.uni_modal = function($title = '' , $url=''){
    start_load()
	    $j.ajax({
	        url:$url,
	        error:err=>{
	            console.log()
	            alert("An error occured")
	        },
	        success:function(resp){
	            if(resp){
	                $j('#uni_modal .modal-title').html($title)
	                $j('#uni_modal .modal-body').html(resp)
	                $j('#uni_modal').modal('show')
	                end_load()
	            }
	        }
	    });
    }
    window._conf = function($msg='',$func='',$params = []){
	    //$j('#confirm_modal #confirm').attr('onclick',delete_cat($params.join(',')))
	    $j('#confirm_modal .modal-body').html($msg)
	    $j('#confirm_modal').modal('show')
    }
    window.alert_toast= function($msg = 'TEST',$bg = 'success'){
        $j('#alert_toast').removeClass('bg-success')
        $j('#alert_toast').removeClass('bg-danger')
        $j('#alert_toast').removeClass('bg-info')
        $j('#alert_toast').removeClass('bg-warning')

	    if($bg == 'success')
	      $j('#alert_toast').addClass('bg-success')
	    if($bg == 'danger')
	      $j('#alert_toast').addClass('bg-danger')
	    if($bg == 'info')
	      $j('#alert_toast').addClass('bg-info')
	    if($bg == 'warning')
	      $j('#alert_toast').addClass('bg-warning')
	    $j('#alert_toast .toast-body').html($msg)
	    $j('#alert_toast').toast({delay:3000}).toast('show');
    }
	$j(document).ready(function(){
	    $j('#preloader').fadeOut('fast', function() {
	        $j(this).remove();
	    });
	});
});
</script>