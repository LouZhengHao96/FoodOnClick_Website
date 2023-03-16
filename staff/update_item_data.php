<?php
    include('../dbConnection.php');
    if(isset($_POST['updateSubmit']) && empty($_FILES['updateItemMyImage']) || $_FILES['updateItemMyImage']['error'] !== 0 ){
        $staff_item_update_ID =$_POST['updateSearchItem'];
        $staff_item_update_category =$_POST['updateItemCategory'];
        $staff_item_update_name =$_POST['updateItemName'];
        $staff_item_update_describe =$_POST['updateItemDescription'];
        $staff_item_update_price =$_POST['updateItemPrice'];
        $staff_item_update_stock =$_POST['updateItemStock'];

        $sqlCommand1 = "UPDATE `menu_item` SET item_category='" . $staff_item_update_category .
                                        "', item_name='" . $staff_item_update_name .
                                        "', item_description='" . $staff_item_update_describe .
                                        "', item_price='" . $staff_item_update_price .
                                        "', item_stock='" . $staff_item_update_stock .
                                        "' WHERE menu_item_ID ='" . $staff_item_update_ID . "'";

        $stmt= $conn->prepare($sqlCommand1);
        $stmt->execute();
        if($stmt){
            header("Location: staff_homepage.php#viewMenuItem");
        }
        else
        {
            header('Location: staff_homepage.php?ililiem6');
        }
    }

    else if (isset($_POST['updateSubmit']) && isset($_FILES['updateItemMyImage'])) {
        $img_name = $_FILES['updateItemMyImage']['name'];
        $img_size = $_FILES['updateItemMyImage']['size'];
        $tmp_name = $_FILES['updateItemMyImage']['tmp_name'];
        $error = $_FILES['updateItemMyImage']['error'];
        if ($error === 0) {
            if ($img_size > 125000000000000) {
                header('Location: staff_homepage.php?em5');
            }else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
    
                $allowed_exs = array("jpg", "jpeg", "png"); 
    
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = $img_name;
                    $img_upload_path = '../MoshiQ2 IMG Assets/Menu/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    //get data from the form (variables)
                    $staff_item_update_ID =$_POST['updateSearchItem'];
                    $staff_item_update_category =$_POST['updateItemCategory'];
                    $staff_item_update_name =$_POST['updateItemName'];
                    $staff_item_update_describe =$_POST['updateItemDescription'];
                    $staff_item_update_location =$img_upload_path;
                    $staff_item_update_price =$_POST['updateItemPrice'];
                    $staff_item_update_stock =$_POST['updateItemStock'];

                    $sqlCommand1 = "UPDATE `menu_item` SET item_category='" . $staff_item_update_category .
                                                    "', item_name='" . $staff_item_update_name .
                                                    "', item_description='" . $staff_item_update_describe .
                                                    "', item_picture='" . $staff_item_update_location .
                                                    "', item_price='" . $staff_item_update_price .
                                                    "', item_stock='" . $staff_item_update_stock .
                                                    "' WHERE menu_item_ID ='" . $staff_item_update_ID . "'";

                    $stmt= $conn->prepare($sqlCommand1);
                    $stmt->execute();

                    if($stmt){
                        header("Location: staff_homepage.php#viewMenuItem");
                    }
                    else
                    {
                        header('Location: staff_homepage.php?ililiem4');
                    }
                }
                else {
                    header('Location: staff_homepage.php?ililiem3');
                }
            }
        }
        else {
            header('Location: staff_homepage.php?ililiem2');
        }
    
    }
    
    else {
        header('Location: staff_homepage.php?ililiem1');
    }
?>