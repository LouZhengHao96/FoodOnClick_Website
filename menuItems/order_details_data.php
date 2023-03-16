<?php
require_once("../dbConnection.php");
?>

<?php
if(isset($_POST['order_address'])){
    $accountID = $_POST['accountID'];
    $order_date = $_POST['order_date'];
    $order_time = $_POST['order_time'];
    $order_price = $_POST['order_price'];
    $order_status = $_POST['order_status'];
    $order_promocode = $_POST['order_promocode'];
    $order_address = $_POST['order_address'];
    $order_payment = $_POST['order_payment'];
    $order_description = $_POST['order_description'];

    $INSERT = "INSERT into delivery_orders (accountID, order_date, order_time, order_price, order_status, order_promocode, 
                                            order_address, order_payment, order_description) 
                                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    //Prepare statement
    $stmt = $conn->prepare($INSERT);

    $stmt -> bind_param("sssssssss", $accountID, $order_date, $order_time, $order_price, $order_status, 
                        $order_promocode, $order_address, $order_payment, $order_description);
    $stmt -> execute();
    if($stmt){
        echo 'Order and delivery details will be sent to you soon!';
    }
    else{
        echo 'There were errors in your order, please refresh the page and try again';
    }
}
else{
    echo "Error! Could not send data";
}
mysqli_close($conn);
?>