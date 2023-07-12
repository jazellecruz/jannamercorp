<?php
  $page_title = 'Monthly Products';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
  $products = null;
  $branches = find_all('branches');
  $current_user = current_user();
?>
<?php
 if(isset($_POST['get_sales'])){
   $req_field = array('start-date', 'end-date', 'branch_id');
   validate_fields($req_field);
   $start_date = remove_junk($db->escape($_POST['start-date']));
   $end_date = remove_junk($db->escape($_POST['end-date']));
   $branch_id = remove_junk($db->escape($_POST['branch_id']));
   if(empty($errors)){
    $branch_name = find_by_id('branches', $branch_id);
    $remaining_products = find_all_remaining_products($branch_id);
    $remaining_products = $remaining_products->fetch_assoc();
    $result = find_added_products_by_date($start_date, $end_date, $branch_id);
    $total_added_products = $result->fetch_assoc();
    $products = find_added_monthly_products_by_date($start_date, $end_date, $branch_id);
   } else {
     $session->msg("d", $errors);
     redirect('monthly_products.php',false);
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
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Select products added this month</span>
                </strong>
            </div>
            <div class="panel-body">
                <form action="monthly_products.php" method="post">
                    <div class="form-group">
                        <label for="end-date" class="form-label">From</label>
                        <input class="form-control" type="date" name="start-date" id="start-date">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emd-date">To</label>
                        <input class="form-control" type="date" name="end-date" id="end-date">
                    </div>
                    <?php if ($current_user['user_level'] == 3) : ?>
                        <input type="hidden" name="branch_id" value="<?php echo $_SESSION['branch']?>">
                    <?php else: ?>
                        <div class="form-group">
                            <label class="form-label" for="branch_id">Branch</label>
                            <select name="branch_id" class="form-control">
                                <option disabled selected="selected">SELECT</option>
                                <?php foreach ($branches as $branch) : ?>
                                    <option value="<?= $branch['id'] ?>"><?= $branch['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <button class="btn btn-primary" type="submit" name="get_sales">Get Products</button>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Print invoice</span>
                </strong>
            </div>
            <div class="panel-body">

                <form action="print_monthly_products.php" method="post" target="_blank">
                    <div class="form-group">
                        <label for="end-date" class="form-label">From </label>
                        <input class="form-control" type="date" name="start-date" id="start-date">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emd-date">To</label>
                        <input class="form-control" type="date" name="end-date" id="end-date">
                    </div>
                    <?php if ($current_user['user_level'] == 3) : ?>
                        <input type="hidden" name="branch_id" value="<?php echo $_SESSION['branch']?>">
                    <?php else: ?>
                        <div class="form-group">
                            <label class="form-label" for="branch_id">Branch</label>
                            <select name="branch_id" class="form-control">
                                <option disabled selected="selected">SELECT</option>
                                <?php foreach ($branches as $branch) : ?>
                                    <option value="<?= $branch['id'] ?>"><?= $branch['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <button class="btn btn-primary" type="submit" name="get_sales">Print Invoice</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span>Monthly Sales Analysis</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="panel panel-box clearfix">
                        <div class="panel-icon pull-left bg-green">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                        </div>
                        <div class="panel-value pull-right">
                            <h2 class="margin-top">
                                <?= $total_added_products['total_amount'] != null ? $total_added_products['total_amount'] : "..." ?>
                            </h2>
                            <p class="text-muted">Added this month</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-box clearfix">
                        <div class="panel-icon pull-left bg-blue2">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                        </div>
                        <div class="panel-value pull-right">
                            <h2 class="margin-top">
                                <?= $remaining_products['remaining_products'] != null ? $remaining_products['remaining_products'] : "..." ?>
                            </h2>
                            <p class="text-muted">Total remaining products</p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: center">
                <div class="col-md-6">
                    <div class="panel panel-box clearfix">
                        <div class="panel-icon pull-left bg-red">
                            <i class="glyphicon glyphicon-home"></i>
                        </div>
                        <div class="panel-value pull-right">
                            <h2 class="margin-top"><?= $branch_name['name'] != null ? $branch_name['name'] : "..." ?></h2>
                            <p class="text-muted">Branch</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>All Products</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Products</th>
                            <th>Added this month</th>
                            <th>Remaining Products</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_null($products)) : ?>
                        <?php else: ?>
                            <?php while ($product = $products->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo count_id() ?></td>
                                    <td class="text-center"><?php echo ucfirst($product['name']) ?></td>
                                    <td><?php echo $product['amount_added']; ?></td>
                                    <td><?php echo $product['quantity']; ?></td>
                                    <td><?= $product['date_added'] != null ? date('Y-m-d', strtotime($product['date_added'])) : date('Y-m-d', strtotime($product['date']))  ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php include_once('layouts/footer.php'); ?>