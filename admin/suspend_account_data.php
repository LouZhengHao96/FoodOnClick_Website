<?php
require_once('../dbConnection.php');
?>

<?php
if(isset($_POST['email'])){
    $email = $_POST['email'];
    $profileID = $_POST['profileID'];
    $UPDATE = "UPDATE `account` SET accountStatus='suspended' WHERE email= '" . $email . "'" .  " AND profileID='" . $profileID . "'";
    $stmt = $conn->prepare($UPDATE);
    $stmt -> execute();
    if($stmt){
        echo 'Profile successfully suspended!';
    }
    else{
        echo 'There were errors during profile suspension, please refresh the page and try again';
    }
}
else{
    echo "Error! Could not send data";
}
?>