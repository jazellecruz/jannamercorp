<?php
  $page_title = 'Monthly Products';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $branches = find_all('branches');

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
                    <span>Retrieve Products Sold This Month</span>
                </strong>
            </div>
            <div class="panel-body">
                <form action="print_product_sold.php" method="post">
                    <div class="form-group">
                        <label for="end-date" class="form-label">From</label>
                        <input class="form-control" type="date" name="start-date" id="start-date">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emd-date">To</label>
                        <input class="form-control" type="date" name="end-date" id="end-date">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="branch_id">Branch</label>
                        <select name="branch_id" class="form-control">
                            <option disabled selected="selected">SELECT</option>
                            <?php foreach ($branches as $branch) : ?>
                                <option value="<?= $branch['id'] ?>"><?= $branch['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit" name="get_products_sold">Get Products</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>