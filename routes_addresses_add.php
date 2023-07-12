<?php
$page_title = 'Add Customer';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
if (isset($_POST['add_route'])) {
    $req_fields = array('route_name');
    validate_fields($req_fields);
    if (empty($errors)) {
        $route_name = remove_junk($db->escape($_POST['route_name']));

        $query  = "INSERT INTO routes (";
        $query .= " route_name";
        $query .= ") VALUES (";
        $query .= " '{$route_name}'";
        $query .= ")";
        //  $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
        if ($db->query($query)) {
            $session->msg('s', ' Route Successfully to added!');
            redirect('routes_addresses.php');
        } else {
            $session->msg('d', ' Sorry failed to added!');
            redirect('routes_addresses.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('routes_addresses.php', false);
    }
}

if (isset($_POST['add_address'])) {
    $req_fields = array('address_name');
    validate_fields($req_fields);
    if (empty($errors)) {
        $address_name = remove_junk($db->escape($_POST['address_name']));

        $query  = "INSERT INTO addresses (";
        $query .= " address_name";
        $query .= ") VALUES (";
        $query .= " '{$address_name}'";
        $query .= ")";
        //  $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
        if ($db->query($query)) {
            $session->msg('s', ' address Successfully to added!');
            redirect('routes_addresses.php');
        } else {
            $session->msg('d', ' Sorry failed to added!');
            redirect('routes_addresses.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('routes_addresses.php', false);
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
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add Route Record</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="routes_addresses_add.php" class="clearfix">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <input type="text" class="form-control" name="route_name" placeholder="Route">
                            </div>
                        </div>
                        <button type="submit" name="add_route" class="btn btn-primary">Add Route</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add Address Record</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="routes_addresses_add.php" class="clearfix">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <input type="text" class="form-control" name="address_name" placeholder="Address Name">
                            </div>
                        </div>
                        <button type="submit" name="add_address" class="btn btn-primary">Add Address</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>