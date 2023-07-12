<?php
$page_title = 'Delete Locations';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
$id = $db->escape($_GET['id']); 
$sql = "DELETE FROM addresses WHERE id = '{$id}'";

if ($db->query($sql)) {
    $session->msg("s", "Address Successfully Deleted");
    redirect("routes_addresses.php");
} else {
    $session->msg("d", "Error Deleting the Address");
    redirect("routes_addresses.php");
}
?>