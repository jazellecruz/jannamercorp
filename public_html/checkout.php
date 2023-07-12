<?php include_once('includes/load.php'); ?>
<?php
    page_require_level(3);

    if(isset($_POST['product_id']) && isset($_POST['qty']) && isset($_POST['price'])){
        $p_id      = $db->escape((int)$_POST['product_id']);
        $s_qty     = $db->escape((int)$_POST['qty']);
        $s_total   = $db->escape($_POST['price']);
        $s_date    = make_date();
      
        $sql  = "INSERT INTO sales (";
        $sql .= " product_id,qty,price,date";
        $sql .= ") VALUES (";
        $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
        $sql .= ")";
      
        echo $sql;
        if($db->query($sql)){
            update_product_qty($s_qty,$p_id);
        }
      }

