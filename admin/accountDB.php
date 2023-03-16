<?php
require_once("../dbConnection.php");
?>

<?php
$query = "SELECT * FROM `account`";
$select = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($select);
$accountDataArray = array();
$accountID= "";
$profileID = "";
$fullName = "";
$email = "";
$accountPassword = "";
$phoneNumber = "";
$accountStatus = "";
$accountDescription = "";
if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
    $accountID= $rows["accountID"];
    $profileID = $rows["profileID"];
    $fullName = $rows["fullName"];
    $email = $rows["email"];
    $accountPassword = $rows["accountPassword"];
    $phoneNumber = $rows["phoneNumber"];
    $accountStatus = $rows["accountStatus"];
    $accountDescription = $rows["accountDescription"];

    $accountDataArray[]=array($accountID, $profileID, $fullName, $email, $accountPassword, $phoneNumber, $accountStatus, $accountDescription);
    }
}
mysqli_close($conn);
?>