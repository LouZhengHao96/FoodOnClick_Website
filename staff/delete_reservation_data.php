<?php
include('../dbConnection.php');

if(isset($_POST['deleteReservation']))
{
    $reservationID = $_POST['deleteSearchReservation'];

    if($reservationID != ""){
        $sqlCommand = "DELETE FROM reservation WHERE reservation_ID = '$reservationID'";

        echo $sqlCommand;


        $result = mysqli_query($conn, $sqlCommand);

        if($result==true)
        {
            header("Location: staff_homepage.php#viewReservation");
        }
        else 
        {
            header('Location: staff_homepage.php?ililiem2');
        }
    }
    else 
    {
        header('Location: staff_homepage.php?ililiem2');
    }
}
?>