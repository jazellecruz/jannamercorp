<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

if(isset($_GET['p_id'])){
  $p_id      = $db->escape((int)$_GET['p_id']);
  $s_qty     = $db->escape((int)$_GET['quantity']);
  $s_total   = $db->escape($_GET['total']);
  $date      = $db->escape($_GET['date']);
  $s_date    = make_date();

  $sql  = "INSERT INTO sales (";
  $sql .= " product_id,qty,price,date";
  $sql .= ") VALUES (";
  $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
  $sql .= ")";

        if($db->query($sql)){
          update_product_qty($s_qty,$p_id);
          $session->msg('s',"Sale added. ");
          redirect('product.php', false);
        } else {
          $session->msg('d',' Sorry failed to add!');
          redirect('product.php', false);
        }
}

?>
