<?php
    include('../dbConnection.php');

    if(isset($_POST['input_update_email_1']))
        {
        //get INPUT data from the form 
        $profile = 'Customer';
        $email = $_POST['input_update_email_1'];
        $name = $_POST['input_update_name_1'];
        $number = $_POST['input_update_num_1'];
        $password = $_POST['input_update_pass_1'];


        if($conn){

            // UPDATE account SET fullName ='$name', accountPassword='$password', phoneNumber='$number' WHERE email='123'

            // $sqlCommand = "UPDATE account SET fullName ='$name', accountPassword='$password', phoneNumber='$number' WHERE email='ste257@gmail.com'
            // ";

            $UPDATE = "UPDATE `account` SET fullName='". $name . 
            "', accountPassword='" . $password . 
            "', phoneNumber='" . $number .
            "' WHERE email= '" . $email . "'" .  " AND profileID='" . $profile . "'";

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
    }

    if(isset($_POST['delete_button_1']))
    {
        
        //get INPUT data from the form 

        if($conn){

        $email = $_POST['default_email1'];

            $sqlCommand = " DELETE FROM account 
            WHERE profileID = 'Customer' and email= '$email' ";
            

        $res = mysqli_query($conn, $sqlCommand);
        header('Location: ../index.php');
        }
        
    }
?>