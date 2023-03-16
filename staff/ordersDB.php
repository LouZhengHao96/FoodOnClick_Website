<?php
require_once('../dbConnection.php');
?>

<?php
$query = "SELECT * FROM `delivery_orders`";
$select = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($select);
$ordersArray = array();
$orderID = "";
$accountID = "";
$order_date = "";
$order_time = "";
$order_price = "";
$order_status = "";
$order_promocode = "";
$order_address = "";
$order_payment = "";
$order_description = "";

if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        $orderID = $rows["orderID"];
        $accountID = $rows["accountID"];
        $order_date = $rows["order_date"];
        $order_time = $rows["order_time"];
        $order_price = $rows["order_price"];
        $order_status = $rows["order_status"];
        $order_promocode = $rows["order_promocode"];
        $order_address = $rows["order_address"];
        $order_payment = $rows["order_payment"];
        $order_description = $rows["order_description"];

        $ordersArray[]=array($orderID, $accountID, $order_date, $order_time, $order_price, $order_status, 
                        $order_promocode, $order_address, $order_payment, $order_description);
    }
}
?>