<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);
$branch = remove_junk($_POST['branch']);

if(empty($errors)){
  $user_id = authenticate($username, $password, $branch);
  if($user_id){
    //create session with id
     $session->login($user_id[0]);
    //Update Sign in time
     updateLastLogIn($user_id[0]);
     $session->branch($user_id[2]);
    if ($user_id[1] == '3') {
      $session->msg("s", "Welcome to Inventory Management System");
      redirect('user_dashboard.php',false);
    } else {
      $session->msg("s", "Welcome to Inventory Management System");
      redirect('admin.php',false);
    }

  } else {
    $session->msg("d", "Sorry Username/Password/Branch incorrect.");
    redirect('index.php',false);
  }

} else {
   $session->msg("d", $errors);
   redirect('index.php',false);
}

?>
