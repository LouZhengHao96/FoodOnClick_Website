<?php
require_once('../dbConnection.php');

if(isset($_POST['cancel_link_1'])){
    //get INPUT data from the form 
    $form_res_id = $_POST['cancel_link_1'];
    $sqlCommand = "DELETE FROM reservation WHERE reservation_ID = '$form_res_id'";                           
    $result = mysqli_query($conn, $sqlCommand);
    if($result){
        echo 'Successfully cancelled reservation!';
    }
    else{
        echo 'There were errors in cancelling reservation, please refresh the page and try again';
    }
}
else{
    echo "Error! Could not send data";
}
?>