<?php
$page_title = 'All Product';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);

$id = $db->escape(remove_junk($_GET['id']));
$transaction = get_transaction_by_id($id);
?>

<?php include_once('layouts/header.php'); ?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="d-flex">
                <strong>
                    <span>Transaction Details</span>
                </strong>
                <a href="#" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit Transaction Details</a>
                <a href="#" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Print Receipt</a>
            </div>
        </div>
        <div class="panel-body">
            <div>
                <div class="col">
                    <p>Transaction ID: <strong><span><?= $transaction['transaction_table_id'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Transaction Date: <strong><span><?= $transaction['updated_at'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Pricing: <strong><span><?= $transaction['selected_pricing'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Transaction Creation: <strong><span><?= $transaction['created_at'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Delivery Type: <strong><span><?= $transaction['delivery_type'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Customer Name: <strong><span><?= $transaction['customer_name'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Grand Total: <strong><span><?= $transaction['grand_total'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Location: <strong><span><?= $transaction['location'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Route: <strong><span><?= $transaction['route'] ?></span></strong></p>
                </div>
                <div class="col">
                    <p>Address: <strong><span><?= $transaction['address'] ?></span></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>