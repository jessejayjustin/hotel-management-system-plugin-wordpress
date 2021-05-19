var $j = jQuery.noConflict();

$j(document).ready(function() {
    
  //$j('#submit').click(function(e){
      //$j('#uni_modal form').submit();
    //});


  $j('#manage-check').submit(function(e){
      alert("working");
      e.preventDefault();
      alert();
      start_load()
      $.post("'. plugins_url().'/hotel-booking/admin/ajax.php?action=save_book",
        {data:$j(this).serialize()},
        function(resp){
          if(resp >0){
            console.log(resp);
            alert_toast("Data successfully saved",'success')
            setTimeout(function(){
            end_load()
            $j('.modal').modal('hide')
            },1500)
          }
          console.log(resp);
        }
      );  
  });
 
});