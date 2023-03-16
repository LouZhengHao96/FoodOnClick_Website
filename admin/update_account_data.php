<?php
require_once('../dbConnection.php');
?>

<?php
if(isset($_POST['email'])){
    $profileID = $_POST['profileID'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $accountPassword = $_POST['accountPassword'];
    $phoneNumber = $_POST['phoneNumber'];
    $accountStatus = $_POST['accountStatus'];
    $accountDescription = $_POST['accountDescription'];
    $UPDATE = "UPDATE `account` SET fullName='". $fullName . 
                            "', accountPassword='" . $accountPassword . 
                            "', phoneNumber='" . $phoneNumber .
                            "', accountStatus='" . $accountStatus .
                            "', accountDescription='" . $accountDescription .   
                            "' WHERE email= '" . $email . "'" .  " AND profileID='" . $profileID . "'";
    $stmt = $conn->prepare($UPDATE);
    $stmt -> execute();
    if($stmt){
        echo 'Profile successfully updated!';
    }
    else{
        echo 'There were errors while updating profile, please refresh the page and try again';
    }
}
else{
    echo "Error! Could not send data";
}
?>