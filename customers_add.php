<?php
$page_title = 'Add Customer';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
if (isset($_POST['add_customer'])) {
    $req_fields = array('fname', 'lname', 'credit_limit', 'balance_status',);
    validate_fields($req_fields);
    if (empty($errors)) {
        $fname            = remove_junk($db->escape($_POST['fname']));
        $lname            = remove_junk($db->escape($_POST['lname']));
        $credit_limit     = remove_junk($db->escape($_POST['credit_limit']));
        $balance_status   = remove_junk($db->escape($_POST['balance_status']));

        $query  = "INSERT INTO customers (";
        $query .= " fname,lname,credit_limit,balance_status";
        $query .= ") VALUES (";
        $query .= " '{$fname}', '{$lname}', '{$credit_limit}', '{$balance_status}'";
        $query .= ")";
        //  $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
        if ($db->query($query)) {
            $session->msg('s', ' Customer Successfully to added!');
            redirect('customers.php');
        } else {
            $session->msg('d', ' Sorry failed to added!');
            redirect('customers.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('customer_add.php', false);
    }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add New Customer Record</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="customers_add.php" class="clearfix">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <input type="text" class="form-control" name="fname" placeholder="First Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <input type="text" class="form-control" name="lname" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <input type="number" class="form-control" name="credit_limit" placeholder="Credit Limit">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <select name="balance_status" id="balance_status" class="form-control">
                                    <option selected disabled>SELECT STATUS</option>
                                    <option value="paid">Paid</option>
                                    <option value="balance">Balance</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="add_customer" class="btn btn-danger">Add Customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>