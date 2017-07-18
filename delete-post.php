<?php 
/*
  Plugin Name: WP Delete Post
  Description: Remove a single wordpress post by going to /wp-admin/index.php?delete_post=[post_id}
  Version: 0.1
  Author: James Murgatroyd Communications
  License: GPL2
*/

// set global scope vars 
$the_id = $_GET['delete_post'];;
$msg = ""; 
$status = "notice-error";

// Run Function on Admin init Hook
add_action('admin_init', 'manually_delete_post', 0);

function manually_delete_post(){
    
    // Only run if user is logged in
    if(!is_user_logged_in())
        return;
    
    // Check user privledges
    if(!current_user_can('manage_options'))
        return;
          
    // get global vars
    global $the_id;
    
    if($the_id){
          
      //True force deletes the post and doesn't send it to the Trash
      $delete = wp_delete_post( $the_id, true ); 
      
      // get global vars
      global $msg, $status;
        
      if($delete){
        $msg = "Post $the_id deleted successfully!";
        $status = "notice-success";
      } else{
        $msg = "Post $the_id was not deleted.";
        $status = "notice-error";
      }
       
    }
}

// Add Admin Notice
add_action( 'admin_notices', 'my_notice' );

function my_notice() {
  // get global vars
  global $msg, $status;
  ?>
  <div class="notice <?php echo $status; ?> is-dismissible">
      <p><?php echo $msg; ?></p>
  </div> 
  <?php 
  }
?>