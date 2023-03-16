<?php
?>
<!DOCTYPE html>
<html>
    <script>
        isProfileClicked = false;
        function clickedDrop(){
            document.getElementById("accountDrop").style.display= "none";
            document.getElementById("accountCollapse").style.display = "block";
            document.getElementById("accountSignOut").style.display = "block";
            document.getElementById("accountProfile").style.display = "block";
        }

        function clickedCollapse(){
            document.getElementById("accountDrop").style.display = "block";
            document.getElementById("accountCollapse").style.display = "none";
            document.getElementById("accountSignOut").style.display = "none";
            document.getElementById("accountProfile").style.display = "none";
        }

        function signOut(){
            document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });
            var confirmMessage = "Are you sure you want to sign out?";
            if (confirm(confirmMessage) == true) {
                window.location.replace("../index.php");
            }
        }

        function profileClicked(){
            if (isProfileClicked == false){
                isProfileClicked = true;
                document.getElementById("displayProfile").style.display = "block";
            }
            else{
                isProfileClicked = false;
                document.getElementById("displayProfile").style.display = "none";
            }
        }


        function profileDetails(){
            var tempLogInName = getCookie("fullName");
            var tempAddress;
            var tempDateTime;
            if(getCookie("area") == "" || getCookie("area") == null){
                tempAddress = "Enter delivery address";
            }
            else{
                tempAddress = getCookie("area") + ", " + getCookie("addressDetails") +', S(' + getCookie("postalCode") + ")";
            }
            if(getCookie("date") == "" || getCookie("date") == null){
                tempDateTime = "Select date and time";
            }
            else{
                tempDateTime = getCookie("date") + ", " + getCookie("time");
            }
            document.getElementById('accountNameDetails').innerHTML = tempLogInName;
            document.getElementById("deliveryAddressButton").value = tempAddress;
            document.getElementById("dateTimeButton").value = tempDateTime;
        }

        function getCookie(name){
            const cDecoded = decodeURIComponent(document.cookie);
            const cArray = cDecoded.split("; ");
            let result = null;
            
            cArray.forEach(element => {
                if(element.indexOf(name) == 0){
                    result = element.substring(name.length + 1)
                }
            })
            return result;
        }

        function menuFunction(){
            window.location.replace("../menuItems/menuList.php");
        }

        function reservationFunction(){
            window.location.replace("../reservation/reservation_details.php");
        }

        function getCurrentLocation(){
            document.getElementById("myPopupAddress").style.visibility = 'visible';
            document.getElementById("inputAddress").value = "";
            document.getElementById("inputAddressDetails").value = "";
            document.getElementById("inputPostalCode").value = "";
            checkAddressFunction();
        }

        function checkAddressFunction(){
            if(document.getElementById("inputAddress").value == "" || 
            document.getElementById("inputAddressDetails").value == "" || 
            document.getElementById("inputPostalCode").value == ""){
                document.getElementById("confirmAddressButton").disabled = true;
            }
            else{
                document.getElementById("confirmAddressButton").disabled = false;
            }
        }

        function confirmAddress(){
            var getInputAddress = document.getElementById("inputAddress").value;
            var getInputAddressDetails = document.getElementById("inputAddressDetails").value;
            var getInputPostalCode = document.getElementById("inputPostalCode").value;
            var displayMyAddress = getInputAddress + ', ' + getInputAddressDetails + ', S(' + getInputPostalCode + ')';
            document.getElementById("deliveryAddressButton").value = displayMyAddress;
            document.getElementById("myPopupAddress").style.visibility = 'hidden';
            setCookie("area", getInputAddress, 7);
            setCookie("addressDetails", getInputAddressDetails, 7);
            setCookie("postalCode", getInputPostalCode, 7);
        }

        function getDateTime(){
            document.getElementById("myPopupDateTime").style.visibility = 'visible';
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if(dd<10){
            dd='0'+dd
            } 
            if(mm<10){
            mm='0'+mm
            } 
            var curTime;
            if(String(today.getMinutes()).length == 1){
                curTime = String(today.getHours()) + "0" + String(today.getMinutes());
            }
            else{
                curTime = String(today.getHours()) + String(today.getMinutes());
            }
            today = yyyy+'-'+mm+'-'+dd;
            document.getElementById("dateSelect").setAttribute("min", today);
            if(document.getElementById("dateSelect").value == ""){
                document.getElementById("dateSelect").value = today;
            }
            var getDate = document.getElementById("dateSelect").value;
            if(getDate = ""){
                getDate = today;
            }
            else{
                getDate = document.getElementById("dateSelect").value;
            }
            var optionList = document.getElementById('timeSelect');
            var checkTF = false;
            for (var x=0; x < optionList.length; x++){
                if(getDate <= today && parseInt(curTime) > parseInt(optionList[x].value.replaceAll(":", ""))){
                    document.getElementById(optionList[x].value).disabled = true;
                }
                else{
                    document.getElementById(optionList[x].value).disabled = false;
                    if(checkTF == false){
                        document.getElementById("timeSelect").value = document.getElementById(optionList[x].value).value;
                        checkTF = true;
                    }
                }
            }                   
            setCookie("clickedCurrentTime", "false", 1);
            checkDateTimeFunction();
        }

        function checkDateTimeFunction(){

            if(document.getElementById("timeSelect").value == "" ||
            document.getElementById("dateSelect").value == ""){
                document.getElementById("confirmDateTimeButton").disabled = true;
            }
            else{
                document.getElementById("confirmDateTimeButton").disabled = false;
            }
        }

        function confirmDateTime(){
            var getTime = document.getElementById("timeSelect").value;
            var getDate = document.getElementById("dateSelect").value;
            var displayDateTime = getDate + ", " + getTime;
            document.getElementById("dateTimeButton").value = displayDateTime;
            document.getElementById("myPopupDateTime").style.visibility = 'hidden';
            setCookie("date", getDate, 7);
            setCookie("time", getTime, 7);
        }

        function setCookie(nameCookie, valueCookie, timeCookie){
            const date = new Date();
            date.setTime(date.getTime() +  (timeCookie * 24 * 60 * 60 * 1000));
            let expires = "expires=" + date.toUTCString();
            document.cookie = `${nameCookie}=${valueCookie}; ${expires}; path=/`
        }

        function closePopupAddress(){
            document.getElementById("myPopupAddress").style.visibility = 'hidden';
        }

        function closePopupDateTime(){
            document.getElementById("myPopupDateTime").style.visibility = 'hidden';
        }

        function deliverNow(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if(dd<10){
            dd='0'+dd
            } 
            if(mm<10){
            mm='0'+mm
            } 
            var curTime;
            if(String(today.getMinutes()).length == 1){
                if (String(today.getHours()).length == 1){
                    curTime = "0" + String(today.getHours()) + ":" + "0" + String(today.getMinutes());
                }
                else{
                    curTime = String(today.getHours()) + ":" + "0" + String(today.getMinutes());
                }
            }
            else{
                if (String(today.getHours()).length == 1){
                    curTime = "0" + String(today.getHours()) + ":" + String(today.getMinutes());
                }
                else{
                    curTime = String(today.getHours()) + ":" + String(today.getMinutes());
                }
            }
            today = yyyy+'-'+mm+'-'+dd;
            document.getElementById('dateTimeButton').value = today + ", " + curTime;
            setCookie("date", today, 7);
            setCookie("time", curTime, 7);
            document.getElementById("myPopupDateTime").style.visibility = 'hidden';
            setCookie("clickedCurrentTime", "true", 1);
        }
    </script>
    <style>
        .mouseOverEffects{
            border: none;
            cursor:pointer;
            background-color:#437E96;
            color: white;
        }

        .mouseOverEffects:hover{
            border: 2px solid black;
            cursor:pointer;
            background-color:#437E96;
            color: white;
        }

        .buttonEffects {
            margin-top:15px;
            border:none;
            background-color:transparent;
            display:inline-block;
            cursor:pointer;
        }
        .buttonEffects:hover {
            border: 2px solid black;
            cursor:pointer;
        }

        .popupAddress {
            display: inline-block;
        }

        .popupAddress .popuptextAddress {
            visibility: hidden;
            display: flex;

            position: absolute;
            width: 400px;
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

        .popupDateTime {
            display: inline-block;
        }

        .popupDateTime .popuptextDateTime {
            visibility: hidden;
            display: flex;

            position: absolute;
            width: 400px;
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
    <body onload="profileDetails();" style="background-color:#FEF2E5;">
        <form>
            <div style="width:1100px;margin-left:auto;margin-right:auto;background-color:#FEF2E5;">
                <div style="float:right;border-bottom:5px solid grey;width:100%;height:120px">
                    <a href="customer_landingPage.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="float:left;margin-left:0px;width:300px;height:auto;display:block;"></a>
                    <div class="buttonEffects" style="margin-left:170px;float:left;display:inline-block;background-color:#A8A1A166;height:42px;margin-top:25px;padding:5px" onclick="getCurrentLocation()">
                        <img src="../MoshiQ2 IMG Assets/Address.png" style="float:left">
                        <input id="deliveryAddressButton" type="button" style="background-color:transparent;display:inline-block;border:none;cursor:pointer;width:150px;white-space:normal;" value="Enter a delivery address">
                    </div>  
                    <div class="buttonEffects" style="float:left;display:inline-block;background-color:#A8A1A166;margin-left:10px;height:42px;margin-top:25px;padding:5px" onclick="getDateTime()" onchange="getDateTime()">
                        <img src="../MoshiQ2 IMG Assets/Time.png" style="float:left">
                        <input id="dateTimeButton" type="button" style="background-color:transparent;display:inline-block;border:none;cursor:pointer;width:150px;white-space:normal;" value="Select date and time">
                    </div> 
            
                    <img src="../MoshiQ2 IMG Assets/Profile Icon.png" style="cursor:pointer;display:block;float:left;width:70px;height:auto;margin-left:110px" onclick="profileClicked()"></br>
                    <div id="displayProfile" name="displayProfile" style="float:right;margin-top:10px;padding:5px;z-index:1;position:relative;width:auto;height:auto;background-color:white;;border:1px solid black;border-radius:5px;display:none">
                        <text style="margin-left:10%;margin-right:auto;display:inline-block" id="accountNameDetails"></text></br>
                        <input type="button" id="accountDrop" name="accountDrop" value="Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&#x25B2;" style="color:gray;margin-top:5px;height:30px;width:200px;" onclick="clickedDrop()">
                        <input type="button" id="accountCollapse" name="accountCollapse" value="Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&#x25BC;" style="color:gray;margin-top:5px;width:200px;height:30px;" onclick="clickedCollapse()" hidden>
                        <input type="button" id="accountProfile" name="accountProfile" value="Profile &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;" style="margin-top:5px;width:200px;height:30px;" onclick="location.href='../customer/accountDetails.php'" hidden>
                        <input type="button" id="accountSignOut" name="accountSignOut" value="Sign out &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;" style="margin-top:5px;width:200px;height:30px;" onclick="signOut()" hidden>
                    </div></br>
                </div>
            
                <div>
                    <center><input class="mouseOverEffects" type="button" value="Menu" style="margin-top:30px;margin-left:50px;display:inline-block;border-radius:15px;width:200px;height:70px;font-size:30px" onclick="menuFunction()">
                    <input class="mouseOverEffects" type="button" value="Reservation" style="margin-top:30px;margin-left:60px;display:inline-block;border-radius:15px;width:200px;height:70px;font-size:30px" onclick="reservationFunction()"></center></br>
                    <center><img src="../MoshiQ2 IMG Assets/banner.png" style="width:70%;height:auto;display:block;padding:10px"></center>
                    <center><img src="../MoshiQ2 IMG Assets/checkPromos.png" style="width:50%;height:auto;display:block;"></center>
                </div>

                <div style="margin-top:20px;">
                    <img src="../MoshiQ2 IMG Assets/Promo 1.png" style="float:left;width:550px;height:800px;display:inline-block">
                    <img src="../MoshiQ2 IMG Assets/Promo 2.png" style="width:550px;height:800px;display:inline-block">
                </div>
            </div>
            <div class="popupAddress">
                <span class="popuptextAddress" id="myPopupAddress" style="font-size:20px;" hidden>   
                <div style="margin-top:30px;margin:auto;display:block">
                    <input type="button" value="x" style="display:block;position:absolute;margin-left:70%;float:left;top:10px" onclick="closePopupAddress()">
                    <b><u><text>Enter your address details</text></u></b></br></br>
                    <text>Address: </text></br>
                    <input id="inputAddress" type="text" style="width:200px;height:20px" placeholder="Address" onchange="checkAddressFunction()" onkeyup="checkAddressFunction()" onkeydown="checkAddressFunction()"></br></br>
                    <text>Address details: </text></br>
                    <input id="inputAddressDetails" type="text" style="width:200px;height:20px" placeholder="E.g Floor, unit number" onchange="checkAddressFunction()" onkeyup="checkAddressFunction()" onkeydown="checkAddressFunction()"></br></br>
                    <text>Postal code: </text></br>
                    <input id="inputPostalCode" type="text" style="width:200px;height:20px" placeholder="Postal code" onchange="checkAddressFunction()" onkeyup="checkAddressFunction()" onkeydown="checkAddressFunction()"></br></br>
                    <input id="confirmAddressButton" type="button" style="width:100px;height:30px;margin:auto;display:block" value="Confirm" onclick="confirmAddress()" disabled>
                </div>
                </span>
            </div>
            <div class="popupDateTime">
                <span class="popuptextDateTime" id="myPopupDateTime" style="font-size:20px;" hidden>
                <div style="margin-top:30px;margin:auto;display:block">
                    <input type="button" value="x" style="display:block;position:absolute;margin-left:64%;float:left;top:10px" onclick="closePopupDateTime()">
                    <b><u><text>Select date and time</text></u></b></br></br>
                    <text>Date : </text><input id="dateSelect" type="date" onchange="getDateTime();checkDateTimeFunction()" min="<?= date('Y-m-d'); ?>"><br><br>
                    <text>Time slot: </text><select id="timeSelect" style="width:60px;text-align:center" onchange="checkDateTimeFunction()">
                        <option value="11:00" id="11:00">11:00</option>
                        <option value="12:00" id="12:00">12:00</option>
                        <option value="13:00" id="13:00">13:00</option>
                        <option value="14:00" id="14:00">14:00</option>
                        <option value="15:00" id="15:00">15:00</option>
                        <option value="16:00" id="16:00">16:00</option>
                        <option value="17:00" id="17:00">17:00</option>
                        <option value="18:00" id="18:00">18:00</option>
                        <option value="19:00" id="19:00">19:00</option>
                        <option value="20:00" id="20:00">20:00</option>
                    </select></br></br>
                    <input id="confirmDateTimeButton" type="button" style="width:100px;height:30px;margin:auto;display:block" value="Confirm" onclick="confirmDateTime()" disabled></br>
                    <center>or deliver</center>
                    <center><input type="button" value="now" style="width:80px;display:block;margin-auto;" onclick="deliverNow()"></center></br>
                </div>
                </span>
            </div>
        </form>
    </body>
</html>