<?php
$page_title = 'All Product';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
$routes = get_routes();
$addresses = get_addresses();
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
                    <a href="routes_addresses_add.php" class="btn btn-primary">Add Route & Address</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="font-heavy">Routes</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10%">#</th>
                                    <th style="width: 40%;"> Route Name </th>
                                    <th class="text-center" style="width: 20%;"> Options </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($routes as $route) : ?>
                                    <tr>
                                        <td>
                                            <?= $route['id'] ?>
                                        </td>
                                        <td>
                                            <?= $route['route_name'] ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="route_delete.php?id=<?php echo (int)$route['id']; ?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Addresses</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10%">#</th>
                                    <th style="width: 40%;"> Address Name </th>
                                    <th class="text-center" style="width: 20%;"> Options </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($addresses as $address) : ?>
                                    <tr>
                                        <td>
                                            <?= $address['id'] ?>
                                        </td>
                                        <td>
                                            <?= $address['address_name'] ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="addresses_delete.php?id=<?php echo (int)$address['id']; ?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>