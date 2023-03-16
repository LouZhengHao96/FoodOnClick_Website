<?php
require_once("../dbConnection.php");
?>
<?php
$query = "SELECT * FROM `reservation`";
$select = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($select);
$dataArray = array();
$reservation_ID = "";
$cust_ID = "";
$user_fullname = "";
$emailAddress = "";
$phoneNumber = "";
$outletLocation = "";
$dateSlot = "";
$timeSlot = "";
$paxAmount = "";
$seatingArea = "";
$promoCode = "";
$item_1 = "";
$item_2 = "";
$item_3 = "";
$item_4 = "";
$item_5 = "";
if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
    $reservation_ID = $rows["reservation_ID"];
    $cust_ID = $rows["cust_ID"];
    $user_fullname= $rows["user_fullname"];
    $emailAddress = $rows["emailAddress"];
    $phoneNumber = $rows["phoneNumber"];
    $outletLocation = $rows["outletLocation"];
    $dateSlot = $rows["dateSlot"];
    $timeSlot = $rows["timeSlot"];
    $paxAmount = $rows["paxAmount"];
    $seatingArea = $rows["seatingArea"];
    $promoCode = $rows["promoCode"];
    $item_1 = $rows["item_1"];
    $item_2 = $rows["item_2"];
    $item_3 = $rows["item_3"];
    $item_4 = $rows["item_4"];
    $item_5 = $rows["item_5"];
    $dataArray[]=array($reservation_ID, $cust_ID, $user_fullname, $emailAddress, $phoneNumber, $outletLocation, $dateSlot,
                        $timeSlot, $paxAmount, $seatingArea, $promoCode, $item_1, $item_2, $item_3, $item_4, $item_5);
    }
}
?>