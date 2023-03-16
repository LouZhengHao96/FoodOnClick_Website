<?php
require_once("menuItems/deliveryOrderDB.php");
?>

<!DOCTYPE html>
<html>
    <script>
        function homeFunction(){
            window.location.replace("index.php");
        }

        function signInFunction(){
            window.location.replace("LogIn/logInScreen.php");
        }

        function menuFunction(){
            window.location.replace("menuItems/menu.php");
        }

        var deliveryNumber;
        function trafficFunction(){
            deliveryNumber = 0;
            var slotArrays = '<?php echo json_encode($deliveryOrderArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var slotArray = slotArrays.split('].');
            var deliveryArray = [];
            var actualDeliveryArray = [];
            var x;
            var tempString = "";
            for (x=0;x<slotArray.length;x++)
            {
                deliveryArray.push(slotArray[x]);
            }
            for (x=0;x<deliveryArray.length;x++){
                tempString = String(deliveryArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualDeliveryArray.push(tempString);
            }
            for(x=0; x<actualDeliveryArray.length; x++){
                if(actualDeliveryArray[x][2] == "In-progress"){
                    deliveryNumber++;
                }
            }

            document.getElementById("descriptionBox").style.visibility = 'visible';
            var waitingTime;
            var preparationTime;
            var waitingTimeColor;
            var preparationTimeColor;
            var reservationAvailability = "Available";
            var reservationColor;
            var restaurantOpenClose = "Open";
            var restaurantOpenCloseImg;
            var restaurantOpenCloseColor;

            if(restaurantOpenClose == "Open"){
                restaurantOpenCloseImg = "Smiley.png";
                restaurantOpenCloseColor = "green";
            }
            else{
                restaurantOpenCloseImg = "Sad.png";
                restaurantOpenCloseColor = "red";
            }

            waitingTime = deliveryNumber*5+20;
            preparationTime = deliveryNumber*5+10;
            if(waitingTime >= 0 && waitingTime < 30){
                waitingTimeColor = "green";
            }
            else if(waitingTime >=30 && waitingTime < 50){
                waitingTimeColor = "orange";
            }
            else{
                waitingTimeColor = "red";
            }
            if(preparationTime >= 0 && preparationTime < 30){
                preparationTimeColor = "green";
            }
            else if(preparationTime >=30 && preparationTime < 50){
                preparationTimeColor = "orange";
            }
            else{
                preparationTimeColor = "red";
            }
            if(reservationAvailability == "Available"){
                reservationColor = "green";
            }
            else{
                reservationColor = "red";
            }

            document.getElementById("descriptionBox").innerHTML = '<input type="button" value="x" style="cursor:pointer;float:right;position:absolute;margin-left:90%;display:block;top:10px" onclick="returnFunction()">' +
                                                                    '<b><center><text style="font-size:30px;">Restaurant status: <text style="color:' + restaurantOpenCloseColor + '">' + restaurantOpenClose + '</text></text></center></b></br></br>' +
                                                                    '<center><img src="MoshiQ2 IMG Assets/' + restaurantOpenCloseImg +'"></br></br></center>'+
                                                                    '<center><div style="display:inline-block;width:auto;"><text style="font-size:30px;">Delivery wait time: <text style="color:' + waitingTimeColor + '">~' + waitingTime + 'mins</text></text></br>' + 
                                                                    '<text style="font-size:30px;">Reservation booking: <text style="color:' + reservationColor + '">' + reservationAvailability + '</text></text></br>' +
                                                                    '<text style="font-size:30px;">Preparation time: <text style="color:' + preparationTimeColor + '">~' + preparationTime + 'mins</text></text></br></div></center>';
            setCookie("waitingTiming", waitingTime, 1);
            setCookie("preparationTiming", waitingTime, 1);
        }

        function returnFunction(){
            document.getElementById("descriptionBox").style.visibility = 'hidden';
        }

        function setCookie(nameCookie, valueCookie, timeCookie){
            const date = new Date();
            date.setTime(date.getTime() +  (timeCookie * 24 * 60 * 60 * 1000));
            let expires = "expires=" + date.toUTCString();
            document.cookie = `${nameCookie}=${valueCookie}; ${expires}; path=/`
        }

        var picNum = 1;
        function displayImage(){  
            if(picNum >3){
                picNum = 1;
            }
            for(var x=1; x<=3; x++){
                if(x==picNum){
                    document.getElementById("img"+String(picNum)).style.display = "block";
                }
                else{
                    document.getElementById("img"+String(x)).style.display = "none";
                }
            }
            picNum++; 
        }

        var intervalId = window.setInterval(function(){
            displayImage();
        }, 2000);
    </script>
    <style>
        .mouseOverEffects:hover{
            border-bottom : 3px solid #437E96;
            display: inline-block;
        }
        .popup {
            display: inline-block;
        }

        .popup .popuptext {
            visibility: hidden;
            display: inline-block;
            padding: 44.2839px 49.2043px;
            gap: 29.52px;

            position: absolute;
            width: 700px;
            height: 400px;
            margin:auto;
            left: 0;
            right: 0;
            top: 30%;

            /* /Gray / White */

            background: #FFFFFF;
            /* Stroke/light */

            border: 1.23011px solid #DEE2E6;
            box-shadow: 0px 0px 2.46022px rgba(0, 0, 0, 0.12), 0px 24.6021px 24.6021px rgba(0, 0, 0, 0.08);
            border-radius: 9.84086px;
        }
    </style>
    <body style="background-color:#FEF2E5;" onload="trafficFunction();displayImage()">
        <form>
            <div style="width:1200px;margin-left:auto;margin-right:auto;background-color:#FEF2E5;">
                <a href="index.php"><img src="MoshiQ2 IMG Assets/Logo.png" style="float:left;margin-left:0px;width:500px;height:200px;display:block"></a>
                <div style="padding-top:90px;">
                    <span class="mouseOverEffects" style="width:auto;margin-left:350px;cursor:pointer;">
                        <input type="button" value="HOME" style="border:0px;font-size:14;background-color:transparent;cursor:pointer;" onclick="homeFunction()">
                    </span>
                    <span class="mouseOverEffects" style="width:auto;cursor:pointer;">
                        <input type="button" value="TRAFFIC" style="border:0px;font-size:14;background-color:transparent;cursor:pointer;" onclick="trafficFunction()">
                    </span>
                    <span class="mouseOverEffects" style="width:auto;cursor:pointer;">
                        <input type="button" value="MENU" style="border:0px;font-size:14;background-color:transparent;cursor:pointer;" onclick="menuFunction()">
                    </span>
                    <span style="margin-left:30px">
                        <img src="MoshiQ2 IMG Assets/Homepage Profile Icon.png" style="height:40px;width:auto">
                    </span>
                    <span class="mouseOverEffects" style="width:auto;cursor:pointer;">
                        <input type="button" value="sign in" style="border:0px;font-size:14;background-color:transparent;cursor:pointer;" onclick="signInFunction()">
                    </span>
                </div>
                <div>
                    <center>
                        <img id="img1" src="MoshiQ2 IMG Assets/2.jpg" style="display:none;width:80%;height:auto;padding:50px">
                        <img id="img2" src="MoshiQ2 IMG Assets/3.jpg" style="display:none;width:80%;height:auto;padding:50px">
                        <img id="img3" src="MoshiQ2 IMG Assets/4.jpg" style="display:none;width:80%;height:auto;padding:50px">
                    </center>
                </div>

                <div id="aboutUs" style="height:700px;width:auto;background-color:#F1FFB7;">
                    <center><img src="MoshiQ2 IMG Assets/philosophy.png" style="display:inline-block;width:50%;height:auto;background:transparent;margin-top:50px"></center>
                    <center><text style="width:70%;display:block;margin-top:50px;font-size:25px">Totally redefining food culture and comfort food with its healthier option of 100% plant based menu, MoshiQ2 is a 100% plant-based poke bowl with a full sensory experience. 
                        From smelling the aroma of your favourite food, hearing the crackle of goodness, to tasting the perfect combination of our farm fresh, protein-packed greens. 
                        We have fused the concept of a sustainable, convenient and yet delicious options that are nutritious and great in taste!</text></center>
                        <center><img src="MoshiQ2 IMG Assets/dietryType.png" style="display:block;width:50%;height:auto;background:transparent;margin-top:50px"></center>
                </div>
                <div style="height:auto;width:100%;background-color:#FFE5C9;">
                    <center><img src="MoshiQ2 IMG Assets/excitingPromos.png" style="display:inline-block;width:50%;height:auto;background:transparent;margin-top:50px"></center></br>
                    <center><img src="MoshiQ2 IMG Assets/awaits.png" style="display:inline-block;height:auto;background:transparent;margin-left:40%"></center>
                </div>
                <div id="promotions" style="width:auto;">
                    <img src="MoshiQ2 IMG Assets/Promo 1.png" style="float:left;width:50%;height:800px;display:inline-block">
                    <img src="MoshiQ2 IMG Assets/Promo 2.png" style="width:50%;height:800px;display:inline-block">
                </div>
                <div class="popup">
                    <div class="popuptext" id="descriptionBox">
                    </div></br>
                </div>  
            </div>
        </form>
    </body>
</html>