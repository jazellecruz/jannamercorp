<?php
  $page_title = 'Edit categorie';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $branch = find_by_id('branches',(int)$_GET['id']);
  if(!$branch){
    $session->msg("d","Missing branch id.");
    redirect('branches.php');
  }
?>

<?php
if(isset($_POST['edit_branch'])){
  $req_field = array('branch-name', 'location');
  validate_fields($req_field);
  $branch_name = remove_junk($db->escape($_POST['branch-name']));
  $location = remove_junk($db->escape($_POST['location']));
  if(empty($errors)){
        $sql = "UPDATE branches SET name='{$branch_name}', location='{$location}'";
       $sql .= " WHERE id='{$branch['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Successfully updated Branch");
       redirect('branches.php',false);
     } else {
       $session->msg("d", "Sorry! Failed to Update");
       redirect('branches.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('branches.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editing <?php echo remove_junk(ucfirst($branch['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_branch.php?id=<?php echo (int)$branch['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="branch-name" value="<?php echo remove_junk(ucfirst($branch['name']));?>">
           </div>
           <div class="form-group">
               <input type="text" class="form-control" name="location" value="<?php echo remove_junk(ucfirst($branch['location']));?>">
           </div>
           <button type="submit" name="edit_branch" class="btn btn-primary">Update Branch</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
