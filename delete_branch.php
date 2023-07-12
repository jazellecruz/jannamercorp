<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  // page_require_level(2);
?>
<?php
  $branch = find_by_id('branches',(int)$_GET['id']);
  if(!$branch){
    $session->msg("d","Missing Branch id.");
    redirect('branches.php');
  }
?>
<?php
$delete_id = delete_by_id('branches',(int)$branch['id']);
  if($delete_id){
      $session->msg("s","Branch deleted.");
      redirect('branches.php');
  } else {
      $session->msg("d","Branch deletion failed.");
      redirect('branches.php');
  }
?>