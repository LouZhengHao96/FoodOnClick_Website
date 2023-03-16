<?php
    include('../dbConnection.php');
    if(isset($_POST['updateOrder']))
        {
        //get INPUT data from the form 
        $orderID = $_POST['updateSearchOrder'];
        $orderStatus = $_POST['updateOrderStatus'];

        if($conn){
            $UPDATE = "UPDATE `delivery_orders` SET order_status='". $orderStatus . 
            "' WHERE orderID= '" . $orderID . "'";

            $stmt = $conn->prepare($UPDATE);
            $stmt -> execute();
            if($stmt){
                header("Location: staff_homepage.php#viewOrder");
            }
            else{
                header('Location: staff_homepage.php?ililiem3');
            }
        }
        else{
            header('Location: staff_homepage.php?ililiem2');
        }
    }
    else{
        header('Location: staff_homepage.php?ililiem1');
    }
?>