<?php
$page_title = 'Delete Route';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
$id = $db->escape($_GET['id']); 
$sql = "DELETE FROM routes WHERE id = '{$id}'";

if ($db->query($sql)) {
    $session->msg("s", "Route Successfully Deleted");
    redirect("routes_locations.php");
} else {
    $session->msg("d", "Error Deleting the Route");
    redirect("routes_locations.php");
}
?>