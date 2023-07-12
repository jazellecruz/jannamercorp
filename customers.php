<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $customers = get_customers();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="customers_add.php" class="btn btn-primary">Add New</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 20%">#</th>
                <th style="width: 20%;"> Full Name </th>
                <th class="text-center" style="width: 20%;"> Credit Limit </th>
                <th class="text-center" style="width: 20%;"> Balance Status </th>
                <th class="text-center" style="width: 20%;"> Options </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customers as $customer):?>
              <tr>
                <td>
                  <?= $customer['id'] ?>
                </td>
                <td>
                  <?= $customer['fname'] ?> <?= $customer['lname'] ?>
                </td>
                <td><?= $customer['credit_limit'] ?></td>
                <td><?= $customer['balance_status'] ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="customers_edit.php?id=<?php echo (int)$customer['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="customers_delete.php?id=<?php echo (int)$customer['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
