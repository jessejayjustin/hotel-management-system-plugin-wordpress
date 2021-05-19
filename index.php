<?php
/**
 * Plugin Name: Hotel Booking Plugin
 * Description: A Hotel booking management system plugin WordPress.
 * Plugin URI: 
 * Author: Jesse
 * Author URI: 
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: hotel-booking
 * 
 **/

register_activation_hook( __FILE__, 'systemSettingsTable');

function systemSettingsTable() {
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $system_settings = $wpdb->prefix . 'system_settings';
  $sql = "CREATE TABLE IF NOT EXISTS `$system_settings` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `hotel_name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL,
  PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ";
  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }

  $room_cat = $wpdb->prefix . 'room_categories';
  $sql = "CREATE TABLE IF NOT EXISTS `$room_cat` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `price` float NOT NULL,
  `cover_img` text NOT NULL,
  PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ";
  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }

  $checked = $wpdb->prefix . 'checked';
  $sql = "CREATE TABLE IF NOT EXISTS `$checked` (
  `id` int(30) NOT NULL AUTO_INCREMENT, 
  `ref_no` varchar(100) NOT NULL,
  `room_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `date_in` datetime NOT NULL,
  `date_out` datetime NOT NULL,
  `booked_cid` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = pending, 1=checked in , 2 = checked out',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ";
  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }

  $rooms = $wpdb->prefix . 'rooms';
  $sql = "CREATE TABLE IF NOT EXISTS `$rooms` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `room` varchar(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Available , 1= Unavailable',
  PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ";
  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
} 

function enqueue_hotel_booking_scripts() {
  wp_enqueue_style( 'magnific-popup-css', plugin_dir_url( __FILE__ ) . 'admin/assets/css/magnific-popup.css' );

  wp_enqueue_style( 'bootstrap-datepicker-css', plugin_dir_url( __FILE__ ) . 'admin/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css' );

  wp_enqueue_style( 'css', plugin_dir_url( __FILE__ ) . 'css/styles.css' );

  wp_enqueue_script( 'fontawesome', plugin_dir_url( __FILE__ ) . 'admin/assets/js/all.js', false, false, false );

  wp_enqueue_script( 'jquery-min', plugin_dir_url( __FILE__ ) . 'admin/assets/vendor/jquery/jquery.min.js', false, false, false );

  wp_enqueue_script( 'bootstrap-datepicker', plugin_dir_url( __FILE__ ) . 'admin/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js', false, false, false );

  wp_enqueue_script( 'bootstrap-bundle', plugin_dir_url( __FILE__ ) . 'admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', false, false, false );

  wp_enqueue_script( 'jquery-easing', plugin_dir_url( __FILE__ ) . 'admin/assets/vendor/jquery.easing/jquery.easing.min.js', false, false, false );

  wp_enqueue_script( 'magnific-popup-js', plugin_dir_url( __FILE__ ) . 'admin/assets/js/jquery.magnific-popup.min.js', false, false, false );

  wp_enqueue_script( 'magnific-popup-js', plugin_dir_url( __FILE__ ) . 'admin/assets/js/jquery.magnific-popup.min.js', false, false, false );

  wp_enqueue_script( 'script-js', plugin_dir_url( __FILE__ ) . 'js/scripts.js', false, false, false );
}
add_action( 'wp_enqueue_scripts', 'enqueue_hotel_booking_scripts' );

function book_enqueue_scripts() {
  wp_enqueue_script( 'book-js', plugins_url() . '/hotel-booking/js/book.js', array( 'jquery' ), false, false );
}
add_action( 'wp_enqueue_scripts', 'book_enqueue_scripts' );

//session_start();

define("ADMIN", plugin_dir_path( __FILE__ ) . 'admin');

define("FUNCTIONS", plugin_dir_path( __FILE__ ) . 'functions');

function shortcode_hotel_booking() {
  // Start Output buffering
  ob_start();
  include(FUNCTIONS . '/home.php');
  // End Output buffering by returning it
  return ob_get_clean();
}
add_shortcode( 'hotel_booking', 'shortcode_hotel_booking' );

function theme_options_panel(){
  add_menu_page('Theme page title', 'Hotel Management', 'manage_options', 'hotel-management', 'hotel_m_theme_func');
  add_submenu_page( 'hotel-management', 'Booked page title', 'Booked', 'manage_options', 'theme-booked-settings', 'hotel_m_booked_func_settings');
  add_submenu_page( 'FAQ menu label', 'FAQ page title', 'FAQ menu label', 'manage_options', 'theme-op-faq', 'wps_theme_func_faq');
}
add_action('admin_menu', 'theme_options_panel');

/* Admin Scripts */

add_action( 'admin_enqueue_scripts', 'load_bootstrap_admin' );
function load_bootstrap_admin() {
  wp_register_style( 'admin_bootstrap', plugins_url() . '/hotel-booking/admin/assets/vendor/bootstrap/css/bootstrap.min.css', false, '1.0.0' );
  wp_enqueue_style( 'admin_bootstrap', plugins_url() . '/hotel-booking/admin/assets/vendor/bootstrap/css/bootstrap.min.css', false, '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
  wp_register_style( 'admin_style', plugins_url() . '/hotel-booking/css/styles.css', false, '1.0.0' );
  wp_enqueue_style( 'admin_style', plugins_url() . '/hotel-booking/css/styles.css', false, '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'load_admin_modal_style' );
function load_admin_modal_style() {
  wp_register_style( 'admin_modal_style', plugins_url() . '/hotel-booking/admin/assets/css/magnific-popup.css', false, '1.0.0' );
  wp_enqueue_style( 'admin_modal_style', plugins_url() . '/hotel-booking/admin/assets/css/magnific-popup.css', false, '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'load_admin_datatables_style' );
function load_admin_datatables_style() {
  wp_register_style( 'admin_datatables_style', plugins_url() . '/hotel-booking/admin/assets/DataTables/datatables.min.css', false, '1.0.0' );
  wp_enqueue_style( 'admin_datatables_style', plugins_url() . '/hotel-booking/admin/assets/DataTables/datatables.min.css', false, '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'load_jquery_admin_script' );
function load_jquery_admin_script() {
  wp_enqueue_script( 'admin_jquery_script', plugins_url() . '/hotel-booking/admin/assets/vendor/jquery/jquery.min.js', false, '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'load_admin_modal_script' );
function load_admin_modal_script() {
  wp_enqueue_script( 'admin_modal_script', plugins_url() . '/hotel-booking/admin/assets/js/jquery.magnific-popup.min.js', false, '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'load_bootstrap_admin_script' );
function load_bootstrap_admin_script() {
  wp_enqueue_script( 'admin_bootstrap_script', plugins_url() . '/hotel-booking/admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', false, '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'load_admin_datatables_script' );
function load_admin_datatables_script() {
  wp_enqueue_script( 'admin_datatables_script', plugins_url() . '/hotel-booking/admin/assets/DataTables/datatables.min.js', false, '1.0.0' );
}

function hotel_m_theme_func() {
  global $wpdb;
  include(ADMIN . '/index.php');
}
function hotel_m_booked_func_settings(){
  global $wpdb;
  include(ADMIN . '/booked.php');
}
function wps_theme_func_faq(){
  echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
  <h2>FAQ</h2></div>';
}

/*
echo "<script>location.replace('admin.php?page=crud/crud.php');</script>";

<?php
/*
Plugin Name: CRUD 
Plugin URI: 
Description: A plugin that perform Crud operations.
Version: 1.0.0
Author: Jesse 
License: GPL2

register_activation_hook( __FILE__, 'crudOperationsTable');
function crudOperationsTable() {
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $table_name = $wpdb->prefix . 'userstable';
  $sql = "CREATE TABLE `$table_name` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(220) DEFAULT NULL,
  `email` varchar(220) DEFAULT NULL,
  PRIMARY KEY(user_id)
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
  ";
  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
}
add_action('admin_menu', 'addAdminPageContent');
function addAdminPageContent() {
  add_menu_page('CRUD', 'CRUD', 'manage_options' ,__FILE__, 'crudAdminPage', 'dashicons-wordpress');
}
function crudAdminPage() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'userstable';
  if (isset($_POST['newsubmit'])) {
    $name = $_POST['newname'];
    $email = $_POST['newemail'];
    $wpdb->query("INSERT INTO $table_name(name,email) VALUES('$name','$email')");
    echo "<script>location.replace('admin.php?page=crud/crud.php');</script>";
  }
  if (isset($_POST['uptsubmit'])) {
    $id = $_POST['uptid'];
    $name = $_POST['uptname'];
    $email = $_POST['uptemail'];
    $wpdb->query("UPDATE $table_name SET name='$name',email='$email' WHERE user_id='$id'");
    echo "<script>location.replace('admin.php?page=crud/crud.php');</script>";
  }
  if (isset($_GET['del'])) {
    $del_id = $_GET['del'];
    $wpdb->query("DELETE FROM $table_name WHERE user_id='$del_id'");
    echo "<script>location.replace('admin.php?page=crud/crud.php');</script>";
  }
  ?>
  <div class="wrap">
    <h2>CRUD Operations</h2>
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th width="25%">User ID</th>
          <th width="25%">Name</th>
          <th width="25%">Email Address</th>
          <th width="25%">Actions</th>
        </tr>
      </thead>
      <tbody>
        <form action="" method="post">
          <tr>
            <td><input type="text" value="AUTO_GENERATED" disabled></td>
            <td><input type="text" id="newname" name="newname"></td>
            <td><input type="text" id="newemail" name="newemail"></td>
            <td><button id="newsubmit" name="newsubmit" type="submit">INSERT</button></td>
          </tr>
        </form>
        <?php
          $result = $wpdb->get_results("SELECT * FROM $table_name");
          foreach ($result as $print) {
            echo "
              <tr>
                <td width='25%'>$print->user_id</td>
                <td width='25%'>$print->name</td>
                <td width='25%'>$print->email</td>
                <td width='25%'><a href='admin.php?page=crud/crud.php&upt=$print->user_id'><button type='button'>UPDATE</button></a> <a href='admin.php?page=crud/crud.php&del=$print->user_id'><button type='button'>DELETE</button></a></td>
              </tr>
            ";
          }
        ?>
      </tbody>  
    </table>
    <br>
    <br>
    <?php
      if (isset($_GET['upt'])) {
        $upt_id = $_GET['upt'];
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id='$upt_id'");
        foreach($result as $print) {
          $name = $print->name;
          $email = $print->email;
        }
        echo "
        <table class='wp-list-table widefat striped'>
          <thead>
            <tr>
              <th width='25%'>User ID</th>
              <th width='25%'>Name</th>
              <th width='25%'>Email Address</th>
              <th width='25%'>Actions</th>
            </tr>
          </thead>
          <tbody>
            <form action='' method='post'>
              <tr>
                <td width='25%'>$print->user_id <input type='hidden' id='uptid' name='uptid' value='$print->user_id'></td>
                <td width='25%'><input type='text' id='uptname' name='uptname' value='$print->name'></td>
                <td width='25%'><input type='text' id='uptemail' name='uptemail' value='$print->email'></td>
                <td width='25%'><button id='uptsubmit' name='uptsubmit' type='submit'>UPDATE</button> <a href='admin.php?page=crud/crud.php'><button type='button'>CANCEL</button></a></td>
              </tr>
            </form>
          </tbody>
        </table>";
      }
    ?>
  </div>
  <?php
}
*/

?>