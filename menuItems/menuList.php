<?php
require_once("menuDB.php");
require_once("promoCodesDB.php");
require_once("deliveryOrderDB.php");
?>
<!DOCTYPE html>
<html>
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js">
    </script>
    <script type="text/javascript">
        (function(){
            emailjs.init("h8P7-YJmxGhlU0lNA");
        })();
    </script>
    <script>
        isProfileClicked = false;
        isCartClicked = false;
        var getMenuArray;
        var deliveryPrice = 6;
        var orderPromocode = "None";
        var deliveryNumber = 0;
        var itemList = "";
        var currentDate;
        var orderArrayList = [];
        var orderDescription = "";

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
 
        function profileDetails(){
            var deliveryRate = document.getElementById("deliveryPrice");
            deliveryRate.innerHTML = "$" + deliveryPrice.toFixed(2);

            var tempLogInName = getCookie("fullName");
            var tempAddress;
            var tempDateTime;
            if(getCookie("area") == "" || getCookie("area") == null){
                tempAddress = "Enter delivery address";       
            }
            else{
                tempAddress = getCookie("area") + ", " + getCookie("addressDetails") +', S(' + getCookie("postalCode") + ")";
                document.getElementById("confirmDeliveryText").innerHTML = getCookie("area") + ", " + getCookie("addressDetails") +', S(' + getCookie("postalCode") + ")";
            }
            if(getCookie("date") == "" || getCookie("date") == null){
                tempDateTime = "Select date and time";   
            }
            else{
                tempDateTime = getCookie("date") + ", " + getCookie("time");
                document.getElementById("confirmDateTimeText").innerHTML = getCookie("date") + ", " + getCookie("time");
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
            currentDate = today;
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
                checkItemAvailability = false;
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
            if (checkItemAvailability == true){
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

                                                                    '<input type="button" class="addToCartButton" name="' + descriptionName + '" id="addToCartButton' + descriptionID + '" value="Add to cart"' +
                                                                    'style="cursor:pointer;position:absolute;bottom:7px;background-color:#437E96;border-radius:10px;border:0px;color:white;height:40px;font-size:25px;width:20%;margin-left:70%;margin-right:auto;display:block"' + 
                                                                    'onmouseover="mouseOver(this.id)" onmouseout="mouseOut(this.id)" onclick="addIntoCart(this.name, ' + descriptionPrice + ', '+ descriptionID +')"></div>';
            }
            else{
                document.getElementById("descriptionBox").innerHTML = '<img src="' + imgSrc + '" style="width:300px;height:auto;float:left">' +
                                                                    '<input type="button" value="x" style="cursor:pointer;float:right;position:absolute;margin-left:90%;display:block;top:10px" onclick="returnFunction()">' +
                                                                    '<b><text style="font-size:30px;">' + descriptionName + '</text></b></br></br></br>'+
                                                                    '<text style="font-size:20px;">' + descriptionText + '</text></br>' +

                                                                    '<div style="background-color:orange;display:block;width:100%;height:55px;position:absolute;bottom:0px;left:0;">' +
                                                                    '<text class="price" style="padding:10px;background-color:transparent;;float:left;position:absolute;bottom:4px;display:block;margin-left:10%;font-size:25px"></text>' +

                                                                    '<div class="wrapper" style="position:absolute;bottom:14px;margin-left:40%;background-color:transparent;;">' +
                                                                    '<span id="minus' + descriptionID + '">-</span>' + 
                                                                    '<span id="num' + descriptionID + '" class="num">01</span>' +
                                                                    '<span id="plus' + descriptionID + '">+</span></div>' +

                                                                    '<input type="button" class="addToCartButton" name="' + descriptionName + '" id="addToCartButton' + descriptionID + '" value="Add to cart"' +
                                                                    'style="cursor:normal;position:absolute;bottom:7px;background-color:grey;border-radius:10px;border:0px;color:white;height:40px;font-size:25px;width:20%;margin-left:70%;margin-right:auto;display:block" disabled></div>';
            }
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

        var itemListArray = [];
        var itemPriceArray = [];
        var subTotalPrice = 0;
        var entireListArray = [];
        var totalPrice = 0;
        function addIntoCart(foodName, foodPrice, foodID){
            document.getElementById("displayEmpty").style.display = "none";
            document.getElementById("checkoutButton").disabled = false;
            for(var x=0; x<parseInt(tempGetAmount);x++){
                itemListArray.push(foodName);
                itemPriceArray.push(foodPrice);
            }
            displayCartNo(itemListArray.length);
            document.getElementById("descriptionBox").style.visibility = 'hidden';
            var countCart = {};
            var tempCartArray = [];
            var countPrice = {};
            var tempPriceArray = [];
            for (var x=0; x<itemListArray.length; x++) {
                if (countCart[itemListArray[x]]){
                    countCart[itemListArray[x]] += 1;
                    countPrice[itemListArray[x]] += 1;
                } 
                else{
                    countCart[itemListArray[x]] = 1;
                    countPrice[itemListArray[x]] = 1;
                    tempCartArray.push(itemListArray[x]);
                    tempPriceArray.push(itemPriceArray[x]);
                }
            }

            var table;
            var currentRow;
            var row;

            table = document.getElementById("displayCartItems");
            table.innerHTML = "";
            var x;
            for (x=0; x<Object.keys(countCart).length; x++){                               
                row = table.insertRow(x);
                var cell = row.insertCell(0);
                cell.innerHTML = '<text id="displayListedItem' + String(x) + '"></text>';
            }

            subTotalPrice = 0;
            entireListArray = [];
            itemList = "";
            orderArrayList = [];
            for (var x=0; x<tempCartArray.length; x++){
                orderArrayList.push([tempCartArray[x], countCart[tempCartArray[x]]]);
                var getDisplayElement = document.getElementById('displayListedItem' + String(x));
                getDisplayElement.innerHTML = displayCartItems(tempCartArray[x] , tempPriceArray[x], countCart[tempCartArray[x]], x);
                var plus = document.getElementById("plusA" + x);
                var minus = document.getElementById("minusA" + x);
                var num = document.getElementById("numA" + x);
                var startingValue = countCart[tempCartArray[x]];  
                
                subTotalPrice += tempPriceArray[x] * countCart[tempCartArray[x]];
                entireListArray.push(tempCartArray[x], tempPriceArray[x], countCart[tempCartArray[x]]);  
                addCartButtonListenerFunction(plus, minus, num, startingValue, tempCartArray[x], tempPriceArray[x], getDisplayElement);       
            }
            document.getElementById("cartPrice").innerHTML = "$" + subTotalPrice.toFixed(2);
            if(discountedRates != 0){
                totalPrice = subTotalPrice * discountedRates + deliveryPrice;
                document.getElementById("totalPrice").innerHTML = "$" + (totalPrice).toFixed(2); 
            }
            else{
                totalPrice = subTotalPrice + deliveryPrice;
                document.getElementById("totalPrice").innerHTML = "$" + (totalPrice).toFixed(2);
            }
        }

        var tempCartGetAmount = 0;
        function addCartButtonListenerFunction(plus, minus, num, startingValue, foodName, foodPrice, hideElement){
            tempCartGetAmount = tempGetAmount + startingValue;
            plus.addEventListener("click" , ()=>{
                var tempStartValue = startingValue;
                startingValue++;
                startingValue = (startingValue<10) ? startingValue : startingValue;
                tempCartGetAmount = startingValue;
                itemListArray.push(foodName);
                itemPriceArray.push(foodPrice);
                num.innerText = startingValue;
                subTotalPrice += foodPrice*(startingValue-tempStartValue);
                document.getElementById("cartPrice").innerHTML = "$" + subTotalPrice.toFixed(2) ;
                if(discountedRates != 0){
                    totalPrice = subTotalPrice * discountedRates + deliveryPrice;
                    document.getElementById("totalPrice").innerHTML = "$" + (totalPrice).toFixed(2); 
                }
                else{
                    totalPrice = subTotalPrice + deliveryPrice;
                    document.getElementById("totalPrice").innerHTML = "$" + (totalPrice).toFixed(2);
                }
                displayCartNo(itemListArray.length);
            });

            minus.addEventListener("click" , ()=>{
                var tempStartValue = startingValue;
                if(startingValue > 1){
                    startingValue--;
                    startingValue = (startingValue<10) ? startingValue : startingValue;
                    var index = itemListArray.indexOf(foodName);
                    if (index > -1) {
                        itemListArray.splice(index, 1);
                        itemPriceArray.splice(index, 1); 
                    }              
                }
                else if(startingValue==1){
                    startingValue--;
                    var index = itemListArray.indexOf(foodName);
                    if (index > -1) {
                        itemListArray.splice(index, 1);
                        itemPriceArray.splice(index, 1); 
                    }
                }
                displayCartNo(itemListArray.length);
                subTotalPrice += foodPrice*(startingValue-tempStartValue);
                if(startingValue == 0 || startingValue == null){
                    hideElement.style.display = "none";                    
                }
                else{
                    hideElement.style.display = "block";
                }
                if(subTotalPrice == 0){
                    document.getElementById("displayEmpty").style.display = "block";
                    document.getElementById("checkoutButton").disabled = true;
                    document.getElementById("toggleCheckout").style.display = "none";
                }
                document.getElementById("cartPrice").innerHTML = "$" + subTotalPrice.toFixed(2);
                if(discountedRates != 0){
                    totalPrice = subTotalPrice * discountedRates + deliveryPrice;
                    document.getElementById("totalPrice").innerHTML = "$" + (totalPrice).toFixed(2); 
                }
                else{
                    totalPrice = subTotalPrice + deliveryPrice;
                    document.getElementById("totalPrice").innerHTML = "$" + (totalPrice).toFixed(2);
                }
                tempCartGetAmount = startingValue;
                num.innerText = startingValue;
            });
        }

        function displayCartItems(itemName, itemPrice, itemAmount, itemID){    
            var cartItem = '<div  style="display:inline-block;width:100%">' +
                            '<text style="font-size:15px;float:left;width:330px;padding:5px">' + itemName + '</text>' +
                            '<div class="wrapperCart" style="float:left;margin-left:10px;background-color:transparent;;">'+
                                '<span id="minusA' + itemID + '">-</span>'+
                                '<span id="numA' + itemID + '" class="num1">' + itemAmount + '</span>' +
                                '<span id="plusA' + itemID + '">+</span>' +
                            '</div>' +
                            '<b><text style="margin-left:20px;float:right;display:block;font-size:15px;">$' + itemPrice.toFixed(2) + '</text></div></b>';     
            itemList += itemAmount + "x " +  itemName + " = $" + (itemPrice*itemAmount).toFixed(2) + " <br>";
            return cartItem;
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
                if (actualPromoCodeArray[x][1] == tempPromoCode){        
                    checkDiscount = actualPromoCodeArray[x][1];
                    document.getElementById("validityText").innerHTML = "Valid";
                    document.getElementById("validityText").style.color = "green";
                    document.getElementById("discountRate").innerHTML = actualPromoCodeArray[x][2] + "%";
                    discountedRates = parseInt(100 - actualPromoCodeArray[x][2])/100;
                    totalPrice = subTotalPrice * discountedRates + parseInt(deliveryPrice);
                    document.getElementById("totalPrice").innerHTML = "$" + totalPrice.toFixed(2);
                    orderPromocode = tempPromoCode;
                    break;
                }
                else{
                    checkDiscount = "none";
                    document.getElementById("validityText").innerHTML = "Invalid";
                    document.getElementById("validityText").style.color = "red";
                    document.getElementById("discountRate").innerHTML = "0%";
                    discountedRates = 0;
                    totalPrice = subTotalPrice + deliveryPrice
                    document.getElementById("totalPrice").innerHTML = "$" + totalPrice.toFixed(2);
                    orderPromocode = "None";
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
            document.getElementById('dateTimeButton').value = today + ", " + curTime;
            setCookie("date", today, 7);
            setCookie("time", curTime, 7);
            document.getElementById("myPopupDateTime").style.visibility = 'hidden';
            document.getElementById("confirmDateTimeText").innerHTML = today + ", " + curTime;
            setCookie("clickedCurrentTime", "true", 1);
        }

        function closePopupCreditCard(){
            document.getElementById("popuptextCreditCard").style.visibility = 'hidden';
        }

        function displayCCdetails(){
            document.getElementById("ccPaymentMethod").style.display = 'block';
            document.getElementById("cash").checked = false;
            document.getElementById("cashPaymentMethod").style.display = "none";
            getTotalDelivery();
        }

        function cc_PaymentMethod(){
            if(document.getElementById("ccName").value == "" || 
                document.getElementById("ccNum").value == "" || document.getElementById("ccNum").value.length < 16 || 
                document.getElementById("ccExpiry").value == "" || document.getElementById("ccExpiry").value.length < 4 || 
                document.getElementById("ccDigits").value == "" || document.getElementById("ccDigits").value.length < 3){
                alert("Please enter all fields correctly");
            }
            else{
                var accountID = getCookie("accountID");
                var orderDate = getCookie("date");
                var orderTime = getCookie("time");
                var orderPrice = "$" + String(totalPrice.toFixed(2));
                var orderStatus = "In-progress";
                var cc_number = document.getElementById("ccNum").value;
                var addressDetails = getCookie("area") + " " + getCookie("addressDetails") + ", s(" + getCookie("postalCode") + ")";
                getTotalDelivery();

                orderDescription = "";
                for(var x=0; x<orderArrayList.length; x++){
                    if(x+1 == orderArrayList.length){
                        orderDescription += orderArrayList[x][1] + "x " + orderArrayList[x][0];
                    }
                    else{
                        orderDescription += orderArrayList[x][1] + "x " + orderArrayList[x][0] + "<br>";
                    }
                }
                console.log(orderDescription.replaceAll("<br>", "~~"));
                console.log(orderDescription);

                $.ajax({
                    type: "POST",
                    url: "order_details_data.php",
                    data:{
                        accountID:accountID,
                        order_date:orderDate,
                        order_time:orderTime,
                        order_price:orderPrice,
                        order_status:orderStatus,
                        order_promocode:orderPromocode,
                        order_address:addressDetails,
                        order_description:orderDescription.replaceAll("<br>", "~~"),
                        order_payment:"CC"
                    },
                    success: function(data){
                    Swal.fire({
                        'title': 'Successfully submitted order details!',
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
                
                var inboxStatus = "Delivery";
                var inboxDescription = "D" + String(deliveryNumber) +
                                        ": Delivery for " + getCookie("fullName") +
                                        "~~ at " + orderDate.replaceAll('-','/')+ 
                                        "~~ " + orderTime;
                var inboxDate = String(orderDate);

                $.ajax({
                    type: "POST",
                    url: "delivery_inbox_data.php",
                    data:{
                    inboxStatus:inboxStatus,
                    inboxDescription:inboxDescription,
                    inboxDate:inboxDate
                    }
                });

                const serviceID = "service_f6ewb26";
                const templateID = "template_8xfm0mh";
                var displaySubjectType = "Order";
                var orderHours;
                var orderMins;
                var tempTimeArray = String(orderTime).split(":");
                orderHours = parseInt(tempTimeArray[0])*60;
                orderMins = parseInt(tempTimeArray[1]);
                var timingType;
                trafficFunction();

                if(currentDate == orderDate){
                    if(getCookie("clickedCurrentTime") == "true"){
                        timingType = parseInt(getCookie("waitingTiming"));
                    }
                    else{
                        timingType = parseInt(getCookie("preparationTiming"));
                    }
                }
                else{
                    timingType = 0;
                }
                var deliveryETA = timeConvert1(orderHours + orderMins + timingType );
                
                var params = {
                    displaySubjectType: displaySubjectType,
                    deliveryID: deliveryNumber,
                    deliveryETA: deliveryETA,
                    customerName: getCookie("fullName"),
                    emailAddress: getCookie("email"),
                    dateSlot: getCookie("date"),
                    timeSlot: orderTime,
                    addressDetails: addressDetails,
                    promoCode: orderPromocode,
                    totalPrice: orderPrice,
                    itemList: orderDescription
                };

                //Send email
                emailjs.send(serviceID, templateID, params).then(res=>{
                    console.log(res);
                })
                .catch(err=>console.log(err));

                var params = {
                    displaySubjectType: displaySubjectType,
                    deliveryID: deliveryNumber,
                    deliveryETA: deliveryETA,
                    customerName: getCookie("fullName"),
                    emailAddress: "fyp22s3@gmail.com",
                    dateSlot: getCookie("date"),
                    timeSlot: orderTime,
                    addressDetails: addressDetails,
                    promoCode: orderPromocode,
                    totalPrice: orderPrice,
                    itemList: orderDescription
                };

                //Send email
                emailjs.send(serviceID, templateID, params).then(res=>{
                    console.log(res);
                })
                .catch(err=>console.log(err));
            }    
        }

        function timeConvert1(data) {
            var tempMinutes = data % 60;
            var minutes;
            if(tempMinutes < 10){
                minutes = "0" + String(tempMinutes);
            }
            else{
                minutes = tempMinutes;
            }
            var hours = (data - minutes) / 60;  
            return (hours + ":" + minutes);
        }   

        function getTotalDelivery(){
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
            if(actualDeliveryArray.length !=0 && actualDeliveryArray[actualDeliveryArray.length-1] != ""){
                deliveryNumber = parseInt(actualDeliveryArray[actualDeliveryArray.length-1][0])+1;
            }
            else{
                deliveryNumber = 1;
            }
        }

        function trafficFunction(){
            var deliveryNum = 0;
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
                    deliveryNum++;
                }
            }

            var waitingTime;
            var preparationTime;

            waitingTime = deliveryNum*5+20;
            preparationTime = deliveryNum*5+10;
            setCookie("waitingTiming", waitingTime, 1);
            setCookie("preparationTiming", waitingTime, 1);
        }

        function backButton(){
            window.location.href = "../customer/customer_landingPage.php";
        }

        function displayCashDetails(){
            document.getElementById("creditCard").checked = false;
            document.getElementById("ccPaymentMethod").style.display = "none";
            document.getElementById("cashPaymentMethod").style.display = "block";
        }

        function cashPaymentMethod(){
            var accountID = getCookie("accountID");
            var orderDate = getCookie("date");
            var orderTime = getCookie("time");
            var orderPrice = "$" + String(totalPrice.toFixed(2));
            var orderStatus = "In-progress";
            var cc_number = document.getElementById("ccNum").value;
            var addressDetails = getCookie("area") + " " + getCookie("addressDetails") + ", s(" + getCookie("postalCode") + ")";
            getTotalDelivery();

            orderDescription = "";
            for(var x=0; x<orderArrayList.length; x++){
                if(x+1 == orderArrayList.length){
                    orderDescription += orderArrayList[x][1] + "x " + orderArrayList[x][0];
                }
                else{
                    orderDescription += orderArrayList[x][1] + "x " + orderArrayList[x][0] + "<br>";
                }
            }
            console.log(orderDescription.replaceAll("<br>", "~~"));
            console.log(orderDescription);

            $.ajax({
                type: "POST",
                url: "order_details_data.php",
                data:{
                    accountID:accountID,
                    order_date:orderDate,
                    order_time:orderTime,
                    order_price:orderPrice,
                    order_status:orderStatus,
                    order_promocode:orderPromocode,
                    order_address:addressDetails,
                    order_description:orderDescription.replaceAll("<br>", "~~"),
                    order_payment:"Cash"
                },
                success: function(data){
                Swal.fire({
                    'title': 'Successfully submitted order details!',
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
            
            var inboxStatus = "Delivery";
            var inboxDescription = "D" + String(deliveryNumber) +
                                    ": Delivery for " + getCookie("fullName") +
                                    "~~ at " + orderDate.replaceAll('-','/')+ 
                                    "~~ " + orderTime;
            var inboxDate = String(orderDate);

            $.ajax({
                type: "POST",
                url: "delivery_inbox_data.php",
                data:{
                inboxStatus:inboxStatus,
                inboxDescription:inboxDescription,
                inboxDate:inboxDate
                }
            });

            const serviceID = "service_f6ewb26";
            const templateID = "template_8xfm0mh";
            var displaySubjectType = "Order";
            var orderHours;
            var orderMins;
            var tempTimeArray = String(orderTime).split(":");
            orderHours = parseInt(tempTimeArray[0])*60;
            orderMins = parseInt(tempTimeArray[1]);
            var timingType;
            trafficFunction();

            if(currentDate == orderDate){
                if(getCookie("clickedCurrentTime") == "true"){
                    timingType = parseInt(getCookie("waitingTiming"));
                }
                else{
                    timingType = parseInt(getCookie("preparationTiming"));
                }
            }
            else{
                timingType = 0;
            }
            var deliveryETA = timeConvert1(orderHours + orderMins + timingType );
            
            var params = {
                displaySubjectType: displaySubjectType,
                deliveryID: deliveryNumber,
                deliveryETA: deliveryETA,
                customerName: getCookie("fullName"),
                emailAddress: getCookie("email"),
                dateSlot: getCookie("date"),
                timeSlot: orderTime,
                addressDetails: addressDetails,
                promoCode: orderPromocode,
                totalPrice: orderPrice,
                itemList: orderDescription
            };

            //Send email
            emailjs.send(serviceID, templateID, params).then(res=>{
                console.log(res);
            })
            .catch(err=>console.log(err));

            var params = {
                displaySubjectType: displaySubjectType,
                deliveryID: deliveryNumber,
                deliveryETA: deliveryETA,
                customerName: getCookie("fullName"),
                emailAddress: "fyp22s3@gmail.com",
                dateSlot: getCookie("date"),
                timeSlot: orderTime,
                addressDetails: addressDetails,
                promoCode: orderPromocode,
                totalPrice: orderPrice,
                itemList: orderDescription
            };

            //Send email
            emailjs.send(serviceID, templateID, params).then(res=>{
                console.log(res);
            })
            .catch(err=>console.log(err));
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

        .popupCreditCard {
            display: inline-block;
        }

        .popupCreditCard .popuptextCreditCard {
            visibility: hidden;
            display: inline-block;
            padding: 44.2839px 49.2043px;
            gap: 29.52px;

            position: absolute;
            width: 700px;
            height: 500px;
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
    <body onload="profileDetails();createItemTables();displayCartNo();getTotalDelivery()" style="background-color:#FEF2E5;">
        <form action="order_details_data.php/" method ="POST">
            <div style="width:1100px;margin-left:auto;margin-right:auto;">
                <div style="float:right;border-bottom:5px solid grey;width:100%;height:120px">
                    <div style="float:left;">
                        <a href="../customer/customer_landingPage.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="margin-left:0px;width:300px;height:auto;display:block;"></a>
                    </div>
                    <div class="buttonEffects" style="margin-left:170px;float:left;display:inline-block;background-color:#A8A1A166;height:42px;margin-top:25px;padding:5px" onclick="getCurrentLocation()">
                        <img src="../MoshiQ2 IMG Assets/Address.png" style="float:left">
                        <input id="deliveryAddressButton" type="button" style="background-color:transparent;display:inline-block;border:none;cursor:pointer;width:150px;white-space:normal;" value="Enter a delivery address">
                    </div>  
                    <div class="buttonEffects" style="float:left;display:inline-block;background-color:#A8A1A166;margin-left:10px;height:42px;margin-top:25px;padding:5px" onclick="getDateTime()">
                        <img src="../MoshiQ2 IMG Assets/Time.png" style="float:left">
                        <input id="dateTimeButton" type="button" style="background-color:transparent;display:inline-block;border:none;cursor:pointer;width:150px;white-space:normal;" value="Select date and time">
                    </div> 
            
                    <div style="position:relative">
                        <span id="displayDot" class="dot"></span>
                        <text id="displayCartNumber" style="position:absolute;display:block;margin-left:970px;margin-top:20px;"></text>
                        <img src="../MoshiQ2 IMG Assets/Cart.png" style="margin-top:20px;cursor:pointer;margin-left:10px;float:left;margin-right:10px;display:block;width:100px;height:auto" onclick="cartClicked()">
                        <div class="example" id="displayCart" style="margin-left:700px;margin-top:100px;padding:5px;z-index:2;position:absolute;width:500px;white-space:normal;height:auto;background-color:#999999;border:1px solid black;border-radius:5px;display:none;font-size:15px;overflow-y:auto;max-height:600px;">
                            <b><text style="float:left;font-size:30px;display:inline-block">Cart Tab</text></b>
                            <input type="button" value="x" style="cursor:pointer;float:right;position:absolute;margin-left:94%;display:block;top:10px" onclick="cartClicked()"></br></br></br>
                            <div style="margin-top:10px;border-top:2px solid black;">
                                <div style="padding-top:10px">
                                    <table id="displayCartItems">  
                                        <center>
                                            <div>
                                                <text id="displayEmpty" style="font-size:30px;">Your cart is empty!</text>
                                            </div>
                                        </center>                      
                                    </table>
                                </div>
                                <div style="background-color:#a6a6a6">
                                    <div>
                                        <b><text id="cartPrice" style="float:right;margin-right:5px;display:block;padding-top:22px;font-size:15px">$0.00</text>
                                        <text style="border-top:2px solid black;display:block;bottom:0px;padding-top:20px;font-size:15px;margin-left:8px">Subtotal:</text></b></br>
                                        <b><text id="deliveryPrice" style="float:right;margin-right:5px;display:block;padding-top:2px;font-size:15px">$0.00</text>
                                        <text style="border-bottom:2px solid black;display:block;bottom:0px;font-size:15px;margin-left:8px;padding-bottom:5px">Delivery fee:</text>                      
                                    </div>
                                    <div style="margin-top:10px;">
                                        <div style="margin-top:10px;">
                                            <b><text style="display:block;bottom:0px;font-size:15px;margin-left:8px;">Promo Code:</text></b>
                                            <input type="text" id="applyPromo" style="margin-left:8px;width:150px;" placeholder="Got a coupon code?">
                                            <input type="button" value="Apply" style="display:inline-block" onclick="applyPromoCode()">
                                            <text id="validityText" style="margin-left:5px;"></text>
                                            <text id="discountRate" style="float:right;display-inline-block;margin-right:5px"></text>
                                        </div></br>
                                        <div>
                                            <b><text id="totalPrice" style="float:right;margin-right:5px;display:block;padding-top:2px;font-size:15px">$6.00</text>
                                            <text style="border-bottom:2px solid black;display:block;bottom:0px;font-size:15px;margin-left:8px;padding-bottom:5px">Total:</text>   
                                        </div></br>
                                    </div>
                                    <center>
                                        <div class="cartButtonEffects" style="margin-top:10px">
                                            <input type="button" id="checkoutButton" value="Go to checkout" style="width:150px;height:30px;cursor:pointer" onclick="checkoutFunction()" disabled>
                                        </div></br></br>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="example" id="toggleCheckout" style="margin-left:700px;margin-top:100px;padding:5px;z-index:2;position:absolute;width:500px;white-space:normal;height:auto;background-color:#999999;border:1px solid black;border-radius:5px;display:none;font-size:15px;overflow-y:auto;max-height:600px;">
                            <b><input type="button" style="float:left;font-size:30px;display:inline-block;cursor:pointer;background-color:#999999;border:none" value="<" onclick="returnToCartFunction()"></b>
                            <b><text style="margin-left:20px;font-size:30px;display:inline-block">Checkout Tab</text></b>
                            <input type="button" value="x" style="cursor:pointer;float:right;position:absolute;margin-left:94%;display:block;top:10px" onclick="closeCheckoutClicked()"></br></br></br>
                            <div style="background-color:#a6a6a6">
                                <div style="margin-top:10px;border-top:2px solid black;">
                                    <b><text style="display:block;bottom:0px;padding-top:20px;font-size:15px;margin-left:8px">Deliver on</text></b>
                                    <text id="confirmDateTimeText" style="margin-left:8px;"></text>           
                                </div></br>
                                <div style="margin-top:10px;">
                                    <b><text style="display:block;bottom:0px;font-size:15px;margin-left:8px;">Delivery address</text></b>
                                    <text id="confirmDeliveryText" style="margin-left:8px;"></text>
                                </div></br>
                                <center>
                                    <div class="cartButtonEffects" style="margin-top:10px">
                                        <input type="button" id="orderButton" value="Place Order" style="width:150px;height:30px;cursor:pointer" onclick="orderFunction()">
                                    </div></br></br>
                                </center>
                            </div>
                        </div>
                    </div>
                    <img src="../MoshiQ2 IMG Assets/Profile Icon.png" style="cursor:pointer;display:block;float:left;width:70px;height:auto;margin-left:auto" onclick="profileClicked()"></br>
                    <div id="displayProfile" name="displayProfile" style="float:right;margin-top:10px;padding:5px;z-index:1;position:relative;width:auto;height:auto;background-color:white;;border:1px solid black;border-radius:5px;display:none">
                        <text style="margin-left:10%;margin-right:auto;display:inline-block" id="accountNameDetails"></text></br>
                        <input type="button" id="accountDrop" name="accountDrop" value="Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&#x25B2;" style="color:gray;margin-top:5px;height:30px;width:200px;" onclick="clickedDrop()">
                        <input type="button" id="accountCollapse" name="accountCollapse" value="Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&#x25BC;" style="color:gray;margin-top:5px;width:200px;height:30px;" onclick="clickedCollapse()" hidden>
                        <input type="button" id="accountProfile" name="accountProfile" value="Profile &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;" style="margin-top:5px;width:200px;height:30px;" onclick="location.href='../customer/accountDetails.php'" hidden>
                        <input type="button" id="accountSignOut" name="accountSignOut" value="Sign out &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;" style="margin-top:5px;width:200px;height:30px;" onclick="signOut()" hidden>
                    </div></br>
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

                    <div id="diyDisplay" style="width:800px;margin-top:50px">
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

                    <div id="acaiDisplay" style="width:800px;margin-top:50px">
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

                    <div id="beveragesDisplay" style="width:800px;margin-top:50px">
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
                        <text>Date: </text><input id="dateSelect" type="date" onchange="getDateTime();checkDateTimeFunction()" min="<?= date('Y-m-d'); ?>"><br><br>
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
                <div class="popupCreditCard">
                    <span class="popuptextCreditCard" id="popuptextCreditCard" style="font-size:20px;" hidden>
                    <div style="margin-top:30px;margin:auto;display:block;">
                        <input type="button" value="x" style="display:block;position:absolute;margin-left:90%;float:left;top:10px" onclick="closePopupCreditCard()">
                        <b><u><text disabled>Enter your payment details</text></u></b></br></br>
                        <div style="width:100%;height:auto;display:block;border:1px solid black;border-radius:10px;background-color:#BDBDBD26">
                            <div style="width:auto;height:40px;display:block;">
                                <input type="radio" id="creditCard" name="creditCard" value="Credit/Debit card" style="float:left;margin-top:12px" onclick="displayCCdetails()">
                                <img src="../MoshiQ2 IMG Assets/Payment/ccIcon.png" style="height:30px;width:auto;float:left;display:block;margin-top:4px;margin-left:20px">
                                <text style="height:30px;width:auto;float:left;display:block;margin-top:7px;margin-left:20px;color:grey">Credit/Debit card</text>
                                <div style="float:right;margin-right:40px;height:40px;width:auto;">
                                    <img src="../MoshiQ2 IMG Assets/Payment/visa.png" style="height:30px;width:auto;float:left;display:block;margin-top:5px;margin-left:5px">
                                    <img src="../MoshiQ2 IMG Assets/Payment/master.png" style="height:30px;width:auto;float:left;display:block;margin-top:5px;margin-left:5px">
                                    <img src="../MoshiQ2 IMG Assets/Payment/amex.png" style="height:30px;width:auto;float:left;display:block;margin-top:5px;margin-left:5px">
                                    <img src="../MoshiQ2 IMG Assets/Payment/paypal.png" style="height:30px;width:auto;float:left;display:block;margin-top:5px;margin-left:5px">
                                </div>
                            </div>
                            <div id="ccPaymentMethod" style="margin-left:20px;margin-top:20px;display:none">
                                <text style="color:grey">Name on Card</text></br>
                                <input type="text" id="ccName" name="ccName" style="font-size:30px;border-radius:5px;width:93%;border:1px solid grey;padding-left:10px" placeholder="Aaron Bobby Cecil Drake"></br></br>
                                <text style="color:grey">Card number</text></br>
                                <input type="text" id="ccNum" name="ccNum" style="font-size:30px;border-radius:5px;width:93%;border:1px solid grey;padding-left:10px" placeholder="1111 2222 3333 4444" maxlength="16" onkeypress="return /[0-9]/i.test(event.key)"></br></br>
                                <div>
                                    <text style="color:grey;float:left">Expiry date</text>
                                    <text style="color:grey;float:right;margin-right:200px">CVC/CVV</text></br>
                                    <input type="text" id="ccExpiry" name="ccExpiry" style="font-size:30px;border-radius:5px;width:15%;border:1px solid grey;text-align:center;float:left;" placeholder="mm/yy" maxlength="4" onkeypress="return /[0-9]/i.test(event.key)">  
                                    <input type="text" id="ccDigits" name="ccDigits" style="font-size:30px;border-radius:5px;width:15%;border:1px solid grey;text-align:center;float:right;margin-right:190px" placeholder="xxx" maxlength="3" onkeypress="return /[0-9]/i.test(event.key)"></br></br>
                                </div></br>
                                <img src="../MoshiQ2 IMG Assets/Payment/Pay.png" style="float:left;position:absolute;width:60px;height:auto;margin-left:250px;cursor:pointer">
                                <input class="payEffects" type="button" style="width:95%;height:40px;border-radius:10px;background-color:#437E96;color:white;font-size:20px" value="Pay" onclick="cc_PaymentMethod()"></br></br>
                            </div>
                        </div></br>
                        <div style="width:100%;height:autopx;display:block;border:1px solid black;border-radius:10px;background-color:#BDBDBD26">
                            <div style="width:auto;height:40px;display:block;">
                                <input type="radio" id="cash" name="cash" value="Cash" style="float:left;margin-top:12px" onclick="displayCashDetails()">
                                <text style="height:30px;width:auto;float:left;display:block;margin-top:7px;margin-left:80px;color:grey">Cash</text>
                            </div>
                            <div id="cashPaymentMethod" style="margin-left:20px;margin-top:20px;display:none">
                                <input class="payEffects" type="button" style="width:95%;height:40px;border-radius:10px;background-color:#437E96;color:white;font-size:20px" value="Order now" onclick="cashPaymentMethod()"></br></br>
                            </div>
                        </div>
                    </div>
                    </span>
                </div>
            </div>
        </form>
    </body>
</html>