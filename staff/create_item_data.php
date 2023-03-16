<?php
    include('../dbConnection.php');

    if (isset($_POST['createSubmit']) && isset($_FILES['my_image'])) {
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];
        if ($error === 0) {
            if ($img_size > 125000000000000) {
                header('Location: staff_homepage.php?ililiem5');
            }else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
    
                $allowed_exs = array("jpg", "jpeg", "png"); 
    
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = $img_name;
                    $img_upload_path = '../MoshiQ2 IMG Assets/Menu/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    //get data from the form (variables)
                    $staff_item_create_category =$_POST['createItemCategory'];
                    $staff_item_create_name =$_POST['createItemName'];
                    $staff_item_create_describe =$_POST['createItemDescription'];
                    $staff_item_create_location =$img_upload_path;
                    $staff_item_create_price =$_POST['createItemPrice'];
                    $staff_item_create_stock =$_POST['createItemStock'];

                    $sqlCommand1 = "INSERT INTO menu_item (item_category, item_name, item_description, item_picture, item_price, item_stock) VALUES (?, ?, ?, ?, ?, ?)";

                    $stmt= $conn->prepare($sqlCommand1);

                    $stmt-> bind_param("ssssss", $staff_item_create_category, strtoupper($staff_item_create_name), ucfirst($staff_item_create_describe), $staff_item_create_location, $staff_item_create_price, $staff_item_create_stock);

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
        }else {
            header('Location: staff_homepage.php?ililiem12');
        }
    
    }else {
        header('Location: staff_homepage.php?ililiem11');
    }
?>