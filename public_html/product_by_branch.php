<?php
  $page_title = 'Branch by Products';
  require_once('includes/load.php');
  // Checkin What level product has permission to view this page
   page_require_level(1);
?>
  <?php
  $branch_id = (int)$_GET['branch_id'];
  $branch_name = $_GET['branch_name'];
  if(empty($branch_id)):
    redirect('home.php',false);
  else:
    $products_branch = find_products_by_branch($branch_id);
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
            <th class="text-center" style="width: 30%;">Products' Name</th>
            <th class="text-center" style="width: 15%;">Products' Quantity</th>
            <th class="text-center" style="width: 10%;">Suggested Retail Price</th>
            <th class="text-center" style="width: 10%;">Selling Price</th>
            <th class="text-center" style="width: 15%;">Products' Branch</th>
            <th class="text-center" style="width: 25%;">Branch Location</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($products_branch as $product): ?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($product['product']))?></td>
           <td class="text-center">
            <?php echo remove_junk(ucwords($product['quantity']))?>
           </td>
           <td class="text-center">
           <?php echo remove_junk(ucwords($product['buy_price']))?> SRP
           </td>
           <td class="text-center">₱<?= $product['sale_price']?></td>
           <td class="text-center"><?= $product['branch']?></td>
           <td><?php echo remove_junk(ucwords($product['location']))?></td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
