<?php
    $page_title = 'Sales per Branch';
    require_once('includes/load.php');
    // Checkin What level user has permission to view this page
    page_require_level(1);
    // UI algortihm
    $bg_colors = ["bg-green", "bg-red", "bg-blue2", "bg-secondary1", "bg-primary"];
    page_require_level(1);
    $nums = 0;
    $num_of_cols = 3;
    $col_width = 12 / $num_of_cols;
    // find branches
    $branches = find_all("branches");
?>

<?php include_once('layouts/header.php'); ?>
<div class="row" style="margin-bottom: 20px;">
    <h3 class="text-left">Sales by Branches</h3>
</div>
<?php foreach($branches as $branch) : ?>
    <?php $num = 0; ?>
        <?php if ($nums % $num_of_cols == 0) : ?><div class="row"><?php endif; ?>
        <?php  $nums++; ?>
            <a href="sale_by_branch.php?branch_id=<?php echo $branch['id'] ?>&branch_name=<?= $branch['name']?>" style="color:black;">
                <div class="col-md-<?php echo $col_width; ?>">
                    <div class="panel panel-box clearfix">
                        <div class="panel-icon pull-left <?php echo $bg_colors[rand($num % count($bg_colors) == 0 ? $num = 0: $num, (count($bg_colors) - 1))] ?>">
                            <i class="glyphicon glyphicon-user"></i>
                        </div>
                        <div class="panel-value pull-right">
                            <h4 class="text-muted"><?php echo $branch["name"] ?></h4>
                            <h5 class="text-muted"><?php echo $branch["location"] ?></h5>
                        </div>
                    </div>
                </div>
            </a>
        <?php if ($nums % $num_of_cols == 0) : ?></div><?php endif; ?>
    <?php $num++; ?>
<?php endforeach; ?>

<?php include_once('layouts/footer.php'); ?>

