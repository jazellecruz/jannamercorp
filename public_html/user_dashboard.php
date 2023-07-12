<?php
    $page_title = 'Products of users';
    require_once('includes/load.php');
    // Checkin What level user has permission to view this page
    page_require_level(3);
    // UI algortihm
    $bg_colors = ["bg-green", "bg-red", "bg-blue2", "bg-secondary1", "bg-primary"];
    $nums = 0;
    $num_of_cols = 2;
    $col_width = 10 / $num_of_cols;
    // find products

    $products = find_products_by_branch($_SESSION['branch']);
    $branch_name = find_by_id('branches', $_SESSION['branch']);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row" style="margin-bottom: 20px;">
    <h3 class="text-left"><?= $branch_name['name'] ?> Branch</h3>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="row">
                    <div class="col-md-10 col-sm-10">
                        <input type="text" name="search-bar" id="search-bar" class="form-control">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button class="btn btn-primary" id="search-btn">
                            <img src="https://www.freeiconspng.com/uploads/search-icon-png-21.png" alt="" height="15" width="15">
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row" style="margin: 10px;">
                    <div class="col-md-6">
                        <h5 class="col-6 panel-title" style="margin: 10px">Discount</h5>
                        <select name="discount" id="discount" class="form-control">
                            <option selected='selected' disabled>Add discount</option>
                            <option value="0.95">5%</option>
                            <option value="0.9">10%</option>
                            <option value="0.85">15%</option>
                            <option value="0.8">20%</option>
                            <option value="0.75">25%</option>
                            <option value="0.5">50%</option>
                            <option value="0">100%</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <h5 class="col-6 panel-title" style="margin: 10px">Discount</h5>
                        <h2 id="disc-value" class="text-center">...</h2>
                    </div>
                    <div class="col-md-12">
                        <h5 class="col-6 panel-title" style="margin: 10px">Checkout</h5>
                        <input id="amount" type="text" class="col-6 form-control" placeholder="Amount" value=""
                            readonly>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="pull-right">
                    <button id="checkout" class="btn btn-primary">Checkout</button>
                </div>
            </div>

            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <tbody id="table-body">
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <?php foreach($products as $product) : ?>
        <?php $num = 0; ?>
        <?php if ($nums % $num_of_cols == 0) : ?><div class="row"><?php endif; ?>
            <?php $nums++; ?>
            <div class="col-md-<?php echo $col_width; ?> product" style="cursor: pointer">
                <div class="panel panel-box clearfix">
                    <div
                        class="panel-icon pull-left <?php echo $bg_colors[rand($num % count($bg_colors) == 0 ? $num = 0: $num, (count($bg_colors) - 1))] ?>">
                        <?php if($product['media_id'] === '0'): ?>
                        <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                        <?php else: ?>
                        <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>"
                            alt="">
                        <?php endif; ?>
                    </div>
                    <div class="texts panel-value pull-right">
                        <h4 style="display: none; visibility: hidden;" id="prod_id"><?php echo $product["id"] ?></h4>
                        <h4 class="text-muted text-left" style="margin-left: 10px" id="name">
                            <?php echo $product["product"] ?></h4>
                        <h5 class="text-muted text-left" style="margin-left: 10px" id="cat">
                            <?php echo $product["category"] ?></h5>
                        <h5 class="text-muted text-right" id="price">₱ <?php echo $product["sale_price"] ?></h5>
                    </div>
                </div>
            </div>
            <?php if ($nums % $num_of_cols == 0) : ?>
        </div><?php endif; ?>
        <?php $num++; ?>
        <?php endforeach; ?>
    </div>
</div>


</div>
<script src="libs/js/dashboard.js"></script>

<?php include_once('layouts/footer.php'); ?>