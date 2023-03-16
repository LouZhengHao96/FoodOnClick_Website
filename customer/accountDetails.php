<?php
require_once("ordersDB.php");
require_once("promoDB.php");
require_once("accountDB.php");
require_once("reservationDB.php");
?>
<!DOCTYPE html>
<html>
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        isProfileClicked = false;

        function ordersFunction(){
            $("#divTable tr").remove(); 
            
            document.getElementById("ordersDisplay").style.display = 'inline-block';
            document.getElementById("reservationsDisplay").style.display = 'none';
            document.getElementById("accountDisplay").style.display = 'none';
            document.getElementById("promoDisplay").style.display = 'none';

            var dataArrays = '<?php echo json_encode($ordersArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var dataArray = dataArrays.split('].');
            var orderArray = [];
            var promoArrays = [];
            var dateArray = [];
            var dayArray = [];
            var timeArray = [];
            var itemArray = [];
            var tempItemArray = [];
            var tempItemsArray = [];
            var priceArray = [];
            var orderStatusArray = [];
            var actualOrderArray = [];
            const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            var x;
            var tempString = "";
            for (x=0;x<dataArray.length;x++)
            {
                orderArray.push(dataArray[x]);
            }
            for (x=0;x<orderArray.length;x++){
                tempString = String(orderArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualOrderArray.push(tempString);
            }
            tempItemsArray = [];
            var tempText;
            for (x=0;x<actualOrderArray.length;x++)
            {
                if(actualOrderArray[x][1] == getCookie("accountID")){
                    promoArrays.push("#" + actualOrderArray[x][0]);
                    dateArray.push(actualOrderArray[x][2]);
                    timeArray.push(actualOrderArray[x][3]);
                    priceArray.push(actualOrderArray[x][4]);
                    orderStatusArray.push(actualOrderArray[x][5]);

                    var getD = new Date(actualOrderArray[x][2]);
                    dayArray.push(weekday[getD.getDay()]);

                    console.log(actualOrderArray[x][10]);
                    var splitList = actualOrderArray[x][10].split("~~");
                    tempText = "";
                    for(var y=0; y<splitList.length;y++){
                        tempText += splitList[y]  + "</br>";
                    }   
                    tempItemsArray.push(tempText);
                }  
                
            }
            var x;
            var y;
            var tempString = "";
            var table = document.getElementById('ordersList');

            for (x=0; x<promoArrays.length; x++){
                var row = table.insertRow(x);
                var cell = row.insertCell(0);
                cell.innerHTML = '<text id="order' + String(x) + '"></text>';
            }

            var table = document.getElementById('deliveredList');

            for (x=0; x<promoArrays.length; x++){
                var row = table.insertRow(x);
                var cell = row.insertCell(0);
                cell.innerHTML = '<text id="delivered' + String(x) + '"></text>';
            }
            var j=0;
            for (x=promoArrays.length-1; x>=0; x--){
                if(orderStatusArray[x] == "In-progress"){
                    document.getElementById("order"+String(j)).innerHTML = '<text style="border-radius:15px;background-color:#C7FAC9;border:0px;margin-top:2px;width:600px;padding:5px;display:inline-block">' +
                                                            '<b>Order ID:</b> '+ promoArrays[x] + '</br>' +
                                                            '<b>Date & Time:</b> '+ dateArray[x] + 
                                                            ' (' + dayArray[x] + '), ' + timeArray[x] +
                                                            '</br></br>' + tempItemsArray[x] + '</br>' +  
                                                            '<text><b><u>Total cost: </u></b></text>' +
                                                            '<b style="float:right;">' + priceArray[x] + 
                                                            '</b></text></br>';
                }
                else{
                    document.getElementById("delivered"+String(j)).innerHTML = '<text style="border-radius:15px;background-color:#C7FAC9;border:0px;margin-top:2px;width:600px;padding:5px;display:inline-block">' +
                                                            '<b>Order ID:</b> '+ promoArrays[x] + '</br>' +
                                                            '<b>Date & Time:</b> '+ dateArray[x] + 
                                                            ' (' + dayArray[x] + '), ' + timeArray[x] +
                                                            '</br></br>' + tempItemsArray[x] + '</br>' +  
                                                            '<text><b><u>Total cost: </u></b></text>' +
                                                            '<b style="float:right;">' + priceArray[x] + 
                                                            '</b></text></br>';
                }
                console.log(itemArray);
                j++;
            }
        }

        function reservationsFunction(){
            $("#divTable tr").remove(); 
            document.getElementById("ordersDisplay").style.display = 'none';
            document.getElementById("reservationsDisplay").style.display = 'block';
            document.getElementById("accountDisplay").style.display = 'none';
            document.getElementById("promoDisplay").style.display = 'none';

            var dataArrays = '<?php echo json_encode($reservationsArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var dataArray = dataArrays.split('].');
            var reservationArray = [];
            var reservationArrays = [];
            var dateArray = [];
            var dayArray = [];
            var timeArray = [];
            var seatsArray = [];
            var paxArray = [];
            var idArray = [];
            var actualReservationArray = [];
            const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            var x;
            var tempString = "";
            for (x=0;x<dataArray.length;x++)
            {
                reservationArray.push(dataArray[x]);
            }
            for (x=0;x<reservationArray.length;x++){
                tempString = String(reservationArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualReservationArray.push(tempString);
            }
            for (x=0;x<actualReservationArray.length;x++)
            {
                if(actualReservationArray[x][1] == getCookie("accountID")){
                    reservationArrays.push(actualReservationArray[x][0]);
                    dateArray.push(actualReservationArray[x][6]);
                    paxArray.push(actualReservationArray[x][8]);
                    idArray.push(actualReservationArray[x][0]);
                    seatsArray.push(actualReservationArray[x][9]);
                    var getD = new Date(actualReservationArray[x][6]);
                    dayArray.push(weekday[getD.getDay()]);

                    var timeValue;
                    switch(actualReservationArray[x][7]){
                        case 'timeSlot1':
                            timeValue = "11:00";
                            break;
                        case 'timeSlot2':
                            timeValue = "12:00";
                            break;
                        case 'timeSlot3':
                            timeValue = "13:00";
                            break;
                        case 'timeSlot4':
                            timeValue = "14:00";
                            break;
                        case 'timeSlot5':
                            timeValue = "15:00";
                            break;
                        case 'timeSlot6':
                            timeValue = "16:00";
                            break;
                        case 'timeSlot7':
                            timeValue = "17:00";
                            break;
                        case 'timeSlot8':
                            timeValue = "18:00";
                            break;
                        case 'timeSlot9':
                            timeValue = "19:00";
                            break;
                        case 'timeSlot10':
                            timeValue = "20:00";
                            break;
                    }
                    timeArray.push(timeValue);
                }
            }

            var x;
            var y;
            var tempString = "";
            var table = document.getElementById('reservationsList');

            for (x=0; x<reservationArrays.length; x++){
                var row = table.insertRow(x);
                var cell = row.insertCell(0);
                cell.innerHTML = '<text id="reservation' + String(x) + '"></text>';
            }

            var j=0;
            for (x=reservationArrays.length-1; x>=0; x--){
                var tempTotalSeats= "";
                for(y=0; y<seatsArray[x].length; y++){
                    if(y+1 == seatsArray[x].length){
                        tempTotalSeats += seatsArray[x][y];
                    }
                    else{
                        tempTotalSeats += seatsArray[x][y] + ", ";
                    }
                }
                document.getElementById("reservation"+String(j)).innerHTML = '<text style="border-radius:15px;background-color:#A0D5EB;border:0px;margin-top:2px;width:550px;padding:5px;display:inline-block">' +
                                                        '<div style="float:right;display:inline-block;text-align:right;">' +
                                                        '<b><u><text id="' + idArray[x] + '" style="cursor:pointer" onclick="editReservation(this.id)">Edit reservation</text></u></b></br></br>' + 
                                                        '<b><u><text id="' + idArray[x] + '" style="cursor:pointer" onclick="cancelReservation(this.id)">Cancel reservation</text></u></b></div>' +
                                                        '<b>Reservation ID:</b> ' + idArray[x] + '</br></br>' +
                                                        '<b>Date & Time:</b> '+ dayArray[x] + ', ' + dateArray[x] + ', ' + timeArray[x] + '</br></br>' +
                                                        '<b>Pax amount:</b> ' + paxArray[x] + '</br></br>' +
                                                        '<b>Seating area(s):</b> ' + tempTotalSeats + '</text></br>';     
                j++;           
            }
        }

        function editReservation(reservationID){
            setCookie("reservationID", reservationID, 1);
            window.location.replace("edit_reservation.php");
        }

        function setCookie(nameCookie, valueCookie, timeCookie){
            const date = new Date();
            date.setTime(date.getTime() +  (timeCookie * 24 * 60 * 60 * 1000));
            let expires = "expires=" + date.toUTCString();
            document.cookie = `${nameCookie}=${valueCookie}; ${expires}; path=/`
        }

        function cancelReservation(reservationID){
            $.ajax({
                type: "POST",
                url: "delete_reservation_details.php",
                data:{
                    cancel_link_1:reservationID
                },
                success: function(data){
                    Swal.fire({
                        'title': 'Successfully cancelled reservation!',
                        'text': data,
                        'type': 'success'
                    }).then(setTimeout(function(){window.location.replace("../customer/accountDetails.php");}, 2000))
                    },
                    error: function(data){
                    Swal.fire({
                        'title': 'Errors',
                        'text': 'There were errors in your order, please refresh the page and try again.'
                    })
                }
            });
        }

        function accountFunction(){
            document.getElementById("ordersDisplay").style.display = 'none';
            document.getElementById("reservationsDisplay").style.display = 'none';
            document.getElementById("accountDisplay").style.display = 'block';
            document.getElementById("promoDisplay").style.display = 'none';
        }

        function promoFunction(){
            $("#divTable tr").remove(); 
            document.getElementById("ordersDisplay").style.display = 'none';
            document.getElementById("reservationsDisplay").style.display = 'none';
            document.getElementById("accountDisplay").style.display = 'none';
            document.getElementById("promoDisplay").style.display = 'block';

            var dataArrays = '<?php echo json_encode($promoArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var dataArray = dataArrays.split('].');
            var promoArray = [];
            var actualPromoArray = [];

            var x;
            var tempString = "";
            for (x=0;x<dataArray.length;x++)
            {
                promoArray.push(dataArray[x]);
            }
            for (x=0;x<promoArray.length;x++){
                tempString = String(promoArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualPromoArray.push(tempString);
            }
            var x;
            var y;
            var tempString = "";
            var table = document.getElementById('promoList');

            for (x=0; x<actualPromoArray.length; x++){
                var row = table.insertRow(x);
                var cell = row.insertCell(0);
                cell.innerHTML = '<text id="promo' + String(x) + '"></text>';
            }

            var j=0;
            for (x=actualPromoArray.length-1; x>=0; x--){
                var codeName = actualPromoArray[x][0];
                if(actualPromoArray[x][0] == ""){
                    codeName = "Present this code to a staff!"
                }
                else{
                    codeName = "Enter this code before check out to enjoy the benefit! </br> &emsp;&emsp;&emsp;&emsp;&emsp;" + codeName;
                }
                document.getElementById("promo"+String(j)).innerHTML = '<text style="background-color:#A8A1A166;border:0px;margin-top:10px;width:600px;padding:5px;display:inline-block">' +
                                                        '<center><img src="' + actualPromoArray[x][2] + '" style="width:100%;height:auto;"></center></br>' +
                                                        '<text>' + actualPromoArray[x][1] + '% OFF ' + actualPromoArray[x][5] +'</text></br></br>' + 
                                                        '<text>Valid: ' + actualPromoArray[x][3].replaceAll("-", "/") + '-' + actualPromoArray[x][4].replaceAll("-", "/") + '</text></br></br>' +
                                                        '<text>' + codeName + '</text>';     
                j++;          
            }
        }

        function reminderFunction(){
            document.getElementById("ordersDisplay").style.display = 'none';
            document.getElementById("reservationsDisplay").style.display = 'none';
            document.getElementById("accountDisplay").style.display = 'none';
            document.getElementById("promoDisplay").style.display = 'none';
        }

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
            console.log(document.cookie);
            var tempLogInName = getCookie("fullName");
            document.getElementById('accountNameDetails').innerHTML = tempLogInName;
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

        function goToUpdateFunction(){
            document.getElementById('accountCustomerTab').style.display = "none";
            document.getElementById('updateAccountTab').style.display = "block";
            displayUpdateAccountDetails();
        }

        function returnToFunction(){
            document.getElementById('accountCustomerTab').style.display = "block";
            document.getElementById('updateAccountTab').style.display = "none";
        }

        function displayAccountDetails(){
            var getEmail = document.getElementById('delAccountEmail');
            var getName = document.getElementById('delAccountName');
            var getNumber = document.getElementById('delAccountNumber');
            getEmail.value = getCookie('email');
            
            var slotArrays = '<?php echo json_encode($accountArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var slotArray = slotArrays.split('].');
            var accountArray = [];
            var actualAccountArray = [];
            var x;
            var y;
            var tempString = "";
            var tempString1 = "";

            var checkTOF = true;
            for (x=0;x<slotArray.length;x++)
            {
                accountArray.push(slotArray[x]);
            }
            for (x=0;x<accountArray.length;x++){
                tempString = String(accountArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualAccountArray.push(tempString);
            }
            for(x=0; x<actualAccountArray.length; x++){
                if(actualAccountArray[x][0] == getCookie('accountID')){
                    getName.value = actualAccountArray[x][2];
                    getNumber.value = actualAccountArray[x][5];
                    break;
                }
            }
        }

        function displayUpdateAccountDetails(){
            var getEmail = document.getElementById('updateAccountEmail');
            var getName = document.getElementById('updateAccountName');
            var getNumber = document.getElementById('updateAccountNumber');
            var getPassword = document.getElementById('updateAccountPassword');
            getEmail.value = getCookie('email');
            
            var slotArrays = '<?php echo json_encode($accountArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var slotArray = slotArrays.split('].');
            var accountArray = [];
            var actualAccountArray = [];
            var x;
            var y;
            var tempString = "";
            var tempString1 = "";

            var checkTOF = true;
            for (x=0;x<slotArray.length;x++)
            {
                accountArray.push(slotArray[x]);
            }
            for (x=0;x<accountArray.length;x++){
                tempString = String(accountArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualAccountArray.push(tempString);
            }
            for(x=0; x<actualAccountArray.length; x++){
                if(actualAccountArray[x][0] == getCookie('accountID')){
                    getName.value = actualAccountArray[x][2];
                    getNumber.value = actualAccountArray[x][5];
                    getPassword.value = actualAccountArray[x][4];
                    break;
                }
            }
            checkUpdateFields();
        }

        function goToOrder(){
            window.location.replace("../menuItems/menuList.php");
        }

        function goToReservation(){
            window.location.replace("../reservation/reservation_details.php");
        }

        function updateAccountFunction(){
            $.ajax({
                type: "POST",
                url: "updateAccount_details.php",
                data:{
                    input_update_email_1: document.getElementById("updateAccountEmail").value,
                    input_update_name_1: document.getElementById("updateAccountName").value,
                    input_update_num_1: document.getElementById("updateAccountNumber").value,
                    input_update_pass_1: document.getElementById("updateAccountPassword").value
                },
                success: function(data){
                    Swal.fire({
                        'title': 'Successfully updated account!',
                        'text': data,
                        'type': 'success'
                    }).then(setTimeout(function(){window.location.replace("../customer/accountDetails.php");}, 2000))
                    },
                    error: function(data){
                    Swal.fire({
                        'title': 'Errors',
                        'text': 'There were errors in updating your account, please refresh the page and try again.'
                    })
                }
            });
        }

        function checkUpdateFields(){
            var inputName = document.getElementById("updateAccountName").value;
            var inputNum = document.getElementById("updateAccountNumber").value;
            var inputPass = document.getElementById("updateAccountPassword").value;
            var inputEmail = document.getElementById("updateAccountEmail").value;
            if(inputName === "" || inputNum === "" || inputPass === "" || inputEmail === "" || inputNum.length != 8){
                document.getElementById("input_update_button_1").disabled = true;
            }
            else{
                document.getElementById("input_update_button_1").disabled = false;
            }
        }
    </script>
    <style>
        .mouseOverEffects:hover{
            border-left : 3px solid #437E96;
        }

        .buttonEffects{
            border: none;
        }

        .buttonEffects:hover{
            border: 2px solid black;
            display: inline-block;
        }

        .example::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .example {
            -ms-overflow-style: none;  /* IE and Edge */
        }
    </style>
    <body onload="profileDetails();" style="background-color:#FEF2E5">

            <div style="width:1100px;margin-left:auto;margin-right:auto;">
                <div style="float:right">
                    <img src="../MoshiQ2 IMG Assets/Profile Icon.png" style="display:block;margin-left:auto;width:70px;height:auto;cursor:pointer;" onclick="profileClicked()"></br>
                    <div id="displayProfile" name="displayProfile" style="float:right;margin-top:10px;padding:5px;z-index:1;position:relative;width:auto;height:auto;background-color:white;;border:1px solid black;border-radius:5px;display:none">
                        <text style="margin-left:10%;margin-right:auto;display:inline-block" id="accountNameDetails"></text></br>
                        <input type="button" id="accountDrop" name="accountDrop" value="Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&#x25B2;" style="color:gray;margin-top:5px;height:30px;width:200px;" onclick="clickedDrop()">
                        <input type="button" id="accountCollapse" name="accountCollapse" value="Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&#x25BC;" style="color:gray;margin-top:5px;width:200px;height:30px;" onclick="clickedCollapse()" hidden>
                        <input type="button" id="accountProfile" name="accountProfile" value="Profile &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;" style="margin-top:5px;width:200px;height:30px;" onclick="location.href='../customer/accountDetails.php'" hidden>
                        <input type="button" id="accountSignOut" name="accountSignOut" value="Sign out &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;" style="margin-top:5px;width:200px;height:30px;" onclick="signOut()" hidden>
                    </div></br>
                </div>

                <div>
                    <a href="customer_landingPage.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="margin-left:0px;width:500px;height:200px;display:inline-block"></a></br></br>
                </div>

                <div style="float:left;margin-left:30px;display:inline-block">
                    <text style="color:#437E96;font-size:30px">ACCOUNT</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                    <div class="mouseOverEffects" style="width:120px">
                        <input type="button" id="ordersButton" name="ordersButton" value="Orders" style="padding:10px;border:0px;background-color:transparent;cursor:pointer;width:120px;text-align:left;" onclick="ordersFunction()"></br>
                    </div>

                    <div class="mouseOverEffects" style="width:120px">
                        <input type="button" id="reservationsButton" name="reservationsButton" value="Reservations" style="padding:10px;border:0px;background-color:transparent;cursor:pointer;width:120px;text-align:left" onclick="reservationsFunction()"></br>
                    </div>

                    <div class="mouseOverEffects" style="width:120px">
                        <input type="button" id="accountButton" name="accountButton" value="Account" style="padding:10px;border:0px;background-color:transparent;cursor:pointer;width:120px;text-align:left" onclick="accountFunction();displayAccountDetails();"></br>
                    </div>

                    <div class="mouseOverEffects" style="width:120px">
                        <input type="button" id="promoButton" name="promoButton" value="Promo Codes" style="padding:10px;border:0px;background-color:transparent;cursor:pointer;width:120px;text-align:left" onclick="promoFunction()"></br></br>
                    </div>
                    <div>
                        <input type="button" class="buttonEffects" style="border-radius:10px;font-size:20px;background-color:#A8A1A166;cursor:pointer" value="Place an order" onclick="goToOrder()"></br></br>
                        <input type="button" class="buttonEffects" style="border-radius:10px;font-size:20px;background-color:#A8A1A166;cursor:pointer" value="Reserve a table" onclick="goToReservation()">
                    </div>
                </div>

                <div style="float:left;margin-left:210px;margin-top:-30px">
                    <div id="ordersDisplay" style="display:none;width:600px;">
                        <text style="color:#437E96;font-size:30px;">
                            Orders                               
                        </text>
                        </br></br>
                        <text style="font-size:20px;color:black;display:inline-block">
                            Keep track of your upcoming and past orders all in one place.
                        </text>
                        </br></br></br>
                        <text style="color:#437E96;font-size:30px;">
                            Upcoming Orders                               
                        </text>
                        </br></br>
                        <div id="divTable" class="example" style="overflow-y:scroll;width:650px;max-height:500px">
                            <table id="ordersList"></table>
                        </div>                
                        </br></br></br>
                        <text style="color:#437E96;font-size:30px;">
                            Past Orders                               
                        </text>
                        <div id="divTable" class="example" style="overflow-y:scroll;width:650px;max-height:500px">
                            <table id="deliveredList"></table>
                        </div> 
                    </div>

                    <div id="reservationsDisplay" style="display:none;width:600px;">
                        <text style="color:#437E96;font-size:30px;">
                            Reservations                              
                            </text>
                        </br></br>
                        <text style="font-size:20px;color:black;display:inline-block">
                            Keep track of your reservations all in one place.
                        </text>
                        </br></br>
                        <div id="divTable" class="example" style="overflow-y:scroll;width:650px;max-height:700px">
                            <table id="reservationsList"></table>
                        </div>                
                    </div>

                    
                    <div id="accountDisplay" style="display:none;width:600px;">
                        <form action='updateAccount_details.php' method="POST" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to delete your account?');">
                        <div id="accountCustomerTab" style="display:block">
                            <text style="color:#437E96;font-size:30px;">
                                Account - Customer                         
                            </text>
                            </br></br>
                            <label style="width:100px;display:inline-block;text-align:left;font-size:20px;background-color:#3280F466;padding-left:5px">Email: </label><input type="text" id="delAccountEmail" style="margin-left:20px;background-color:#A8A1A166;display:inline-block;border:none;border-radius:5px;font-size:20px" name="default_email1" readonly></br></br>

                            <label style="width:100px;display:inline-block;text-align:left;font-size:20px;background-color:#3280F466;padding-left:5px">Name: </label><input type="text" id="delAccountName" style="margin-left:20px;background-color:#A8A1A166;display:inline-block;border:none;border-radius:5px;font-size:20px" readonly></br></br>

                            <label style="width:100px;display:inline-block;text-align:left;font-size:20px;background-color:#3280F466;padding-left:5px">Number: </label><input type="text" id="delAccountNumber" style="margin-left:20px;background-color:#A8A1A166;display:inline-block;border:none;border-radius:5px;font-size:20px" readonly></br></br></br></br>

                            <input type="button" class="buttonEffects" style="font-size:15px;width:150px;padding:10px;background-color:#5BBDE4CC;border-radius:10px;cursor:pointer" value="Update account" onclick="goToUpdateFunction()">
                            
                            <input type="submit" class="buttonEffects" style="margin-left:50px;font-size:15px;width:150px;padding:10px;background-color:#F80000CC;border-radius:10px;cursor:pointer" value="Delete account" name = "delete_button_1">
                        </div>
                        </form>

                        <form action='updateAccount_details.php' method="POST" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to update your account?');">
                        <div id="updateAccountTab" style="display:none">
                            <text style="color:#437E96;font-size:30px;">
                                Update account                          
                            </text>
                            </br></br>                       
                            <label style="width:100px;display:inline-block;text-align:left;font-size:20px;background-color:#3280F466;padding-left:5px">Email: </label><input type="text" id="updateAccountEmail" style="margin-left:20px;background-color:#A8A1A166;display:inline-block;border:none;border-radius:5px;font-size:20px" name= "input_update_email_1" readonly></br></br>

                            <label style="width:100px;display:inline-block;text-align:left;font-size:20px;background-color:#3280F466;padding-left:5px">Name: </label><input type="text" id="updateAccountName" style="margin-left:20px;background-color:#A8A1A166;display:inline-block;border:none;border-radius:5px;font-size:20px" placeholder="Enter name" name= "input_update_name_1" onchange="checkUpdateFields()"></br></br>


                            <label style="width:100px;display:inline-block;text-align:left;font-size:20px;background-color:#3280F466;padding-left:5px">Number: </label><input type="number" id="updateAccountNumber" style="margin-left:20px;background-color:#A8A1A166;display:inline-block;border:none;border-radius:5px;font-size:20px" placeholder="Enter number" name= "input_update_num_1" onchange="checkUpdateFields()"></br></br>

                            <label style="width:100px;display:inline-block;text-align:left;font-size:20px;background-color:#3280F466;padding-left:5px">Password: </label><input type="text" id="updateAccountPassword" style="margin-left:20px;background-color:#A8A1A166;display:inline-block;border:none;border-radius:5px;font-size:20px" placeholder="Enter password" name= "input_update_pass_1" onchange="checkUpdateFields()"></br></br>

                            <input type="button" class="buttonEffects" style="font-size:15px;width:150px;padding:10px;background-color:#5BBDE4CC;border-radius:10px;cursor:pointer" value="Back" onclick="returnToFunction()">

                            <input type="button" class="buttonEffects" style="margin-left:50px;font-size:15px;width:150px;padding:10px;background-color:#F80000CC;border-radius:10px;cursor:pointer" value="Update account" onclick="updateAccountFunction()" id="input_update_button_1" name="input_update_button_1">
                        </div>
                        </form>
                    </div>

                    <div id="promoDisplay" style="display:none;width:600px;">
                        <text style="color:#437E96;font-size:30px;">
                            Promo Codes                             
                        </text>
                        </br>
                        <text style="font-size:20px;color:black">
                            Save more while enjoying!
                        </text>
                        </br></br>
                        <div id="divTable" class="example" style="overflow-y:scroll;width:650px;max-height:700px">
                            <table id="promoList"></table>
                        </div> 
                    </div>
                </div>         
            </div>
       




    </body>
</html>