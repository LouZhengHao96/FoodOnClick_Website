<?php
require_once('../dbConnection.php');
?>

<?php
$query = "SELECT * FROM `promocodes`";
$select = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($select);
$promoArray = array();
$codeName = "";
$discountRate = "";
$imgFile = "";
$toDate = "";
$fromDate = "";
//$termsCondition = "";
$promoDescription = "";
if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        $codeName = $rows["codeName"];
        $discountRate = $rows["discountRate"];
        $imgFile = $rows["imgFile"];
        $toDate = $rows["toDate"];
        $fromDate = $rows["fromDate"];
        //$termsCondition = $rows["termsCondition"];
        $promoDescription = $rows["promoDescription"];
        $promoArray[]=array($codeName, $discountRate, $imgFile, $toDate, $fromDate, $promoDescription);
    }
}
?>