
<?php
    include('../dbConnection.php');

    if (isset($_POST['createCouponSubmit']) && isset($_FILES['coupon_image'])) {
        $img_name = $_FILES['coupon_image']['name'];
        $img_size = $_FILES['coupon_image']['size'];
        $tmp_name = $_FILES['coupon_image']['tmp_name'];
        $error = $_FILES['coupon_image']['error'];
        if ($error === 0) {
            if ($img_size > 125000000000000) {
                header('Location: staff_homepage.php?ilili5');
            }
            else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
    
                $allowed_exs = array("jpg", "jpeg", "png"); 
    
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = $img_name;
                    $img_upload_path = '../MoshiQ2 IMG Assets/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    //get data from the form (variables)
                    $codeName = $_POST['createCouponName'];
                    $discountRate = $_POST['createCouponDiscount'];
                    $imgFile = $img_upload_path;
                    $fromDate = $_POST['createCouponValidFrom'];
                    $toDate = $_POST['createCouponValidTo'];
                    $promoDescription = $_POST['createCouponDescription'];

                    $sqlCommand1 = "INSERT INTO promocodes (codeName, discountRate, imgFile, fromDate, toDate, promoDescription) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt= $conn->prepare($sqlCommand1);

                    $stmt-> bind_param("ssssss", $codeName, $discountRate, $imgFile, $fromDate, $toDate, $promoDescription);
                    $stmt->execute();
                    if($stmt){
                        header("Location: staff_homepage.php#viewCouponCode");
                    }
                    else
                    {
                        header('Location: staff_homepage.php?ililia4');
                    }
                }
                else {
                    header('Location: staff_homepage.php?ililib3');
                }
            }
        }else {
            header('Location: staff_homepage.php?ililia2');
        }
    }
    else {
        header('Location: staff_homepage.php?ilili11');
    }