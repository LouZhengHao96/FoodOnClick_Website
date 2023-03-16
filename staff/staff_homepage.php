<?php
include("itemDB.php");
include("couponDB.php");
include("reservationDB.php");
include("ordersDB.php");
include("delete_item_data.php");
?>
<!DOCTYPE html>
<html>
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        var isProfileClicked = false;

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
            if(window.location.href.includes('#viewMenuItem')){
                changeTab('viewMenuItem');
                searchItems();
            }
            if(window.location.href.includes('#viewCouponCode')){
                changeTab('viewCouponCode');
                searchPromos();
            }
            if(window.location.href.includes('#viewReservation')){
                changeTab('viewReservation');
                searchReservations();
            }
            if(window.location.href.includes('#viewOrder')){
                changeTab('viewOrder');
                searchOrder();
            }
            if(window.location.href.includes('ilili')){
                alert("There was an error, please try again");
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

        function changeTab(id){
            var collection = document.getElementsByClassName("sideBar");
            for(var x=0; x < collection.length; x++){
                if(collection[x].id == id+"DIV"){
                    document.getElementById(collection[x].id).style.display="block";
                }
                else{
                    document.getElementById(collection[x].id).style.display="none";
                }
            }
        }

        function searchItems(){
            $("#displayViewTable tr").remove(); 
            var viewArrays = '<?php echo json_encode($viewArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var viewarray = viewArrays.split('].');
            var viewArray1 = [];
            var totalViewArray = [];
            var x;
            var y;
            var tempString = "";
            for (x=0;x<viewarray.length;x++)
            {
                viewArray1.push(viewarray[x]);
            }
            for (x=0;x<viewArray1.length;x++){
                tempString = String(viewArray1[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                totalViewArray.push(tempString);
            }
            var table = document.getElementById("displayViewTable");
            var y = 0;
            for (x=0; x<totalViewArray.length; x++)
            {
                if(totalViewArray[x][0].toLowerCase().includes(document.getElementById("viewSearchItem").value.toLowerCase()) ||
                    totalViewArray[x][2].toLowerCase().includes(document.getElementById("viewSearchItem").value.toLowerCase()) ||
                    totalViewArray[x][3].toLowerCase().includes(document.getElementById("viewSearchItem").value.toLowerCase()) ||
                    String(totalViewArray[x][6]).toLowerCase().includes(document.getElementById("viewSearchItem").value.toLowerCase())){
                    var row = table.insertRow(y);
                    var cell = row.insertCell(0);
                    cell.innerHTML = '<text id="viewListingID' + String(x) + '" style="width:30px;display:block;padding:5px"></text>';
                    document.getElementById("viewListingID"+String(x)).innerHTML = totalViewArray[x][0];  
                    var cell = row.insertCell(1);
                    cell.innerHTML = '<text id="viewListingName' + String(x) + '" style="width:200px;display:block;padding:5px"></text>';
                    document.getElementById("viewListingName"+String(x)).innerHTML = totalViewArray[x][2];
                    var cell = row.insertCell(2);
                    cell.innerHTML = '<text id="viewListingDescription' + String(x) + '" style="width:320px;display:block;padding:5px"></text>';
                    document.getElementById("viewListingDescription"+String(x)).innerHTML = totalViewArray[x][3];    
                    var cell = row.insertCell(3);
                    cell.innerHTML = '<text id="viewListingStock' + String(x) + '" style="width:100px;display:block;padding:5px"></text>';
                    document.getElementById("viewListingStock"+String(x)).innerHTML = totalViewArray[x][6];  
                    y++
                }      
            }   
        }

        function searchCurrentItems(){
            var viewArrays = '<?php echo json_encode($viewArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var viewarray = viewArrays.split('].');
            var viewArray1 = [];
            var totalViewArray = [];
            var x;
            var y;
            var tempString = "";
            for (x=0;x<viewarray.length;x++)
            {
                viewArray1.push(viewarray[x]);
            }
            for (x=0;x<viewArray1.length;x++){
                tempString = String(viewArray1[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                totalViewArray.push(tempString);
            }
            var table = document.getElementById("displayViewTable");
            var y = 0;
            for (x=0; x<totalViewArray.length; x++)
            {
                if(String(totalViewArray[x][0]) == document.getElementById("updateSearchItem").value){
                    document.getElementById("displayUpdate").style.display = "block";
                    document.getElementById("updateItemName").value = totalViewArray[x][2];
                    document.getElementById("updateItemCategory").value = totalViewArray[x][1];
                    document.getElementById("updateItemPrice").value = totalViewArray[x][5];
                    document.getElementById("updateItemDescription").value = totalViewArray[x][3];
                    document.getElementById("previousImage").value = totalViewArray[x][4];
                    document.getElementById("updateItemStock").value = totalViewArray[x][6];
                    break;
                }
                else{
                    document.getElementById("displayUpdate").style.display = "none";
                }
            }
        }

        function searchPromos(){
            $("#displayCouponViewTable tr").remove(); 
            var viewArrays = '<?php echo json_encode($promoArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var viewarray = viewArrays.split('].');
            var viewArray1 = [];
            var totalViewArray = [];
            var x;
            var y;
            var tempString = "";
            for (x=0;x<viewarray.length;x++)
            {
                viewArray1.push(viewarray[x]);
            }
            for (x=0;x<viewArray1.length;x++){
                tempString = String(viewArray1[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                totalViewArray.push(tempString);
            }
            var table = document.getElementById("displayCouponViewTable");
            var y = 0;
            for (x=0; x<totalViewArray.length; x++)
            {
                if(totalViewArray[x][0].toLowerCase().includes(document.getElementById("viewSearchPromo").value.toLowerCase()) ||
                    totalViewArray[x][1].toLowerCase().includes(document.getElementById("viewSearchPromo").value.toLowerCase()) ||
                    totalViewArray[x][6].toLowerCase().includes(document.getElementById("viewSearchPromo").value.toLowerCase()) ||
                    String(totalViewArray[x][2]).toLowerCase().includes(document.getElementById("viewSearchPromo").value.toLowerCase())){
                    var row = table.insertRow(y);
                    var cell = row.insertCell(0);
                    cell.innerHTML = '<text id="viewPromoID' + String(x) + '" style="width:30px;display:block;padding:5px"></text>';
                    document.getElementById("viewPromoID"+String(x)).innerHTML = totalViewArray[x][0];  
                    var cell = row.insertCell(1);
                    cell.innerHTML = '<text id="viewPromoName' + String(x) + '" style="width:200px;display:block;padding:5px"></text>';
                    document.getElementById("viewPromoName"+String(x)).innerHTML = totalViewArray[x][1];
                    var cell = row.insertCell(2);
                    cell.innerHTML = '<text id="viewPromoDescription' + String(x) + '" style="width:400px;display:block;padding:5px"></text>';
                    document.getElementById("viewPromoDescription"+String(x)).innerHTML = totalViewArray[x][6];    
                    var cell = row.insertCell(3);
                    cell.innerHTML = '<text id="viewPromoRate' + String(x) + '" style="width:150px;display:block;padding:5px"></text>';
                    document.getElementById("viewPromoRate"+String(x)).innerHTML = totalViewArray[x][2];  
                    y++
                }      
            }   
        }

        function searchCurrentPromos(){
            var viewArrays = '<?php echo json_encode($promoArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var viewarray = viewArrays.split('].');
            var viewArray1 = [];
            var totalViewArray = [];
            var x;
            var y;
            var tempString = "";
            for (x=0;x<viewarray.length;x++)
            {
                viewArray1.push(viewarray[x]);
            }
            for (x=0;x<viewArray1.length;x++){
                tempString = String(viewArray1[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                totalViewArray.push(tempString);
            }           
            for (x=0; x<totalViewArray.length; x++)
            {
                if(String(totalViewArray[x][0]) == document.getElementById("updateSearchCoupon").value){
                    document.getElementById("displayUpdateCoupon").style.display = "block";
                    document.getElementById("updateCouponName").value = totalViewArray[x][1];
                    document.getElementById("updateCouponDiscount").value = totalViewArray[x][2];
                    document.getElementById("updateCouponValidFrom").value = totalViewArray[x][4];
                    document.getElementById("updateCouponValidTo").value = totalViewArray[x][5];
                    document.getElementById("updateCouponDescription").value = totalViewArray[x][6];
                    document.getElementById("previousCouponImage").value = totalViewArray[x][3];
                    break;
                }
                else{
                    document.getElementById("displayUpdate").style.display = "none";
                }
            }
        }

        function searchReservations(){
            $("#displayReservationsTable tr").remove();
            var viewArrays = '<?php echo json_encode($reservationsArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var viewarray = viewArrays.split('].');
            var viewArray1 = [];
            var totalViewArray = [];
            var x;
            var y=0;
            var tempString = "";
            for (x=0;x<viewarray.length;x++)
            {
                viewArray1.push(viewarray[x]);
            }
            for (x=0;x<viewArray1.length;x++){
                tempString = String(viewArray1[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                totalViewArray.push(tempString);
            }
            var table = document.getElementById("displayReservationsTable");
            var y = 0; 
            for (x=0; x<totalViewArray.length; x++)
            {
                if(totalViewArray[x][0].toLowerCase().includes(document.getElementById("viewSearchReservation").value.toLowerCase()) ||
                    totalViewArray[x][3].toLowerCase().includes(document.getElementById("viewSearchReservation").value.toLowerCase()) ||
                    totalViewArray[x][9].toLowerCase().includes(document.getElementById("viewSearchReservation").value.toLowerCase()) ||
                    totalViewArray[x][4].toLowerCase().includes(document.getElementById("viewSearchReservation").value.toLowerCase()) ||
                    totalViewArray[x][5].toLowerCase().includes(document.getElementById("viewSearchReservation").value.toLowerCase()) ||
                    totalViewArray[x][6].toLowerCase().includes(document.getElementById("viewSearchReservation").value.toLowerCase()) ||
                    String(totalViewArray[x][8]).toLowerCase().includes(document.getElementById("viewSearchReservation").value.toLowerCase())){
                    var totalSeats = "";
                    for(var z=0; z<totalViewArray[x][9].length; z++){
                        if(z+1 == totalViewArray[x][9].length){
                            totalSeats += totalViewArray[x][9][z];
                        }
                        else{
                            totalSeats += totalViewArray[x][9][z] + ", ";
                        }
                    }
                    var row = table.insertRow(y);
                    var cell = row.insertCell(0);
                    cell.innerHTML = '<text id="viewReservationID' + String(x) + '" style="width:30px;display:block;padding:5px"></text>';
                    document.getElementById("viewReservationID"+String(x)).innerHTML = totalViewArray[x][0];  
                    var cell = row.insertCell(1);
                    cell.innerHTML = '<text id="viewReservationEmail' + String(x) + '" style="width:250px;display:block;padding:5px"></text>';
                    document.getElementById("viewReservationEmail"+String(x)).innerHTML = totalViewArray[x][3];
                    var cell = row.insertCell(2);
                    cell.innerHTML = '<text id="viewReservationNumber' + String(x) + '" style="width:90px;display:block;padding:5px"></text>';
                    document.getElementById("viewReservationNumber"+String(x)).innerHTML = totalViewArray[x][4];
                    var cell = row.insertCell(3);
                    cell.innerHTML = '<text id="viewReservationSeating' + String(x) + '" style="width:70px;display:block;padding:5px"></text>';
                    document.getElementById("viewReservationSeating"+String(x)).innerHTML = totalSeats;    
                    var cell = row.insertCell(4);
                    cell.innerHTML = '<text id="viewReservationPax' + String(x) + '" style="width:30px;display:block;padding:5px"></text>';
                    document.getElementById("viewReservationPax"+String(x)).innerHTML = totalViewArray[x][8];  
                    var cell = row.insertCell(5);
                    cell.innerHTML = '<text id="viewReservationLocation' + String(x) + '" style="width:100px;display:block;padding:5px"></text>';
                    document.getElementById("viewReservationLocation"+String(x)).innerHTML = totalViewArray[x][5];    
                    var cell = row.insertCell(6);
                    cell.innerHTML = '<text id="viewReservationDate' + String(x) + '" style="width:140px;display:block;padding:5px"></text>';
                    document.getElementById("viewReservationDate"+String(x)).innerHTML = totalViewArray[x][6];
                        
                    y++
                }      
            }   
        }

        function searchOrder(){
            $("#displayOrderTable tr").remove();
            var viewArrays = '<?php echo json_encode($ordersArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var viewarray = viewArrays.split('].');
            var viewArray1 = [];
            var totalViewArray = [];
            var x;
            var y=0;
            var tempString = "";
            for (x=0;x<viewarray.length;x++)
            {
                viewArray1.push(viewarray[x]);
            }
            for (x=0;x<viewArray1.length;x++){
                tempString = String(viewArray1[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                totalViewArray.push(tempString);
            }
            var table = document.getElementById("displayOrderTable");
            var y = 0;
            for (x=0; x<totalViewArray.length; x++)
            {
                if(String(totalViewArray[x][0]).toLowerCase().includes(document.getElementById("viewSearchOrder").value.toLowerCase()) ||
                    String(totalViewArray[x][2]).toLowerCase().includes(document.getElementById("viewSearchOrder").value.toLowerCase()) ||
                    String(totalViewArray[x][3]).toLowerCase().includes(document.getElementById("viewSearchOrder").value.toLowerCase()) ||
                    String(totalViewArray[x][4]).toLowerCase().includes(document.getElementById("viewSearchOrder").value.toLowerCase()) ||
                    String(totalViewArray[x][5]).toLowerCase().includes(document.getElementById("viewSearchOrder").value.toLowerCase()) ||
                    totalViewArray[x][6].toLowerCase().includes(document.getElementById("viewSearchOrder").value.toLowerCase())){
                    var row = table.insertRow(y);
                    var cell = row.insertCell(0);
                    cell.innerHTML = '<text id="viewOrderID' + String(x) + '" style="width:30px;display:block;padding:5px"></text>';
                    document.getElementById("viewOrderID"+String(x)).innerHTML = totalViewArray[x][0];
                    var cell = row.insertCell(1);
                    cell.innerHTML = '<text id="viewOrderItems' + String(x) + '" style="width:150px;display:block;padding:5px"></text>';
                    document.getElementById("viewOrderItems"+String(x)).innerHTML = totalViewArray[x][10].replaceAll("~~", "</br>");     
                    var cell = row.insertCell(2);
                    cell.innerHTML = '<text id="viewOrderDate' + String(x) + '" style="width:100px;display:block;padding:5px"></text>';
                    document.getElementById("viewOrderDate"+String(x)).innerHTML = totalViewArray[x][2];
                    var cell = row.insertCell(3);
                    cell.innerHTML = '<text id="viewOrderTime' + String(x) + '" style="width:50px;display:block;padding:5px"></text>';
                    document.getElementById("viewOrderTime"+String(x)).innerHTML = totalViewArray[x][3];
                    var cell = row.insertCell(4);
                    cell.innerHTML = '<text id="viewOrderPrice' + String(x) + '" style="width:70px;display:block;padding:5px"></text>';
                    document.getElementById("viewOrderPrice"+String(x)).innerHTML = totalViewArray[x][4];    
                    var cell = row.insertCell(5);
                    cell.innerHTML = '<text id="viewOrderCoupon' + String(x) + '" style="width:120px;display:block;padding:5px"></text>';
                    document.getElementById("viewOrderCoupon"+String(x)).innerHTML = totalViewArray[x][6];    
                    var cell = row.insertCell(6);
                    cell.innerHTML = '<text id="viewOrderStatus' + String(x) + '" style="width:100px;display:block;padding:5px"></text>';
                    document.getElementById("viewOrderStatus"+String(x)).innerHTML = totalViewArray[x][5];    
                     
                    y++
                }      
            }   
        }

        function searchUpdateOrder(){
            $("#displayOrderUpdateTable tr").remove();
            var viewArrays = '<?php echo json_encode($ordersArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var viewarray = viewArrays.split('].');
            var viewArray1 = [];
            var totalViewArray = [];
            var x;
            var y=0;
            var tempString = "";
            for (x=0;x<viewarray.length;x++)
            {
                viewArray1.push(viewarray[x]);
            }
            for (x=0;x<viewArray1.length;x++){
                tempString = String(viewArray1[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                totalViewArray.push(tempString);
            }
            var table = document.getElementById("displayOrderUpdateTable");
            for (x=0; x<totalViewArray.length; x++)
            {
                var row = table.insertRow(x);
                var cell = row.insertCell(0);
                cell.innerHTML = '<text id="updateOrderID' + String(x) + '" style="width:30px;display:block;padding:5px"></text>';
                document.getElementById("updateOrderID"+String(x)).innerHTML = totalViewArray[x][0];  
                var cell = row.insertCell(1);
                cell.innerHTML = '<text id="updateOrderDate' + String(x) + '" style="width:100px;display:block;padding:5px"></text>';
                document.getElementById("updateOrderDate"+String(x)).innerHTML = totalViewArray[x][2];
                var cell = row.insertCell(2);
                cell.innerHTML = '<text id="updateOrderTime' + String(x) + '" style="width:50px;display:block;padding:5px"></text>';
                document.getElementById("updateOrderTime"+String(x)).innerHTML = totalViewArray[x][3];
                var cell = row.insertCell(3);
                cell.innerHTML = '<text id="updateOrderPrice' + String(x) + '" style="width:70px;display:block;padding:5px"></text>';
                document.getElementById("updateOrderPrice"+String(x)).innerHTML = totalViewArray[x][4];    
                var cell = row.insertCell(4);
                cell.innerHTML = '<text id="updateOrderCoupon' + String(x) + '" style="width:133px;display:block;padding:5px"></text>';
                document.getElementById("updateOrderCoupon"+String(x)).innerHTML = totalViewArray[x][6];    
                var cell = row.insertCell(5);
                cell.innerHTML = '<text id="updateOrderStatus' + String(x) + '" style="width:120px;display:block;padding:5px"></text>';
                document.getElementById("updateOrderStatus"+String(x)).innerHTML = totalViewArray[x][5];    
            }   
        }
    </script>
    <style>
        .mouseOverEffects{
            border-left : 3px solid transparent;
            cursor: pointer;
        }

        .mouseOverEffects:hover{
            border-left : 3px solid #437E96;
            cursor: pointer;
        }

        .buttonEffects {
            border-radius: 10px;
            background-color: #437E96;
            border: none;
            color: white;
            width: 200px;
            height: auto;
            font-size: 20px;
            text-align: center;
            padding: 5px;
            display: inline-block;
        }
        .buttonEffects:hover {
            border: 2px solid black;
            cursor:pointer;
        }

        .arrow {
            border: solid black;
            border-width: 0 1px 1px 0;
            display: inline-block;
            padding: 3px;
        }

        .example::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .example {
            -ms-overflow-style: none;  /* IE and Edge */
        }

        .buttonHoverEffect {
            border: none;
            cursor:pointer;
        }
        .buttonHoverEffect:hover {
            border: 2px solid black;
            cursor:pointer;
        }
    </style>
    <body onload="profileDetails()" style="background-color:#FEF2E5">
            <div style="width:1400px;margin-left:auto;margin-right:auto">
                <div style="float:right">
                    <img src="../MoshiQ2 IMG Assets/Profile Icon.png" style="display:block;margin-left:auto;width:70px;height:auto;cursor:pointer;" onclick="profileClicked()"></br>
                    <div id="displayProfile" name="displayProfile" style="float:right;margin-top:10px;padding:5px;z-index:1;position:relative;width:auto;height:auto;background-color:white;;border:1px solid black;border-radius:5px;display:none">
                        <text style="margin-left:10%;margin-right:auto;display:inline-block" id="accountNameDetails"></text></br>
                        <input type="button" id="accountDrop" name="accountDrop" value="Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&#x25B2;" style="color:gray;margin-top:5px;height:30px;width:200px;" onclick="clickedDrop()">
                        <input type="button" id="accountCollapse" name="accountCollapse" value="Account &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&#x25BC;" style="color:gray;margin-top:5px;width:200px;height:30px;" onclick="clickedCollapse()" hidden>
                        <input type="button" id="accountSignOut" name="accountSignOut" value="Sign out &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;" style="margin-top:5px;width:200px;height:30px;" onclick="signOut()" hidden>
                    </div></br>
                </div>

                <div>
                    <a href="staff_homepage.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="margin-left:0px;width:500px;height:200px;display:inline-block"></a>
                </div></br>

                <div style="float:left;margin-left:30px;display:inline-block">
                    <text style="color:#437E96;font-size:30px;">Item</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="createMenuItem" name="createMenuItem" value="Create menu item" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id)"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="viewMenuItem" name="viewMenuItem" value="View menu item list" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id);searchItems()"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="deleteMenuItem" name="deleteMenuItem" value="Delete menu item" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id)"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="updateMenuItem" name="updateMenuItem" value="Update menu item" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id)"></br>
                        </div></br></br>
                    </div></br>

                    <text style="color:#437E96;font-size:30px;">Coupon</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="createCouponCode" name="createCouponCode" value="Create coupon code" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id)"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="viewCouponCode" name="viewCouponCode" value="View coupon code list" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id);searchPromos()"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="deleteCouponCode" name="deleteCouponCode" value="Delete coupon code" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id)"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="updateCouponCode" name="updateCouponCode" value="Update coupon code" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id)"></br>
                        </div></br></br>
                    </div></br>

                    <text style="color:#437E96;font-size:30px;">Reservation</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="viewReservation" name="viewReservation" value="View reservation list" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id);searchReservations()"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="deleteReservation" name="deleteReservation" value="Delete reservation" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id)"></br>
                        </div></br></br>
                    </div></br>

                    <text style="color:#437E96;font-size:30px;">Order</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="viewOrder" name="viewOrder" value="View order list" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id);searchOrder()"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="deleteOrder" name="deleteOrder" value="Delete order" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id)"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:150px">
                            <input type="button" id="updateOrder" name="updateOrder" value="Update order status" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="changeTab(this.id);searchUpdateOrder()"></br>
                        </div></br></br>
                    </div></br>
                </div>

                <div id="menuTab">
                    <div style="float:left;margin-left:200px;">
                    <form method="POST" action="create_item_data.php" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to create item?');">
                        <div class="sideBar" id="createMenuItemDIV" style="display:none;width:auto">
                            <text style="color:#437E96;font-size:40px;">
                                Create menu item                               
                            </text></br></br></br>
                            <label style="width:150px;display:inline-block">Name: </label><input type="text" id="createItemName" name="createItemName" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;" placeholder="POMELLO PUNCH"></br></br>
                            <label style="width:150px;display:inline-block">Category: </label>
                            <select id="createItemCategory" name="createItemCategory" style="margin-top:5px;margin-left:25px;width:405px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer">
                                <option value="signature">Signature</option>
                                <option value="diy">DIY</option>
                                <option value="acai">Acai</option>
                                <option value="beverages">Beverages</option>
                            </select></br></br>
                            <label style="width:150px;display:inline-block">Price: </label><input type="text" id="createItemPrice" name="createItemPrice" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="15.50"></br></br>
                            <label style="width:150px;display:inline-block">Description: </label><input type="text" id="createItemDescription" name="createItemDescription" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Savoury goodness"></br></br>
                            <label style="width:150px;display:inline-block">Picture link: </label>
                                <input type="file" id="my_image" name="my_image" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                            <label style="width:150px;display:inline-block">Stock: </label><input type="text" id="createItemStock" name="createItemStock" style="margin-top:5px;margin-left:30px;width:405px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                            <input type="submit" class="buttonHoverEffect" name="createSubmit" style="display:inline-block;width:585px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Create item">
                        </div>
                    </form>
                    </div>   
                    
                    <div style="float:left;margin-left:200px;">
                        <form method="POST">
                        <div class="sideBar" id="viewMenuItemDIV" style="display:none;width:700px;">
                            <text style="color:#437E96;font-size:40px;">
                                View menu item                               
                            </text></br></br></br>
                            <input type="text" id="viewSearchItem" name="viewSearchItem" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter keywords">
                            <input type="button" name="search" class="buttonHoverEffect" value="Search" onclick="searchItems()" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                            <div style="background-color:#3280F466;">
                                <text style="display:inline-block;font-size:20px;width:30px;padding:5px;text-align:center">ID</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:200px;padding:5px;text-align:center">Name</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:320px;padding:5px;text-align:center">Description</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:70px;padding:5px;text-align:center">Stock</text>
                            </div>
                            <div id="displayView" class="example" style="font-size:20px;height:300px;overflow-y:auto;max-height:600px;display:block">
                                <table id="displayViewTable" style="background-color:#A8A1A166;" rules="all">
                                </table>
                            </div>
                        </div>
                        </form>
                    </div>  
                    
                    <div style="float:left;margin-left:200px;">
                        <form method="POST" action="delete_item_data.php" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to delete item?');">
                        <div class="sideBar" id="deleteMenuItemDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                Delete menu item                               
                            </text></br></br></br>
                            <input type="number" id="deleteSearchItem" name="deleteSearchItem" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter ID">
                            <input type="submit" name="deleteItem" class="buttonHoverEffect" value="Delete" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                        </div>
                        </form>
                    </div>    

                    <div style="float:left;margin-left:200px;">
                        <form method="POST" action="update_item_data.php" enctype="multipart/form-data">
                        <div class="sideBar" id="updateMenuItemDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                Update menu item                               
                            </text></br></br></br>
                            <input type="number" id="updateSearchItem" name="updateSearchItem" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter ID">
                            <input type="button" class="buttonHoverEffect" value="Search" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" onclick="searchCurrentItems()"></br></br>
                            <div id="displayUpdate" style="display:none">
                                <label style="width:150px;display:inline-block">Name: </label><input type="text" id="updateItemName" name="updateItemName" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;"></br></br>
                                <label style="width:150px;display:inline-block">Category: </label>
                                <select id="updateItemCategory" name="updateItemCategory" style="margin-top:5px;margin-left:25px;width:405px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer">
                                    <option value="signature">Signature</option>
                                    <option value="diy">DIY</option>
                                    <option value="acai">Acai</option>
                                    <option value="beverages">Beverages</option>
                                </select></br></br>
                                <label style="width:150px;display:inline-block">Price: </label><input type="text" id="updateItemPrice" name="updateItemPrice" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                                <label style="width:150px;display:inline-block">Description: </label><input type="text" id="updateItemDescription" name="updateItemDescription" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                                <label style="width:150px;display:inline-block">Previous link: </label>
                                    <input type="text" id="previousImage" name="previousImage" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" disabled></br></br>
                                <label style="width:150px;display:inline-block">Picture link: </label>
                                    <input type="file" id="updateItemMyImage" name="updateItemMyImage" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                                <text style="display:inline-block;font-size:20px;color:red;margin-left:100px">Leave picture link empty if change is not needed</text></br></br>
                                <label style="width:150px;display:inline-block">Stock: </label><input type="text" id="updateItemStock" name="updateItemStock" style="margin-top:5px;margin-left:30px;width:405px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                                <input type="submit" name="updateSubmit" class="buttonHoverEffect" style="display:inline-block;width:585px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Update item">
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                
                <div id="couponTab">
                    <div style="float:left;margin-left:200px;">
                    <form method="POST" action="create_coupon_data.php" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to create coupon?');">
                        <div class="sideBar" id="createCouponCodeDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                Create coupon code                               
                            </text></br></br></br>
                            <label style="width:150px;display:inline-block">Coupon name: </label><input type="text" id="createCouponName" name="createCouponName" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="Leave empty if Dine-in exclusive"></br></br>
                            <label style="width:150px;display:inline-block">Discount rate: </label><input type="text" id="createCouponDiscount" name="createCouponDiscount" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="25"></br></br>
                            <label style="width:150px;display:inline-block">Valid from: </label><input type="date" id="createCouponValidFrom" name="createCouponValidFrom" style="margin-top:5px;margin-left:30px;width:auto;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="Click to select date"></br></br>
                            <label style="width:150px;display:inline-block">Valid to: </label><input type="date" id="createCouponValidTo" name="createCouponValidTo" style="margin-top:5px;margin-left:30px;width:auto;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="Click to select date"></br></br>
                            <label style="width:150px;display:inline-block">Coupon description: </label><input type="text" id="createCouponDescription" name="createCouponDescription" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="on all orders - Dine-in Exclusive"></br></br>
                            <label style="width:150px;display:inline-block">Picture link: </label>
                                <input type="file" id="coupon_image" name="coupon_image" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                            <input type="submit" name="createCouponSubmit" class="buttonHoverEffect" style="display:inline-block;width:585px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Create coupon">
                        </div>
                    </form>
                    </div>   
                    
                    <div style="float:left;margin-left:200px;">
                        <div class="sideBar" id="viewCouponCodeDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                View coupon code                              
                            </text></br></br></br>
                            <input type="text" id="viewSearchPromo" name="viewSearchPromo" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter keywords">
                            <input type="button" name="searchPromo" class="buttonHoverEffect" value="Search" onclick="searchPromos()" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                            <div style="background-color:#3280F466;">
                                <text style="display:inline-block;font-size:20px;width:30px;padding:5px;text-align:center">ID</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:200px;padding:5px;text-align:center">Name</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:400px;padding:5px;text-align:center">Description</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:70px;padding:5px;text-align:center">Rate</text>
                            </div>
                            <div id="displayCouponView" class="example" style="font-size:20px;height:600px;overflow-y:auto;max-height:900px;display:block">
                                <table id="displayCouponViewTable" style="background-color:#A8A1A166;" rules="all">
                                </table>
                            </div>
                        </div>
                    </div>  
                    
                    <div style="float:left;margin-left:200px;">
                    <form method="POST" action="delete_coupon_data.php" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to delete coupon?');">
                        <div class="sideBar" id="deleteCouponCodeDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                Delete coupon code                              
                            </text></br></br></br>
                            <input type="number" id="deleteSearchCoupon" name="deleteSearchCoupon" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter ID">
                            <input type="submit" name="deleteCoupon" class="buttonHoverEffect" value="Delete" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                        </div>
                    </form>
                    </div>    

                    <div style="float:left;margin-left:200px;">
                        <form method="POST" action="update_coupon_data.php" enctype="multipart/form-data">
                        <div class="sideBar" id="updateCouponCodeDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                Update coupon code                            
                            </text></br></br></br>
                            <input type="number" id="updateSearchCoupon" name="updateSearchCoupon" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter ID">
                            <input type="button" class="buttonHoverEffect" value="Search" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" onclick="searchCurrentPromos()"></br></br>
                            <div id="displayUpdateCoupon" style="display:none">
                                <label style="width:150px;display:inline-block">Coupon name: </label><input type="text" id="updateCouponName" name="updateCouponName" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="Leave empty if Dine-in exclusive"></br></br>
                                <label style="width:150px;display:inline-block">Discount rate: </label><input type="text" id="updateCouponDiscount" name="updateCouponDiscount" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="25"></br></br>
                                <label style="width:150px;display:inline-block">Valid from: </label><input type="date" id="updateCouponValidFrom" name="updateCouponValidFrom" style="margin-top:5px;margin-left:30px;width:auto;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="Click to select date"></br></br>
                                <label style="width:150px;display:inline-block">Valid to: </label><input type="date" id="updateCouponValidTo" name="updateCouponValidTo" style="margin-top:5px;margin-left:30px;width:auto;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="Click to select date"></br></br>
                                <label style="width:150px;display:inline-block">Coupon description: </label><input type="text" id="updateCouponDescription" name="updateCouponDescription" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" placeholder="on all orders - Dine-in Exclusive"></br></br>
                                <label style="width:150px;display:inline-block">Previous link: </label>
                                    <input type="text" id="previousCouponImage" name="previousCouponImage" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" disabled></br></br>
                                <label style="width:150px;display:inline-block">Picture link: </label>
                                    <input type="file" id="udpate_coupon_image" name="update_coupon_image" style="margin-top:5px;margin-left:30px;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                                <text style="display:inline-block;font-size:20px;color:red;margin-left:100px">Leave picture link empty if change is not needed</text></br></br>
                                <input type="submit" name="updateCouponSubmit" class="buttonHoverEffect" style="display:inline-block;width:585px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Update coupon">
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <div id="reservationTab">                    
                    <div style="float:left;margin-left:200px;">
                        <div class="sideBar" id="viewReservationDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                View reservation                              
                            </text></br></br></br>
                            <input type="text" id="viewSearchReservation" name="viewSearchReservation" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter keywords">
                            <input type="button" name="search" class="buttonHoverEffect" value="Search" onclick="searchReservations()" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                            <div style="background-color:#3280F466;">
                                <text style="display:inline-block;font-size:20px;width:30px;padding:2px;text-align:center">ID</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:250px;padding:2px;text-align:center">Email</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:90px;padding:2px;text-align:center">Number</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:93px;padding:2px;text-align:center">Seating</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:30px;padding:2px;text-align:center">Pax</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;padding:2px;text-align:center">Location</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:150px;padding:2px;text-align:center">Date</text>
                            </div>
                            <div id="displayReservations" class="example" style="font-size:20px;height:600px;overflow-y:auto;max-height:900px;display:block">
                                <table id="displayReservationsTable" style="background-color:#A8A1A166;" rules="all">
                                </table>
                            </div>
                        </div>
                    </div>  
                    
                    <div style="float:left;margin-left:200px;">
                    <form method="POST" action="delete_reservation_data.php" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to delete reservation?');">
                        <div class="sideBar" id="deleteReservationDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                Delete reservation                              
                            </text></br></br></br>
                            <input type="number" id="deleteSearchReservation" name="deleteSearchReservation" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter ID">
                            <input type="submit" name="deleteReservation" class="buttonHoverEffect" value="Delete" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                        </div>
                    </form>
                    </div>    
                </div>

                <div id="orderTab">                    
                    <div style="float:left;margin-left:200px;">
                        <div class="sideBar" id="viewOrderDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                View order                             
                            </text></br></br></br>
                            <input type="text" id="viewSearchOrder" name="viewSearchOrder" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter keywords">
                            <input type="button" name="search" class="buttonHoverEffect" value="Search" onclick="searchOrder()" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                            <div style="background-color:#3280F466;width:710px">
                                <text style="display:inline-block;font-size:20px;width:30px;padding:5px;text-align:center">ID</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;padding-left:30px;text-align:center">Items</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;padding-left:30px;text-align:center">Date</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:50px;padding:10px;text-align:center">Time</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:70px;text-align:center">Price</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:120px;padding:5px;text-align:center">Promo Code</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:80px;text-align:center">Status</text>
                            </div>
                            <div id="displayOrder" class="example" style="font-size:20px;height:600px;overflow-y:auto;max-height:900px;display:block">
                                <table id="displayOrderTable" style="background-color:#A8A1A166;" rules="all">
                                </table>
                            </div>
                        </div>
                    </div>  
                    
                    <div style="float:left;margin-left:200px;">
                    <form method="POST" action="delete_order_data.php" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to delete order?');">
                        <div class="sideBar" id="deleteOrderDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                Delete order                             
                            </text></br></br></br>
                            <input type="number" id="deleteSearchOrder" name="deleteSearchOrder" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter ID">
                            <input type="submit" name="deleteOrder" class="buttonHoverEffect" value="Delete" style="margin-left:20px;width:150px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                        </div>
                    </form>
                    </div>    
                    
                    <div style="float:left;margin-left:200px;">
                    <form method="POST" action="update_order_status_data.php" enctype="multipart/form-data">
                        <div class="sideBar" id="updateOrderDIV" style="display:none;width:800px;">
                            <text style="color:#437E96;font-size:40px;">
                                Update order status                         
                            </text></br></br></br>
                            <input type="number" id="updateSearchOrder" name="updateSearchOrder" style="display:inline-block;width:400px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px" placeholder="Enter ID"></br></br>
                            <select id="updateOrderStatus" name="updateOrderStatus" style="margin-top:5px;width:405px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:30px;cursor:pointer">
                                <option value="Delivered">Delivered</option>
                                <option value="In-progress">In-progress</option>
                            </select></br></br>
                            <input type="submit" name="updateOrder" class="buttonHoverEffect" value="Update" style="width:405px;height:40px;display:inline-block;font-size:30px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px"></br></br>
                            <div style="background-color:#3280F466;width:580px">
                                <text style="display:inline-block;font-size:20px;width:30px;padding:5px;text-align:center">ID</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;padding:5px;text-align:center">Date</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:50px;padding:5px;text-align:center">Time</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:70px;padding:5px;text-align:center">Price</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:130px;padding:5px;text-align:center">Promo Code</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:120px;padding:5px;text-align:center">Status</text>
                            </div>
                            <div id="displayOrderUpdate" class="example" style="font-size:20px;height:600px;overflow-y:auto;max-height:900px;display:block">
                                <table id="displayOrderUpdateTable" style="background-color:#A8A1A166;" rules="all">
                                </table>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
    </body>
</html>