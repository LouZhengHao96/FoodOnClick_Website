<?php
require_once("menuDB.php");
require_once("promoCodesDB.php");
?>
<!DOCTYPE html>
<html>
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        isProfileClicked = false;
        isCartClicked = false;
        var getMenuArray;
        var deliveryPrice = 6;

        function clickedDrop(){
            document.getElementById("accountDrop").style.display= "none";
            document.getElementById("accountCollapse").style.display = "block";
            document.getElementById("accountSignOut").style.display = "block";
        }

        function clickedCollapse(){
            document.getElementById("accountDrop").style.display = "block";
            document.getElementById("accountCollapse").style.display = "none";
            document.getElementById("accountSignOut").style.display = "none";
        }

        function signOut(){
            document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });
            window.location.replace("../LogIn/homepage.php");
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

        function cartClicked(){
            if (isCartClicked == false){
                isCartClicked = true;
                document.getElementById("displayCart").style.display = "block";
                document.getElementById("toggleCheckout").style.display = "none";
            }
            else{
                isCartClicked = false;
                document.getElementById("displayCart").style.display = "none";
                document.getElementById("toggleCheckout").style.display = "none";
            }
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
            profileDetails();
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
                //
                console.log(parseInt(curTime));
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
            profileDetails();
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

        function createItemTables(){
            var itemArrays = '<?php echo json_encode($dataArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var itemArray = itemArrays.split('].');
            var menuArray = [];
            var actualMenuArray = [];
            var x;
            var y;
            var tempString = "";
            var tempString1 = "";
            getMenuArray = [];

            for (x=0;x<itemArray.length;x++)
            {
                menuArray.push(itemArray[x]);
            }
            for (x=0;x<menuArray.length;x++){
                tempString = String(menuArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualMenuArray.push(tempString);
                getMenuArray.push(tempString);
            }
            
            var table;
            var currentRow;
            var row;

            var signatureItemLength = 0;
            var diyItemLength = 0;
            var acaiItemLength = 0;
            var beverageItemLength = 0;

            var tempLength;
            
            for (x=0; x<actualMenuArray.length; x++){ 
                if(actualMenuArray[x][1] == "signature"){
                    signatureItemLength++;
                }
                else if(actualMenuArray[x][1] == "diy"){
                    diyItemLength++;
                }
                else if(actualMenuArray[x][1] == "acai"){
                    acaiItemLength++;
                }
                else if(actualMenuArray[x][1] == "beverages"){
                    beverageItemLength++;
                }
            }

            //Create menu list for signatureItems
            table = document.getElementById("signatureItems");
            currentRow = 0;
            row = table.insertRow(currentRow);
            tempLength = 0;
            for (x=0; x<signatureItemLength; x++){              
                if (x%3 == 0){
                    currentRow++;
                    row = table.insertRow(currentRow);
                }
                var cell = row.insertCell(x%3);
                cell.innerHTML = '<text id="signatureItem' + String(x) + '"></text>'; 
            }
            for(y=0; y<actualMenuArray.length; y++){
                if(actualMenuArray[y][1] == "signature"){
                    document.getElementById("signatureItem"+String(tempLength)).innerHTML = createItemListing(actualMenuArray[y][0], actualMenuArray[y][2], actualMenuArray[y][4], actualMenuArray[y][5], actualMenuArray[y][6]); 
                    tempLength++;
                }
                if(tempLength == signatureItemLength){
                    break;
                }
            }
            

            //Create menu list for diyItems
            table = document.getElementById("diyItems");
            currentRow = 0;
            row = table.insertRow(currentRow);
            tempLength = 0;
            for (x=0; x<diyItemLength; x++){              
                if (x%3 == 0){
                    currentRow++;
                    row = table.insertRow(currentRow);
                }
                var cell = row.insertCell(x%3);
                cell.innerHTML = '<text id="diyItem' + String(x) + '"></text>';
            }
            for(y=0; y<actualMenuArray.length; y++){
                if(actualMenuArray[y][1] == "diy"){
                    document.getElementById("diyItem"+String(tempLength)).innerHTML = createItemListing(actualMenuArray[y][0], actualMenuArray[y][2], actualMenuArray[y][4], actualMenuArray[y][5], actualMenuArray[y][6]);    
                    tempLength++;
                }
                if(tempLength == diyItemLength){
                    break;
                }
            }


            //Create menu list for acaiItems
            table = document.getElementById("acaiItems");
            currentRow = 0;
            row = table.insertRow(currentRow);
            tempLength = 0;
            for (x=0; x<acaiItemLength; x++){              
                if (x%3 == 0){
                    currentRow++;
                    row = table.insertRow(currentRow);
                }
                var cell = row.insertCell(x%3);
                cell.innerHTML = '<text id="acaiItem' + String(x) + '"></text>';
            }
            for(y=0; y<actualMenuArray.length; y++){
                if(actualMenuArray[y][1] == "acai"){
                    document.getElementById("acaiItem"+String(tempLength)).innerHTML = createItemListing(actualMenuArray[y][0], actualMenuArray[y][2], actualMenuArray[y][4], actualMenuArray[y][5], actualMenuArray[y][6]); 
                    tempLength++;
                }
                if(tempLength == acaiItemLength){
                    break;
                }
            }

            //Create menu list for beverageItems
            table = document.getElementById("beverageItems");
            currentRow = 0;
            row = table.insertRow(currentRow);
            tempLength = 0;
            for (x=0; x<beverageItemLength; x++){              
                if (x%3 == 0){
                    currentRow++;
                    row = table.insertRow(currentRow);
                }
                var cell = row.insertCell(x%3);
                cell.innerHTML = '<text id="beverageItem' + String(x) + '"></text>';
            }
            for(y=0; y<actualMenuArray.length; y++){
                if(actualMenuArray[y][1] == "beverages"){
                    document.getElementById("beverageItem"+String(tempLength)).innerHTML = createItemListing(actualMenuArray[y][0], actualMenuArray[y][2], actualMenuArray[y][4], actualMenuArray[y][5], actualMenuArray[y][6]); 
                    tempLength++;
                }
                if(tempLength == beverageItemLength){
                    break;
                }
            }
        }

        function createItemListing(menu_item_ID, item_name, item_picture, item_price, item_stock){
            var checkItemAvailability = false;
            var listingValueColor;
            var stockAvailability;
            if (parseInt(item_stock) > 0){
                listingValueColor = "#C3E3A2";
                checkItemAvailability = true;
                stockAvailability = "Available";
            }
            else{
                listingValueColor = "#E09E9999";
                checkItemAvailability = true;
                stockAvailability = "Unavailable";
            }

            var listing='<td><img src="' + item_picture + '" style="width:200px;height:200px">'+
                            '</br><text>' + item_name + '</text></br></br>' +
                            '<div style="float:left;">' +
                                '<b><text>$' + item_price + '</text></b></br>' +
                                '<input type="button" value="' + stockAvailability + '" style="background-color:' + listingValueColor + ';border:1px;border-radius:10px;margin-top:10px;font-weight:bold">' +
                            '</div>' +
                            '<input class="addButton" id="' + menu_item_ID + '" type="button" value="View" onclick="addFunction(this.id, ' + checkItemAvailability + ')"></td>';

            return listing;
        }

        function addFunction(returned_ID, checkItemAvailability){
            for(var x=0; x<getMenuArray.length; x++){
                if(getMenuArray[x][0] == returned_ID){
                    popupFunction(getMenuArray[x][0], getMenuArray[x][2], getMenuArray[x][3], getMenuArray[x][4], getMenuArray[x][5], checkItemAvailability);
                    break;
                }
            }
        }

        function popupFunction(descriptionID, descriptionName, descriptionText, imgSrc, descriptionPrice, checkItemAvailability){
            document.getElementById("descriptionBox").style.visibility = 'visible';
            var itemAvailability;
            document.getElementById("descriptionBox").innerHTML = '<img src="' + imgSrc + '" style="width:300px;height:auto;float:left">' +
                                                                '<input type="button" value="x" style="cursor:pointer;float:right;position:absolute;margin-left:90%;display:block;top:10px" onclick="returnFunction()">' +
                                                                '<b><text style="font-size:30px;">' + descriptionName + '</text></b></br></br></br>'+
                                                                '<text style="font-size:20px;">' + descriptionText + '</text></br>' +

                                                                '<div style="background-color:orange;display:block;width:100%;height:55px;position:absolute;bottom:0px;left:0;">' +
                                                                '<text class="price" style="padding:10px;background-color:transparent;;float:left;position:absolute;bottom:4px;display:block;margin-left:10%;font-size:25px"></text>' +

                                                                '<div class="wrapper" style="position:absolute;bottom:14px;margin-left:40%;background-color:transparent;;">' +
                                                                '<span id="minus' + descriptionID + '">-</span>' + 
                                                                '<span id="num' + descriptionID + '" class="num">1</span>' +
                                                                '<span id="plus' + descriptionID + '">+</span></div>' +

                                                                '<a href="../LogIn/logInScreen.php"><input type="button" class="addToCartButton" name="' + descriptionName + '" id="addToCartButton' + descriptionID + '" value="Sign in to order"' +
                                                                'style="cursor:pointer;position:absolute;bottom:7px;background-color:#437E96;border-radius:10px;border:0px;color:white;height:40px;font-size:25px;width:25%;margin-left:70%;margin-right:auto;display:block"' + 
                                                                'onmouseover="mouseOver(this.id)" onmouseout="mouseOut(this.id)"></a></div>';
        
            var plus = document.getElementById("plus"+descriptionID);
            var minus = document.getElementById("minus"+descriptionID);
            var num = document.getElementById("num"+descriptionID);
            var price = document.querySelector(".price");
            var startingValue = 1;
            price.innerText = "$" + descriptionPrice;
            addButtonListenerFunction(plus, minus, num, startingValue);
        }

        var tempGetAmount = 0;
        function addButtonListenerFunction(plus, minus, num, startingValue){
            tempGetAmount = startingValue;
            plus.addEventListener("click" , ()=>{
                startingValue++;
                startingValue = (startingValue<10) ? startingValue : startingValue;
                tempGetAmount = startingValue;
                num.innerText = startingValue;
            });

            minus.addEventListener("click" , ()=>{
                if(startingValue > 1){
                    startingValue--;
                    startingValue = (startingValue<10) ? startingValue : startingValue;
                }
                tempGetAmount = startingValue;
                num.innerText = startingValue;
            });
        }

        function returnFunction(){
            document.getElementById("descriptionBox").style.visibility = 'hidden';
        }

        function mouseOver(buttonID){
            document.getElementById(buttonID).style.border = "2px solid black";
            document.getElementById(buttonID).style.borderColor = "black";
        }

        function mouseOut(buttonID){
            document.getElementById(buttonID).style.border = "0px";
            document.getElementById(buttonID).style.borderColor = "";
        }

        function displayCartNo(noOfItems){
            if(itemListArray.length>0){
                tempNo = (noOfItems<10) ? "0" + noOfItems : noOfItems;
                document.getElementById("displayCartNumber").innerHTML = tempNo;
                document.getElementById("displayCartNumber").style.display = "block";
                document.getElementById("displayDot").style.display = "block";
            }
            else{
                document.getElementById("displayCartNumber").innerHTML = "0";
                document.getElementById("displayCartNumber").style.display = "none";
                document.getElementById("displayDot").style.display = "none";
            }
        }

        function checkoutFunction(){
            document.getElementById("toggleCheckout").style.display = "block";
            document.getElementById("displayCart").style.display = "none";
        }

        function closeCheckoutClicked(){
            document.getElementById("toggleCheckout").style.display = "none";
        }

        function returnToCartFunction(){
            document.getElementById("displayCart").style.display = "block";
            document.getElementById("toggleCheckout").style.display = "none";
        }

        function orderFunction(){
            document.getElementById("popuptextCreditCard").style.visibility = 'visible';
            document.getElementById("toggleCheckout").style.display = "none";
        }

        var checkDiscount;
        var discountedRates = 0;
        function applyPromoCode(){
            var slotArrays = '<?php echo json_encode($promoCodeArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var slotArray = slotArrays.split('].');
            var promoCodeArray = [];
            var actualPromoCodeArray = [];
            var x;
            var tempString = "";
            var tempString1 = "";
            var tempPromoCode = document.getElementById('applyPromo').value;
            for (x=0;x<slotArray.length;x++)
            {
                promoCodeArray.push(slotArray[x]);
            }
            for (x=0;x<promoCodeArray.length;x++){
                tempString = String(promoCodeArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualPromoCodeArray.push(tempString);
            }
            for (x=0;x<actualPromoCodeArray.length;x++)
            {
                console.log(actualPromoCodeArray[x]);
                console.log(tempPromoCode);
                if (actualPromoCodeArray[x][1] == tempPromoCode){        
                    checkDiscount = actualPromoCodeArray[x][1];
                    document.getElementById("validityText").innerHTML = "Valid";
                    document.getElementById("validityText").style.color = "green";
                    document.getElementById("discountRate").innerHTML = actualPromoCodeArray[x][2] + "%";
                    discountedRates = parseInt(actualPromoCodeArray[x][2])/100;
                    document.getElementById("totalPrice").innerHTML = "$" + (subTotalPrice * parseInt(actualPromoCodeArray[x][2])/100 + parseInt(deliveryPrice)).toFixed(2);
                    break;
                }
                else{
                    checkDiscount = "none";
                    document.getElementById("validityText").innerHTML = "Invalid";
                    document.getElementById("validityText").style.color = "red";
                    document.getElementById("discountRate").innerHTML = "0%";
                    discountedRates = 0;
                    document.getElementById("totalPrice").innerHTML = "$" + (subTotalPrice + deliveryPrice).toFixed(2);
                }
            }
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
            console.log(today);
            console.log(curTime);
            document.getElementById('dateTimeButton').value = today + ", " + curTime;
            console.log(document.cookie);
            setCookie("date", today, 7);
            setCookie("time", curTime, 7);
            console.log(document.cookie);
            document.getElementById("myPopupDateTime").style.visibility = 'hidden';
        }

        function closePopupCreditCard(){
            document.getElementById("popuptextCreditCard").style.visibility = 'hidden';
        }

        function displayCCdetails(){
            document.getElementById("ccPaymentMethod").style.display = 'block';
            document.getElementById("gpPaymentMethod").style.display = 'none';
            document.getElementById("grabPay").checked = false;
        }

        function displayGrabPay(){
            document.getElementById("ccPaymentMethod").style.display = 'none';
            document.getElementById("gpPaymentMethod").style.display = 'block';
            document.getElementById("creditCard").checked = false;
        }

        function paymentMethod(){
            var orderDate = "";
            var orderTime = "";
            var orderPrice = "";
            var orderStatus = "In-progress";
            var orderPromocode = "";
            var item_1 = 1;
            var item_2 = 1;
            var item_3 = 1;
            var item_4 = 1;
            var item_5 = 1;
            var item_6 = 1;
            var item_7 = 1;
            var item_8 = 1;
            var item_9 = 1;
            var item_10 = 1;
            var item_11 = 1;
            var item_12 = 1;

            $.ajax({
                type: "POST",
                url: "order_details_data.php",
                data:{
                    order_date:orderDate,
                    order_time:orderTime,
                    order_price:orderPrice,
                    order_status:orderStatus,
                    order_promocode:orderPromocode,
                    HAWAIIAN_SALMON:item_1,
                    COLOURFUL_GODDESS:item_2,
                    SPICY_MIXED_SALMON:item_3,
                    SHOYU_TUNA_SPECIAL:item_4,
                    FULL_VEGGIELICIOUS:item_5,
                    AVOCADO_SUPREME:item_6,
                    SUMMER_FLING:item_7,
                    CHOC_SWEET:item_8,
                    CARAMEL_NUTTIN:item_9,
                    INCREDIBLE_HULK:item_10,
                    ORANGE_MADNESS:item_11,
                    SPIDEY_SENSES:item_12
                },
                success: function(data){
                Swal.fire({
                    'title': 'Successfully submitted order details!',
                    'text': data,
                    'type': 'success'
                }).then(setTimeout(function(){window.location.replace("../LogIn/homepage.php");}, 2000))
                },
                error: function(data){
                Swal.fire({
                    'title': 'Errors',
                    'text': 'There were errors in your order, please refresh the page and try again.'
                })
                }
            });
        }

        function backButton(){
            window.location.href = "../index.php";
        }
    </script>
    <style>
        .mouseOverEffects{
            border-left: 3px solid white;
            cursor: pointer;
        }

        .mouseOverEffects:hover{
            border-left : 3px solid #437E96;
            cursor: pointer;
        }

        .arrow {
            border: solid black;
            border-width: 0 1px 1px 0;
            display: inline-block;
            padding: 3px;
        }

        .addButton{
            border: none;
            background-color:#437E96;
            border-radius:10px;
            margin-left:50px;
            margin-top:10px;
            color:white;
            height:30px;
            width:60px;
            display:inline-block;
        }

        .addButton:hover{
            cursor: pointer;
            border: 2px solid black;
        }

        .example::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .example {
            -ms-overflow-style: none;  /* IE and Edge */
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

        .wrapper{
            height: 30px;
            min-width: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }

        .wrapper span{
            text-align: center;
            font-size: 30px;
            font-weight: 400;
            width: 100%;
            border-top: 2px solid rgba(0,0,0,0.2);
            border-bottom: 2px solid rgba(0,0,0,0.2);
            cursor: pointer;
        }

        .wrapper span.num{
            font-size:30px;
            border-right: 2px solid rgba(0,0,0,0.2);
            border-left: 2px solid rgba(0,0,0,0.2);
            pointer-events: none;
        }

        .wrapperCart{
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            width: 80px;
        }

        .wrapperCart span{
            text-align: center;
            font-size: 15px;
            font-weight: 100;
            width: 100%;
            border-top: 2px solid rgba(0,0,0,0.2);
            border-bottom: 2px solid rgba(0,0,0,0.2);
            cursor: pointer;
        }

        .wrapperCart span.num{
            font-size: 15px;
            border-right: 2px solid rgba(0,0,0,0.2);
            border-left: 2px solid rgba(0,0,0,0.2);
            pointer-events: none;
        }

        .dot {
            height: 26px;
            width: 26px;
            background-color: #d69696;
            border-radius: 50%;
            display: none;
            margin-left: 964px;
            margin-top: 15px;
            position: absolute;
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

        .cartButtonEffects{
            border-radius:5px;
            border:none;
            cursor:pointer;
            width:150px;
            height:auto;
            display:inline-block;
        }

        .cartButtonEffects:hover {
            border: 1px solid black;
            cursor:pointer;
        }

        .payEffects{
            border: none;
            cursor: pointer;
        }

        .payEffects:hover{
            border: 2px solid black;
            cursor: pointer;
        }

        .backEffects{
            border: none;
            cursor: pointer;
            display:inline-block;
            height:40px;
        }

        .backEffects:hover{
            border: 2px solid black;
            cursor: pointer;
            display:inline-block;
        }
    </style>
    <body onload="createItemTables();" style="background-color:#FEF2E5;">
        <form action="order_details_data.php/" method ="POST">
            <div style="width:1100px;margin-left:auto;margin-right:auto;">
                <div style="float:right;border-bottom:5px solid grey;width:100%;height:120px">
                    <div style="float:left;">
                        <a href="../index.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="margin-left:0px;width:300px;height:auto;display:block;"></a>
                    </div>
                    <div style="float:right;">
                        <input type="button" class="buttonEffects" style="margin-left:0px;margin-top:50px;display:block;font-size:30px;border-radius:10px" value="Sign in here to start ordering!" onclick="location.href='../LogIn/logInScreen.php';">
                    </div>
                </div>
                <div style="margin-left:30px;display:inline-block;border-left:1px;">
                    <text style="color:black;font-size:30px">OUR MENU</text></br>
                    <div>
                        <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                            <div class="mouseOverEffects" style="width:120px">
                                <a href="#signatureDisplay"><input type="button" id="signatureButton" name="signatureButton" value="Signature" style="padding:10px;border:0px;background-color:transparent;cursor:pointer"></a></br>
                            </div>
                        </div></br>
                        <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                            <div class="mouseOverEffects" style="width:120px">
                                <a href="#diyDisplay"><input type="button" id="diyButton" name="diyButton" value="DIY moshiQ&#178; bowls" style="padding:10px;border:0px;background-color:transparent;cursor:pointer"></a></br>
                            </div>
                        </div></br>

                        <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                            <div class="mouseOverEffects" style="width:120px">
                                <a href="#acaiDisplay"><input type="button" id="acaiButton" name="acaiButton" value="Acai Bowls" style="padding:10px;border:0px;background-color:transparent;cursor:pointer"></a></br>
                            </div>
                        </div></br>

                        <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                            <div class="mouseOverEffects" style="width:120px">
                                <a href="#beveragesDisplay"><input type="button" id="beveragesButton" name="beveragesButton" value="Beverages" style="padding:10px;border:0px;background-color:transparent;cursor:pointer"></a></br>
                            </div>
                        </div></br>
                    </div>
                    <div style="margin-top:30px;display:block;float:left;margin-left:40px;">
                        <input class="backEffects" type="button" value="<= Back" style="width:100px;font-size:20px;background-color:#437E96;color:white;border-radius:7px" onclick="backButton()">
                    </div>
                </div>

                <div class="example" style="float:right;width:800px;height:900px;overflow:auto;">
                    <div id="signatureDisplay" style="width:800px;">
                        <table style="border-spacing:20px 0px">
                            <tr>
                                <text style="color:black;font-size:30px;">
                                    <a id="signatureDisplay">SIGNATURE</a>                              
                                </text></br></br>
                                <text>Build your own exclusively now!</text></br>
                            </tr>
                            <table id="signatureItems" style="border-spacing:30px;">
                            </table>
                        </table>
                    </div></br>

                    <div id="diyDisplay" style="width:800px;margin-top:100px">
                        <table style="border-spacing:20px 0px">
                            <tr>
                                <text style="color:black;font-size:30px;">
                                    <a id="diyDisplay">DIY MOSHI&#178; BOWLS</a>                              
                                </text></br></br>
                                <text>Dig into our antioxidant-rich, guilt-free sweet treats!</text>
                            </tr>
                            <table id="diyItems" style="border-spacing:30px;">
                            </table>
                        </table>
                    </div></br>

                    <div id="acaiDisplay" style="width:800px;margin-top:100px">
                        <table style="border-spacing:20px 0px">
                            <tr>
                                <text style="color:black;font-size:30px;">
                                    <a id="acaiDisplay">ACAI</a>                              
                                </text></br></br>
                                <text>Hydrate yourself with any of our beverages!</text>
                            </tr>
                            <table id="acaiItems" style="border-spacing:30px;">
                            </table>
                        </table>
                    </div></br>

                    <div id="beveragesDisplay" style="width:800px;margin-top:100px">
                        <table style="border-spacing:20px 0px">
                            <tr>
                                <text style="color:black;font-size:30px;">
                                    <a id="beveragesDisplay">BEVERAGES</a>                              
                                </text></br></br>
                                <text>Build your own exclusively now!</text>
                            </tr>
                            <table id="beverageItems" style="border-spacing:30px;">
                            </table>
                        </table>
                    </div></br>
                </div> 
                <div class="popup">
                    <div class="popuptext" id="descriptionBox">
                    </div></br>
                </div>   
            </div>
        </form>
    </body>
</html>