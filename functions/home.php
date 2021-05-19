<!DOCTYPE html>
<html lang="en">
<?php 
  global $wpdb;
  $query = $wpdb->get_results("SELECT * FROM wp_system_settings limit 1", ARRAY_A);
  foreach ($query as $row) {
  }
?>
<head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Hotel Booking Custom Plugin</title>
</head>

    <style>
      header.masthead {
      background: url('http://localhost/wordpress/wp-content/plugins/hotel-booking/assets/img/<?php echo $row['cover_img'] ?>');
      background-repeat: no-repeat;
      background-size: cover;
      }
    </style>
    <body id="page-top">
        <!-- Navigation-->
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-body text-white">
          </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
          <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="./"><?php echo $row['hotel_name'] ?></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
              <ul class="navbar-nav ml-auto my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=head">Home</a></li>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=list">Rooms</a></li>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about">About</a></li>
              </ul>
            </div>
          </div>
        </nav>
       
        <?php 
          $page = isset($_GET['page']) ? $_GET['page'] : 'head';
          include $page.'.php';
        ?>
       

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
            <footer class="bg-light py-5">
                <div class="container"><div class="small text-center text-muted">Copyright © 2020 - Hotel Mangement system | <a href="https://www.sourcecodester.com/" target="_blank">Sourcecodester</a></div></div>
            </footer>

           <?php include('footer.php') ?>
      </body>

      </html>
      
    <?php

	?>


   


