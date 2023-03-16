<?php
require_once("../dbConnection.php");
?>

<?php
if(isset($_POST['displayCustomerID'])){
  $customerID = $_POST['displayCustomerID'];
  $customerName = $_POST['displayCustomerName'];
  $emailAddress = $_POST['displayCustomerEmailAddress'];
  $phoneNumber = $_POST['displayCustomerPhoneNumber'];
  $outletLocation = $_POST['displayCustomerOutletLocation'];
  $dateSlot = $_POST['displayCustomerDateSlot'];
  $timeSlot = $_POST['displayCustomerTimeSlot'];
  $paxAmount = $_POST['displayCustomerPaxAmount'];
  $seatingArea = $_POST['displayCustomerSeatingArea'];
  $item_1 = $_POST['item_1'];
  $item_2 = $_POST['item_2'];
  $item_3 = $_POST['item_3'];
  $item_4 = $_POST['item_4'];
  $item_5 = $_POST['item_5'];

  $discountCode = $_POST['displayCustomerDiscountCode'];

  $INSERT = "INSERT into reservation (cust_ID, user_fullname, emailAddress, phoneNumber, outletLocation,
                                        dateSlot, timeSlot, paxAmount, seatingArea, promoCode, item_1, item_2, item_3, 
                                        item_4, item_5) 
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  
  //Prepare statement
  $stmt = $conn->prepare($INSERT);

  $stmt -> bind_param("sssssssssssssss", $customerID, $customerName, $emailAddress, $phoneNumber, $outletLocation,
                                  $dateSlot, $timeSlot, $paxAmount, $seatingArea, $discountCode, $item_1,
                                  $item_2, $item_3, $item_4, $item_5 );
  $stmt -> execute();
  if($stmt){
    echo 'An email will be sent to you soon!';
  }
  else{
    echo 'There were errors in your booking, please refresh the page and try again';
  }
}
else{
  echo "Error! Could not send data";
}
mysqli_close($conn);
?>