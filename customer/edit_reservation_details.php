<?php
require_once('../dbConnection.php');
?>

<?php
if(isset($_POST['displayReservationID'])){
    $reservationID = $_POST['displayReservationID'];
    $customerName = $_POST['displayCustomerName'];
    $emailAddress = $_POST['displayCustomerEmailAddress'];
    $phoneNumber = $_POST['displayCustomerPhoneNumber'];
    $outletLocation = $_POST['displayCustomerOutletLocation'];
    $dateSlot = $_POST['displayCustomerDateSlot'];
    $timeSlot = $_POST['displayCustomerTimeSlot'];
    $paxAmount = $_POST['displayCustomerPaxAmount'];
    $seatingArea = $_POST['displayCustomerSeatingArea'];
    $promoCode = $_POST['displayCustomerDiscountCode'];
    $item_1 = $_POST['item_1'];
    $item_2 = $_POST['item_2'];
    $item_3 = $_POST['item_3'];
    $item_4 = $_POST['item_4'];
    $item_5 = $_POST['item_5'];
    $UPDATE = "UPDATE `reservation` SET user_fullname='". $customerName . 
                            "', emailAddress='" . $emailAddress . 
                            "', phoneNumber='" . $phoneNumber .
                            "', outletLocation='" . $outletLocation .
                            "', dateSlot='" . $dateSlot .   
                            "', timeSlot='" . $timeSlot . 
                            "', paxAmount='" . $paxAmount .
                            "', outletLocation='" . $outletLocation .
                            "', seatingArea='" . $seatingArea .   
                            "', promoCode='" . $promoCode .   
                            "', item_1='" . $item_1 . 
                            "', item_2='" . $item_2 .
                            "', item_3='" . $item_3 .
                            "', item_4='" . $item_4 . 
                            "', item_5='" . $item_5 . 
                            "' WHERE reservation_ID= '" . $reservationID . "'";
    $stmt = $conn->prepare($UPDATE);
    $stmt -> execute();
    if($stmt){
        echo 'Reservation successfully updated!';
    }
    else{
        echo 'There were errors while updating reservation, please refresh the page and try again';
    }
}
else{
    echo "Error! Could not send data";
}
?>