<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $transactions = get_transactions();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
      <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Processed Transactions</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th style="width: 20%;"> Transaction-ID </th>
                <th class="text-center" style="width: 20%;"> Customer Name</th>
                <th class="text-center" style="width: 20%;"> Location </th>
                <th class="text-center" style="width: 20%;"> Total Balance </th>
                <th class="text-center" style="width: 30%;"> Options </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transactions as $transaction):?>
              <tr>
                <td><?= $transaction['id'] ?></td>
                <td>
                  <?= $transaction['transaction_table_id'] ?>
                </td>
                <td>
                  <?= $transaction['customer_name'] ?>
                </td>
                <td><?= $transaction['location'] ?></td>
                <td><?= $transaction['grand_total'] ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="transaction_details.php?id=<?= $transaction['id']?>" class="btn btn-primary btn-sm" title="Details" data-toggle="tooltip" >
                      <span class="glyphicon glyphicon-th-list"></span>
                    </a>
                    <a href="transactions_edit.php?id=<?php echo (int)$transaction['id'];?>" class="btn btn-info btn-sm"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
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
