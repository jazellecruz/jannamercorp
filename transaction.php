<?php

include "includes/load.php";
// we need to add the transaction for this part
// table details or columns
/**
 * transaction_table_id
 * delivery_type
 * customer_name
 * grand_total
 * subtotal
 * addons
 * less
 * selected_pricing
 * location
 * route
 * address
 */
if (isset($_POST['transaction_table_id'])) {
    var_dump($_POST);
    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d");

    $transaction_table_id = remove_junk($db->escape($_POST['transaction_table_id']));
    $delivery_type = remove_junk($db->escape($_POST['delivery_type']));
    $customer_name = remove_junk($db->escape($_POST['customer_name']));
    $grand_total = remove_junk($db->escape($_POST['grand_total']));
    $subtotal = remove_junk($db->escape($_POST['subtotal']));
    $addons = remove_junk($db->escape($_POST['addons']));
    $less = remove_junk($db->escape($_POST['less']));
    $selected_pricing = remove_junk($db->escape($_POST['selected_pricing']));
    $location = remove_junk($db->escape($_POST['location']));
    $route = remove_junk($db->escape($_POST['route']));
    $address = remove_junk($db->escape($_POST['address']));
    $updated_at = $created_at = $date;

    $sql = "INSERT INTO transactions (
        transaction_table_id, 
        delivery_type, 
        customer_name, 
        grand_total, 
        subtotal, 
        addons, 
        less, 
        selected_pricing, 
        location, 
        route, 
        address,
        updated_at,
        created_at) 
        VALUE (
            '$transaction_table_id',
            '$delivery_type',
            '$customer_name',
            '$grand_total',
            '$subtotal',
            '$addons',
            '$less',
            '$selected_pricing',
            '$location',
            '$route',
            '$address',
            '$updated_at',
            '$created_at'
        )";

    $result = $db->query($sql);

    var_dump($result);

    var_dump($_POST);
}
