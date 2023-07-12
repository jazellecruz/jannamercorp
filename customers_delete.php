<?php
$page_title = 'Delete Customer';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
$id = $db->escape($_GET['id']); 
$sql = "DELETE FROM customers WHERE id = '{$id}'";

if ($db->query($sql)) {
    $session->msg("s", "Customer Successfully Deleted");
    redirect("customers.php");
} else {
    $session->msg("d", "Error Deleting the customer");
    redirect("customers.php");
}

?>