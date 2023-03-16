<?php
require_once("../dbConnection.php");
?>

<?php
if(isset($_POST['inboxDate'])){
    $inboxStatus = $_POST['inboxStatus'];
    $inboxDescription = $_POST['inboxDescription'];
    $inboxDate = $_POST['inboxDate'];
  
    $INSERT = "INSERT into delivery_inbox (inboxStatus, inboxDescription, inboxDate) 
                                          VALUES(?, ?, ?)";
    
    //Prepare statement
    $stmt = $conn->prepare($INSERT);
  
    $stmt -> bind_param("sss", $inboxStatus, $inboxDescription, $inboxDate );
    $stmt -> execute();
    if($stmt){
      echo 'Inbox updated!';
    }
    else{
      echo 'There were errors in updating your inbox';
    }
  }
  else{
    echo "Error! Could not send data";
  }
  mysqli_close($conn);
?>