
<?php
include('../dbConnection.php');

if(isset($_POST['deleteItem']))
{
    $itemID = $_POST['deleteSearchItem'];
    if($itemID != ""){
        $sqlCommand = "DELETE FROM menu_item WHERE menu_item_ID = '$itemID'";

        echo $sqlCommand;


        $result = mysqli_query($conn, $sqlCommand);

        if($result==true)
        {
            header("Location: staff_homepage.php#viewMenuItem");
        }
        else 
        {
            header('Location: staff_homepage.php?ililiem23');
        }
    }
    else 
    {
        header('Location: staff_homepage.php?ililiem23');
    }
}

?>