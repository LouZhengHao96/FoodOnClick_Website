<?php
require_once("../dbConnection.php");
?>

<?php
$query = "SELECT * FROM `promocodes`";
$select = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($select);
$promoCodeArray = array();
$promoID= "";
$codeName = "";
$discountRate = "";
if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
    $promoID = $rows["promoID"];
    $codeName = $rows["codeName"];
    $discountRate = $rows["discountRate"];
    $promoCodeArray[]=array($promoID, $codeName, $discountRate);
    }
}
?>