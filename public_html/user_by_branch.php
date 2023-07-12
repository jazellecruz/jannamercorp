<?php
  $page_title = 'Users by branch';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
  <?php
  $branch_id = (int)$_GET['branch_id'];
  $branch_name = $_GET['branch_name'];
  if(empty($branch_id)):
    redirect('home.php',false);
  else:
    $user_branch = find_users_by_branch($branch_id);
  endif;

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span><?= $branch_name ?> BRANCH</span>
     </strong>
    </div>
     <div class="panel-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th class="text-center" style="width: 30%;">Users' Name</th>
            <th class="text-center" style="width: 15%;">Users' username</th>
            <th class="text-center" style="width: 15%;">Users' Level</th>
            <th class="text-center" style="width: 10%;">Users' Status</th>
            <th class="text-center" style="width: 15%;">Users' Branch</th>
            <th class="text-center" style="width: 25%;">Branch Location</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($user_branch as $user): ?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($user['name']))?></td>
           <td><?php echo remove_junk(ucwords($user['username']))?></td>
           <td class="text-center">
             <?php echo remove_junk(ucwords($user['group_name']))?>
           </td>
           <td class="text-center">
           <?php if($user['status'] === '1'): ?>
            <span class="label label-success"><?php echo "Active"; ?></span>
          <?php else: ?>
            <span class="label label-danger"><?php echo "Deactive"; ?></span>
          <?php endif;?>
           </td>
           <td class="text-center"><?= $user['branch']?></td>
           <td><?php echo remove_junk(ucwords($user['location']))?></td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
