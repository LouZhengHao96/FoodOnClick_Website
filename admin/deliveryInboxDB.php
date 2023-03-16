<?php
require_once("../dbConnection.php");
?>

<?php
$query = "SELECT * FROM `delivery_inbox`";
$select = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($select);
$deliveryInboxArray = array();
$status= "";
$description = "";
$date = "";
if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
    $status= $rows["inboxStatus"];
    $description = $rows["inboxDescription"];
    $date = $rows["inboxDate"];

    $deliveryInboxArray[]=array($status, $description, $date);
    }
}
?>