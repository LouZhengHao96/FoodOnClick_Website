<?php
require_once('../dbConnection.php');
?>
<?php 
$sqlCommand = "SELECT * FROM promocodes";
$select = mysqli_query($conn, $sqlCommand);
$num_rows = mysqli_num_rows($select);
$promoArray = array();
$promoID = "";
$codeName = "";
$discountRate = "";
$imgFile = "";
$fromDate = "";
$toDate = "";
$promoDescription = "";
if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        $promoID = $rows["promoID"];
        $codeName = $rows["codeName"];
        $discountRate = $rows["discountRate"];
        $imgFile = $rows["imgFile"];
        $fromDate = $rows["fromDate"];
        $toDate = $rows["toDate"];
        $promoDescription = $rows["promoDescription"];

        $promoArray[] = array($promoID, $codeName, $discountRate, $imgFile, $fromDate, $toDate, $promoDescription);
    }
}
?>