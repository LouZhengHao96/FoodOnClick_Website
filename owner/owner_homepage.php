<?php
require_once("accountDB.php");
require_once("ordersDB.php");
require_once("reservationDB.php");
?>
<!DOCTYPE html>
<html>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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

        function generateReport(){
            document.getElementById("reportDisplay").style.display = "block";
            document.getElementById("recordsDisplay").style.display = "none";
        }

        function viewRecords(){
            document.getElementById("reportDisplay").style.display = "none";
            document.getElementById("recordsDisplay").style.display = "block";
            viewMyRecords();
        }

        function generateMyReport(){
            $("#displayReportOrderTable tr").remove();
            $("#displayReportReservationTable tr").remove();
            var fromDate = document.getElementById("fromDateReport").value;
            var toDate = document.getElementById("toDateReport").value;
            var laterDate;
            var earlierDate;
            if(parseInt(fromDate.replaceAll("-", "")) > parseInt(toDate.replaceAll("-", ""))){
                laterDate = fromDate;
            }
            else{
                laterDate = toDate;
            }
            if(parseInt(fromDate.replaceAll("-", "")) < parseInt(toDate.replaceAll("-", ""))){
                earlierDate = fromDate;
            }
            else{
                earlierDate = toDate;
            }
            var selectType = document.getElementById("selectReportType").value;
            if(selectType == "Orders"){
                document.getElementById("displayReportOrder").style.display = "block";
                document.getElementById("displayReportReservation").style.display = "none";

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
                var table = document.getElementById("displayReportOrderTable");
                for (x=0; x<totalViewArray.length; x++)
                {
                    if(parseInt(totalViewArray[x][2].replaceAll("-", "")) >= parseInt(earlierDate.replaceAll("-", "")) &&
                    parseInt(totalViewArray[x][2].replaceAll("-", "")) <= parseInt(laterDate.replaceAll("-", "")) &&
                    earlierDate != "" && laterDate != ""){
                        var row = table.insertRow(y);
                        var cell = row.insertCell(0);
                        cell.innerHTML = '<text id="viewReportOrderID' + String(x) + '" style="width:100px;display:block;padding:10px;text-align:center"></text>';
                        document.getElementById("viewReportOrderID"+String(x)).innerHTML = totalViewArray[x][0];  
                        var cell = row.insertCell(1);
                        cell.innerHTML = '<text id="viewReportOrderPrice' + String(x) + '" style="width:100px;display:block;padding:10px;text-align:center"></text>';
                        document.getElementById("viewReportOrderPrice"+String(x)).innerHTML = totalViewArray[x][4];  
                        var cell = row.insertCell(2);
                        cell.innerHTML = '<text id="viewReportOrderStatus' + String(x) + '" style="width:100px;display:block;padding:10px;text-align:center"></text>';
                        document.getElementById("viewReportOrderStatus"+String(x)).innerHTML = totalViewArray[x][5];
                        var cell = row.insertCell(3);
                        cell.innerHTML = '<text id="viewReportOrderPromo' + String(x) + '" style="width:150px;display:block;padding:10px;text-align:center"></text>';
                        document.getElementById("viewReportOrderPromo"+String(x)).innerHTML = totalViewArray[x][6];
                        var cell = row.insertCell(4);
                        cell.innerHTML = '<text id="viewReportOrderTransactionTime' + String(x) + '" style="width:150px;display:block;padding-right:15px;padding-left:15px;text-align:center"></text>';
                        document.getElementById("viewReportOrderTransactionTime"+String(x)).innerHTML = totalViewArray[x][3];  
                        var cell = row.insertCell(5);
                        cell.innerHTML = '<text id="viewReportOrderTransactionDate' + String(x) + '" style="width:150px;display:block;padding:10px;text-align:center"></text>';
                        document.getElementById("viewReportOrderTransactionDate"+String(x)).innerHTML = totalViewArray[x][2];     
                        y++;
                    }
                }
            }
            else{
                document.getElementById("displayReportOrder").style.display = "none";
                document.getElementById("displayReportReservation").style.display = "block";

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
                var table = document.getElementById("displayReportReservationTable");
                for (x=0; x<totalViewArray.length; x++)
                {
                    if(parseInt(totalViewArray[x][6].replaceAll("-", "")) >= parseInt(earlierDate.replaceAll("-", "")) &&
                    parseInt(totalViewArray[x][6].replaceAll("-", "")) <= parseInt(laterDate.replaceAll("-", "")) &&
                    earlierDate != "" && laterDate != ""){
                        var tempTimeSlot;
                        var tempSeats = "";
                        switch(totalViewArray[x][7]){
                            case "timeSlot1":
                                tempTimeSlot = "11:00";
                                break;
                            case "timeSlot2":
                                tempTimeSlot = "12:00";
                                break;
                            case "timeSlot3":
                                tempTimeSlot = "13:00";
                                break;
                            case "timeSlot4":
                                tempTimeSlot = "14:00";
                                break;
                            case "timeSlot5":
                                tempTimeSlot = "15:00";
                                break;
                            case "timeSlot6":
                                tempTimeSlot = "16:00";
                                break;
                            case "timeSlot7":
                                tempTimeSlot = "17:00";
                                break;
                            case "timeSlot8":
                                tempTimeSlot = "18:00";
                                break;
                            case "timeSlot9":
                                tempTimeSlot = "19:00";
                                break;
                            case "timeSlot10":
                                tempTimeSlot = "20:00";
                                break;
                        }

                        for(var z=0; z<totalViewArray[x][9].length; z++){
                            if(z+1 == totalViewArray[x][9].length){
                                tempSeats += totalViewArray[x][9][z];
                            }
                            else{
                                tempSeats += totalViewArray[x][9][z] + ", ";
                            }
                        }

                        var row = table.insertRow(y);
                        var cell = row.insertCell(0);
                        cell.innerHTML = '<text id="viewReportReservationID' + String(x) + '" style="width:40px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewReportReservationID"+String(x)).innerHTML = totalViewArray[x][0];  
                        var cell = row.insertCell(1);
                        cell.innerHTML = '<text id="viewReportReservationEmail' + String(x) + '" style="width:230px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewReportReservationEmail"+String(x)).innerHTML = totalViewArray[x][3];  
                        var cell = row.insertCell(2);
                        cell.innerHTML = '<text id="viewReportReservationNumber' + String(x) + '" style="width:100px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewReportReservationNumber"+String(x)).innerHTML = totalViewArray[x][4];
                        var cell = row.insertCell(3);
                        cell.innerHTML = '<text id="viewReportReservationDate' + String(x) + '" style="width:100px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewReportReservationDate"+String(x)).innerHTML = totalViewArray[x][6];
                        var cell = row.insertCell(4);
                        cell.innerHTML = '<text id="viewReportReservationTime' + String(x) + '" style="width:80px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewReportReservationTime"+String(x)).innerHTML = tempTimeSlot;  
                        var cell = row.insertCell(5);
                        cell.innerHTML = '<text id="viewReportReservationLocation' + String(x) + '" style="width:130px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewReportReservationLocation"+String(x)).innerHTML = totalViewArray[x][5];   
                        var cell = row.insertCell(6);
                        cell.innerHTML = '<text id="viewReportReservationPax' + String(x) + '" style="width:30px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewReportReservationPax"+String(x)).innerHTML = totalViewArray[x][8];   
                        var cell = row.insertCell(7);
                        cell.innerHTML = '<text id="viewReportReservationSeats' + String(x) + '" style="width:90px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewReportReservationSeats"+String(x)).innerHTML = tempSeats;     
                        y++;
                    }
                }
            }
        }

        function viewMyRecords(){
            $("#displayRecordsTable tr").remove();
            var viewArrays = '<?php echo json_encode($accountArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
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
            var table = document.getElementById("displayRecordsTable");
            var checkValue = String(document.getElementById("searchRecords").value.toLowerCase());
            for (x=0; x<totalViewArray.length; x++)
            {
                if(totalViewArray[x][1].toLowerCase() == "customer"){
                    if(String(totalViewArray[x][2]).toLowerCase().includes(checkValue) ||
                    String(totalViewArray[x][5]).toLowerCase().includes(checkValue) ||
                    String(totalViewArray[x][3]).toLowerCase().includes(checkValue) ||
                    String(totalViewArray[x][6]).toLowerCase().includes(checkValue) ||
                    String(totalViewArray[x][7]).toLowerCase().includes(checkValue)){                        
                        var row = table.insertRow(y);
                        var cell = row.insertCell(0);
                        cell.innerHTML = '<text id="viewRecordsProfile' + String(x) + '" style="width:80px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewRecordsProfile"+String(x)).innerHTML = totalViewArray[x][1];  
                        var cell = row.insertCell(1);
                        cell.innerHTML = '<text id="viewRecordsName' + String(x) + '" style="width:130px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewRecordsName"+String(x)).innerHTML = totalViewArray[x][2];  
                        var cell = row.insertCell(2);
                        cell.innerHTML = '<text id="viewRecordsNumber' + String(x) + '" style="width:90px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewRecordsNumber"+String(x)).innerHTML = totalViewArray[x][5];
                        var cell = row.insertCell(3);
                        cell.innerHTML = '<text id="viewRecordsEmail' + String(x) + '" style="width:220px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewRecordsEmail"+String(x)).innerHTML = totalViewArray[x][3];
                        var cell = row.insertCell(4);
                        cell.innerHTML = '<text id="viewRecordsStatus' + String(x) + '" style="width:90px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewRecordsStatus"+String(x)).innerHTML = totalViewArray[x][6];    
                        var cell = row.insertCell(5);
                        cell.innerHTML = '<text id="viewRecordsDescription' + String(x) + '" style="width:220px;display:block;padding:5px;text-align:center"></text>';
                        document.getElementById("viewRecordsDescription"+String(x)).innerHTML = totalViewArray[x][7];    
                        y++;
                    }
                }
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
        <form method="POST">
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
                    <a href="owner_homepage.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="margin-left:0px;width:500px;height:200px;display:inline-block"></a>
                </div></br>

                <div style="float:left;margin-left:30px;display:inline-block">
                    <text style="color:#437E96;font-size:30px">Generate report</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:auto">
                            <input type="button" id="generateReportButton" name="generateReportButton" value="Generate report" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="generateReport();"></br>
                        </div></br></br>
                    </div></br>

                    <text style="color:#437E96;font-size:30px;">View records</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:auto">
                            <input type="button" id="viewRecordsButton" name="viewRecordsButton" value="View records" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="viewRecords()"></br>
                        </div>
                    </div></br>
                </div>

                <div style="float:left;margin-left:200px;">
                    <div id="reportDisplay" style="display:none;width:900px;">
                        <text style="color:#437E96;font-size:40px;">
                            Generate report                        
                        </text></br></br></br>
                        <div>
                            <label style="width:150px;display:inline-block;font-size:30px">Date from: </label><input type="date" id="fromDateReport" style="width:300px;height:30px;display:inline-block;font-size:20px;background-color:#A8A1A166;border:none;border-radius:5px;" placeholder="Enter date"></br></br>
                            <label style="width:150px;display:inline-block;font-size:30px">Date to: </label><input type="date" id="toDateReport" style="width:300px;height:30px;display:inline-block;font-size:20px;background-color:#A8A1A166;border:none;border-radius:5px;" placeholder="Enter date"></br></br>
                            <label style="width:145px;display:inline-block;font-size:30px">Select type: </label>
                                <select id="selectReportType" style="width:305px;height:30px;display:inline-block;font-size:20px;background-color:#A8A1A166;border:none;border-radius:5px;">
                                    <option value="Orders">Orders</option>
                                    <option value="Reservations">Reservations</option>
                                </select></br></br>
                            <input type="button" class="buttonHoverEffect" style="width:455px;height:40px;display:inline-block;font-size:20px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Generate report" onclick="generateMyReport();">
                        </div></br>
                        <div id="displayReportOrder" class="example" style="font-size:20px;height:300px;overflow-y:auto;max-height:600px;display:none">
                            <div style="background-color:#3280F466;">
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;text-align:center;padding:10px;">ID</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;text-align:center;padding:10px;">Price</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;text-align:center;padding:10px;">Status</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:150px;text-align:center;padding:10px;">Promo code</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:140px;text-align:center;padding:10px;">Transaction time</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:150px;text-align:center;padding-left:15px;">Transaction date</text>
                            </div>
                            <table id="displayReportOrderTable" rules="all">
                            </table>
                        </div>
                        <div id="displayReportReservation" class="example" style="font-size:20px;height:300px;overflow-y:auto;max-height:600px;display:none">
                            <div style="background-color:#3280F466;">
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:40px;padding:5px;text-align:center">ID</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:230px;padding:5px;text-align:center">Email</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;padding:5px;text-align:center">Number</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px;padding:5px;text-align:center">Date</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:80px;padding-right:5px;text-align:center">Time</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:130px;padding-right:7px;text-align:center">Location</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:30px;text-align:center">Pax</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:90px;padding-left:10px;text-align:center">Seats</text>
                            </div>
                            <table id="displayReportReservationTable" style="background-color:#A8A1A166;" rules="all">
                            </table>
                        </div>
                    </div>
                </div>

                <div style="float:left;margin-left:200px;">
                    <div id="recordsDisplay" style="display:none;width:900px;">
                        <text style="color:#437E96;font-size:40px;">
                            View records                        
                        </text></br></br></br>
                        <div>
                            <input type="text" id="searchRecords" style="width:300px;height:30px;display:inline-block;font-size:20px;background-color:#A8A1A166;border:none;border-radius:5px;" placeholder="Enter keywords">
                            <input type="button" class="buttonHoverEffect" style="margin-left:20px;width:100px;height:40px;display:inline-block;font-size:20px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="search" onclick="viewMyRecords();">
                        </div></br>
                        <div class="example" style="font-size:20px;height:300px;overflow-y:auto;max-height:600px;">
                            <div style="background-color:#3280F466;">
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:80px;text-align:center;padding:5px">Profile</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:130px;text-align:center;padding:5px">Name</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:90px;text-align:center;padding:5px">Number</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:220px;text-align:center;padding:5px">Email</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:90px;text-align:center;">Status</text>
                                <text style="margin-right:auto;display:inline-block;font-size:20px;width:210px;text-align:center;padding-left:10px">Description</text>
                            </div>
                            <table id="displayRecordsTable" style="background-color:#A8A1A166;" rules="all">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>