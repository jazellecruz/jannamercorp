<?php
  $page_title = 'Sales by branch';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
  <?php
  $branch_id = (int)$_GET['branch_id'];
  if(empty($branch_id)):
    redirect('home.php',false);
  else:
    $sales_by_branch = find_sales_by_branch($branch_id);
    $branch_name = find_by_id("branches", $branch_id);
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
        <span><?= $branch_name['name'] ?> BRANCH SALES</span>
     </strong>
    </div>
     <div class="panel-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th class="text-center" style="width: 30%;">Products' Name</th>
            <th class="text-center" style="width: 10%;">Quantity</th>
            <th class="text-center" style="width: 10%;">Total Revenue</th>
            <th class="text-center" style="width: 10%;">Date of sale</th>
            <th class="text-center" style="width: 10%;">Products' Branch</th>
            <th class="text-center" style="width: 25%;">Branch Location</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($sales_by_branch as $sale): ?>
          <tr>
           <td class="text-center"><?= $sale["id"] ?></td>
           <td><?php echo remove_junk(ucwords($sale['name']))?></td>
           <td class="text-center">
             <?php echo remove_junk(ucwords($sale['qty']))?>
           </td>
           <td class="text-center">
           ₱ <?php echo remove_junk(ucwords($sale['price']))?>
           </td>
           <td class="text-center">
            <?php echo remove_junk(ucwords($sale['date']))?>
           </td>
           <td class="text-center"><?= $sale['branch']?></td>
           <td><?php echo remove_junk(ucwords($sale['location']))?></td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
