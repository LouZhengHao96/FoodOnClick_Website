<?php
    include('../dbConnection.php');
    if(isset($_POST['updateCouponSubmit']) && empty($_FILES['update_coupon_image']) || $_FILES['update_coupon_image']['error'] !== 0 ){
        $updateCouponID = $_POST['updateSearchCoupon'];
        $updateCouponName = $_POST['updateCouponName'];
        $updateCouponDiscount = $_POST['updateCouponDiscount'];
        $updateCouponValidFrom = $_POST['updateCouponValidFrom'];
        $updateCouponValidTo = $_POST['updateCouponValidTo'];
        $updateCouponDescription = $_POST['updateCouponDescription'];

        $sqlCommand1 = "UPDATE `promocodes` SET codeName='" . $updateCouponName .
                                        "', discountRate='" . $updateCouponDiscount .
                                        "', fromDate='" . $updateCouponValidFrom .
                                        "', toDate='" . $updateCouponValidTo .
                                        "', promoDescription='" . $updateCouponDescription .
                                        "' WHERE promoID='" . $updateCouponID . "'";

        $stmt= $conn->prepare($sqlCommand1);
        $stmt->execute();
        if($stmt){
            header("Location: staff_homepage.php#viewCouponCode");
        }
        else
        {
            header('Location: staff_homepage.php?ililiem6');
        }
    }

    else if (isset($_POST['updateCouponSubmit']) && isset($_FILES['update_coupon_image'])) {
        $img_name = $_FILES['update_coupon_image']['name'];
        $img_size = $_FILES['update_coupon_image']['size'];
        $tmp_name = $_FILES['update_coupon_image']['tmp_name'];
        $error = $_FILES['update_coupon_image']['error'];
        if ($error === 0) {
            if ($img_size > 125000000000000) {
                header('Location: staff_homepage.php?ililiem5');
            }else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
    
                $allowed_exs = array("jpg", "jpeg", "png"); 
    
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = $img_name;
                    $img_upload_path = '../MoshiQ2 IMG Assets/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    //get data from the form (variables)
                    $updateCouponID = $_POST['updateSearchCoupon'];
                    $updateCouponName = $_POST['updateCouponName'];
                    $updateCouponDiscount = $_POST['updateCouponDiscount'];
                    $updateCouponValidFrom = $_POST['updateCouponValidFrom'];
                    $updateCouponValidTo = $_POST['updateCouponValidTo'];
                    $updateCouponDescription = $_POST['updateCouponDescription'];
                    $updateCouponImage = $img_upload_path;

                    $sqlCommand1 = "UPDATE `promocodes` SET codeName='" . $updateCouponName .
                                                    "', discountRate='" . $updateCouponDiscount .
                                                    "', imgFile='" . $updateCouponImage .
                                                    "', fromDate='" . $updateCouponValidFrom .
                                                    "', toDate='" . $updateCouponValidTo .
                                                    "', promoDescription='" . $updateCouponDescription .
                                                    "' WHERE promoID='" . $updateCouponID . "'";

                    $stmt= $conn->prepare($sqlCommand1);
                    $stmt->execute();

                    if($stmt){
                        header("Location: staff_homepage.php#viewCouponCode");
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
        header('Location: staff_homepage.php?em1');
    }
?>