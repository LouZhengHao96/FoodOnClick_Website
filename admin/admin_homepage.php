<?php
require_once("reservationInboxDB.php");
require_once("deliveryInboxDB.php");
require_once("accountDB.php");
?>
<!DOCTYPE html>
<html>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js">
    </script>
    <script type="text/javascript">
    (function(){
        emailjs.init("78fm3oeYmqkwn06vd");
    })();
  </script>
    <script>
        var isProfileClicked = false;
        
        function emailFunction(){
            document.getElementById("emailDisplay").style.display = 'block';
            document.getElementById("createUserAccountDisplay").style.display = 'none';
            document.getElementById("viewUserAccountDisplay").style.display = 'none';
            document.getElementById("suspendUserAccountDisplay").style.display = 'none';
            document.getElementById("updateUserAccountDisplay").style.display = 'none';
            document.getElementById("calendarInviteDisplay").style.display="none";
        }

        function createUserAccountFunction(){
            document.getElementById("emailDisplay").style.display = 'none';
            document.getElementById("createUserAccountDisplay").style.display = 'block';
            document.getElementById("viewUserAccountDisplay").style.display = 'none';
            document.getElementById("suspendUserAccountDisplay").style.display = 'none';
            document.getElementById("updateUserAccountDisplay").style.display = 'none';
            document.getElementById("calendarInviteDisplay").style.display="none";
        }

        function viewUserAccountFunction(){
            document.getElementById("emailDisplay").style.display = 'none';
            document.getElementById("createUserAccountDisplay").style.display = 'none';
            document.getElementById("viewUserAccountDisplay").style.display = 'block';
            document.getElementById("suspendUserAccountDisplay").style.display = 'none';
            document.getElementById("updateUserAccountDisplay").style.display = 'none';
            document.getElementById("calendarInviteDisplay").style.display="none";
        }

        function suspendUserAccountFunction(){
            document.getElementById("emailDisplay").style.display = 'none';
            document.getElementById("createUserAccountDisplay").style.display = 'none';
            document.getElementById("viewUserAccountDisplay").style.display = 'none';
            document.getElementById("suspendUserAccountDisplay").style.display = 'block';
            document.getElementById("updateUserAccountDisplay").style.display = 'none';
            document.getElementById("calendarInviteDisplay").style.display="none";
        }

        function updateUserAccountFunction(){
            document.getElementById("emailDisplay").style.display = 'none';
            document.getElementById("createUserAccountDisplay").style.display = 'none';
            document.getElementById("viewUserAccountDisplay").style.display = 'none';
            document.getElementById("suspendUserAccountDisplay").style.display = 'none';
            document.getElementById("updateUserAccountDisplay").style.display = 'block';
            document.getElementById("calendarInviteDisplay").style.display="none";
        }

        function calendarInviteFunction(){
            document.getElementById("emailDisplay").style.display = 'none';
            document.getElementById("createUserAccountDisplay").style.display = 'none';
            document.getElementById("viewUserAccountDisplay").style.display = 'none';
            document.getElementById("suspendUserAccountDisplay").style.display = 'none';
            document.getElementById("updateUserAccountDisplay").style.display = 'none';
            document.getElementById("calendarInviteDisplay").style.display="block";
        }

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

        function displayEmailR(){
            document.getElementById('displayR').style.display = "block";
            document.getElementById('displayD').style.display  = "none";
            displayInbox("reservation");
        }

        function displayEmailD(){
            document.getElementById('displayR').style.display = "none";
            document.getElementById('displayD').style.display = "block";
            displayInbox("delivery");
        }

        function displayInbox(emailType){
            $("#displayReservationInfo tr").remove(); 
            $("#displayDeliveryInfo tr").remove(); 
            if(emailType == "reservation"){
                var slotArrays = '<?php echo json_encode($reservationInboxArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
                var slotArray = slotArrays.split('].');
                var inboxArray = [];
                var actualInboxArray = [];
                var x;
                var y;
                var tempString = "";
                var tempString1 = "";

                var checkTOF = true;
                for (x=0;x<slotArray.length;x++)
                {
                    inboxArray.push(slotArray[x]);
                }
                for (x=0;x<inboxArray.length;x++){
                    tempString = String(inboxArray[x]).replaceAll('[','').replaceAll(']','');
                    tempString = tempString.split(',');
                    actualInboxArray.push(tempString);
                }
                var table = document.getElementById("displayReservationInfo");
                y = 0;
                for (x=actualInboxArray.length-1;x>=0;x--)
                {
                    var row = table.insertRow(y);
                    y++;
                    var cell = row.insertCell(0);
                    cell.innerHTML = '<text id="inboxListing' + String(x) + '"></text>';
                    document.getElementById("inboxListing"+String(x)).innerHTML = createInboxListing(actualInboxArray[x][0], actualInboxArray[x][1].replaceAll('~~', ','), actualInboxArray[x][2]);          
                }   
            }
            else if(emailType == "delivery"){
                var slotArrays = '<?php echo json_encode($deliveryInboxArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
                var slotArray = slotArrays.split('].');
                var inboxArray = [];
                var actualInboxArray = [];
                var x;
                var y;
                var tempString = "";
                var tempString1 = "";

                var checkTOF = true;
                for (x=0;x<slotArray.length;x++)
                {
                    inboxArray.push(slotArray[x]);
                }
                for (x=0;x<inboxArray.length;x++){
                    tempString = String(inboxArray[x]).replaceAll('[','').replaceAll(']','');
                    tempString = tempString.split(',');
                    actualInboxArray.push(tempString);
                }
                var table = document.getElementById("displayDeliveryInfo");
                y = 0;
                for (x=actualInboxArray.length-1;x>=0;x--)
                {
                    var row = table.insertRow(y);
                    y++;
                    var cell = row.insertCell(0);
                    cell.innerHTML = '<text id="inboxListing' + String(x) + '"></text>';
                    document.getElementById("inboxListing"+String(x)).innerHTML = createInboxListing(actualInboxArray[x][0], actualInboxArray[x][1].replaceAll('~~', ','), actualInboxArray[x][2]);          
                } 
            }
        }
        
        function createInboxListing(status, description, date){
            var listing='<div style="border-radius:15px;background-color:#A8A1A166;border:0px;margin-top:2px;padding:5px;width:880px">' +
                            '<text style="vertical-align:top;margin-right:auto;display:inline-block;width:100px;">' + status + '</text>' +
                            '<text style="margin-left:100px;margin-right:auto;display:inline-block;width:400px">' + description + '</text>' +
                            '<text style="vertical-align:top;margin-left:10px;margin-right:auto;display:inline-block;width:200px">' + date + '</text>' +
                        '</div>'
            return listing;
        }

        function createMiscAccount(){
            actualAccountArray = [];
            var slotArrays = '<?php echo json_encode($accountDataArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var slotArray = slotArrays.split('].');
            var accountArray = [];
            var x;
            var tempString = "";
            var exists = false;
            for (x=0;x<slotArray.length;x++){
                accountArray.push(slotArray[x]);
            }
            for (x=0;x<accountArray.length;x++){
                tempString = String(accountArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualAccountArray.push(tempString);
            }
            for (x=0;x<actualAccountArray.length;x++){
                if(actualAccountArray[x][1] == document.getElementById("create").value && 
                actualAccountArray[x][3] == document.getElementById("createAccountEmail1").value.toLowerCase()){
                    exists = true;
                    break;
                }
            }  
            if(document.getElementById("createAccountEmail1").value != "" && document.getElementById("create").value != "" &&
                document.getElementById("createAccountPassword1").value != "" && document.getElementById("createAccountDescription1").value != ""){
                if(exists == false){
                    $.ajax({
                        type: "POST",
                        url: "create_account_data.php",
                        data:{
                            input_email1:document.getElementById("createAccountEmail1").value.toLowerCase(),
                            input_profile: document.getElementById("create").value,
                            input_password1: document.getElementById("createAccountPassword1").value,
                            input_description1: document.getElementById("createAccountDescription1").value
                        },
                        success: function(data){
                            Swal.fire({
                                'title': 'Successfully created account!',
                                'text': data,
                                'type': 'success'
                            }).then(setTimeout(function(){window.location.replace("admin_homepage.php");}, 2000))
                        },
                        error: function(data){
                            Swal.fire({
                                'title': 'Errors',
                                'text': 'There were errors in creating account, please refresh the page and try again.'
                            })
                        }
                    });
                }  
                else{
                    alert("Account with this profile type already exists! Try another.");
                }      
            }
            else{
                alert("There are some missing fields!");
            }
        }

        function createCustomerAccount(){
            actualAccountArray = [];
            var slotArrays = '<?php echo json_encode($accountDataArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var slotArray = slotArrays.split('].');
            var accountArray = [];
            var x;
            var tempString = "";
            var exists = false;
            for (x=0;x<slotArray.length;x++){
                accountArray.push(slotArray[x]);
            }
            for (x=0;x<accountArray.length;x++){
                tempString = String(accountArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualAccountArray.push(tempString);
            }
            
            for (x=0;x<actualAccountArray.length;x++){
                if(actualAccountArray[x][1] == document.getElementById("create").value && 
                actualAccountArray[x][3] == document.getElementById("createAccountEmail2").value.toLowerCase()){
                    exists = true;
                    break;
                }
            }  
            if(document.getElementById("createAccountEmail2").value != "" && document.getElementById("create").value != "" &&
                document.getElementById("createAccountPassword2").value != "" && document.getElementById("createAccountName2").value != "" &&
                document.getElementById("createAccountNumber2").value != "" && document.getElementById("createAccountDescription2").value != ""){
                if(exists == false){
                    $.ajax({
                        type: "POST",
                        url: "create_account_data.php",
                        data:{
                            input_email2:document.getElementById("createAccountEmail2").value.toLowerCase(),
                            input_profile: document.getElementById("create").value,
                            input_fullname2: document.getElementById("createAccountName2").value,
                            input_password2: document.getElementById("createAccountPassword2").value,
                            input_phone2: document.getElementById("createAccountNumber2").value,
                            input_description2: document.getElementById("createAccountDescription2").value
                        },
                        success: function(data){
                            Swal.fire({
                                'title': 'Successfully created account!',
                                'text': data,
                                'type': 'success'
                            }).then(setTimeout(function(){window.location.replace("admin_homepage.php");}, 2000))
                        },
                        error: function(data){
                            Swal.fire({
                                'title': 'Errors',
                                'text': 'There were errors in creating account, please refresh the page and try again.'
                            })
                        }
                    });
                }
                else{
                    alert("Account with this profile type already exists! Try another.");
                }
            }
            else{
                alert("There are some missing fields!");
            }
        }

        function checkProfileType(createOrUpdate){
            if(createOrUpdate == "create"){
                if(document.getElementById("create").value == "customer"){
                    document.getElementById("customerType").style.display = "block";
                    document.getElementById("miscType").style.display = "none";
                }           
                else{
                    document.getElementById("customerType").style.display = "none";
                    document.getElementById("miscType").style.display = "block";
                }
            }
            else{
                if(document.getElementById("updateDetails").value == "customer"){
                    document.getElementById("updateCustomerType").style.display = "block";
                    document.getElementById("updateMiscType").style.display = "none";
                    for(var x=0; x<actualAccountArray.length; x++){
                        if(actualAccountArray[x][1] == document.getElementById("updateDetails").value.toLowerCase() &&
                            actualAccountArray[x][3] == document.getElementById("searchUpdateEmail").value.toLowerCase()){
                                document.getElementById("updateCustomerAccountName").value = actualAccountArray[x][2];
                                document.getElementById("updateCustomerAccountPassword").value = actualAccountArray[x][4];
                                document.getElementById("updateCustomerAccountNumber").value = actualAccountArray[x][5];
                                document.getElementById("updateCustomerAccountDescription").value = actualAccountArray[x][7];
                                document.getElementById("customerStatus").value = actualAccountArray[x][6];
                                break;
                        }
                    }
                }           
                else{
                    document.getElementById("updateCustomerType").style.display = "none";
                    document.getElementById("updateMiscType").style.display = "block";
                    for(var x=0; x<actualAccountArray.length; x++){
                        if(actualAccountArray[x][1] == document.getElementById("updateDetails").value.toLowerCase() &&
                            actualAccountArray[x][3] == document.getElementById("searchUpdateEmail").value.toLowerCase()){
                                document.getElementById("updateAccountPassword").value = actualAccountArray[x][4];
                                document.getElementById("updateAccountDescription").value = actualAccountArray[x][7];
                                document.getElementById("miscStatus").value = actualAccountArray[x][6];
                                break;
                        }
                    }
                }
            }
        }

        var profileTypeArray;
        var profileDescriptionArray;
        var profileStatusArray;
        function checkProfileSize(accountEmail){
            profileTypeArray = [];
            profileDescriptionArray = [];
            profileStatusArray = [];
            for(var x=0; x<actualAccountArray.length; x++){
                if(actualAccountArray[x][3] == accountEmail){
                    profileTypeArray.push(actualAccountArray[x][1]);
                    profileDescriptionArray.push(actualAccountArray[x][7]);
                    profileStatusArray.push(actualAccountArray[x][6]);
                }
            }
        }
        var profileType;
        var profileDescription;
        var profileStatus;
        
        function suspendProfileList(){
            for(var x=0;x<profileTypeArray.length;x++){
                document.getElementById('suspend' + String(x+1) + 'TR').style.display = "";
                document.getElementById("suspendType" + String(x+1)).innerHTML = profileTypeArray[x];
                document.getElementById("suspendDescription" + String(x+1)).innerHTML = profileDescriptionArray[x];
                document.getElementById("suspendStatus" + String(x+1)).innerHTML = profileStatusArray[x];
                document.getElementById("suspendButton").style.display = "block";
            }
        }

        function selectProfileType(selectedRow){
            profileType = "";
            profileDescription = "";
            profileStatus = "";
            var checkFound = false;
            for(var x=0;x<profileTypeArray.length;x++){
                if(('suspend' + String(x+1) + 'TR').includes(selectedRow) && document.getElementById(selectedRow).checked){
                    document.getElementById('suspend' + String(x+1) + 'TR').style.backgroundColor = "yellow";
                    profileType = document.getElementById('suspendType' + String(x+1)).innerHTML;
                    profileDescription = document.getElementById('suspendDescription' + String(x+1)).innerHTML;
                    profileStatus = document.getElementById('suspendStatus' + String(x+1)).innerHTML;
                    checkFound = true;
                }
                else{
                    document.getElementById('suspend' + String(x+1) + 'TR').style.backgroundColor = "#A8A1A166";
                    document.getElementById('suspend' + String(x+1)).checked = false;
                }
                if(checkFound == true){
                    document.getElementById("suspendButton").disabled = false;
                }
                else{
                    document.getElementById("suspendButton").disabled = true;
                }
            }
        }

        var actualAccountArray = [];
        function checkAccounts(accountType){
            document.getElementById("suspend1TR").style.display = "none";
            document.getElementById("suspend2TR").style.display = "none";
            document.getElementById("suspend3TR").style.display = "none";
            document.getElementById("suspend4TR").style.display = "none";
            document.getElementById("updateCustomerType").style.display = "none";
            document.getElementById("updateMiscType").style.display = "none";
            document.getElementById("suspendButton").disabled = true;
            actualAccountArray = [];
            var slotArrays = '<?php echo json_encode($accountDataArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var slotArray = slotArrays.split('].');
            var accountArray = [];
            var x;
            var tempString = "";
            for (x=0;x<slotArray.length;x++){
                accountArray.push(slotArray[x]);
            }
            for (x=0;x<accountArray.length;x++){
                tempString = String(accountArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualAccountArray.push(tempString);
            }
            if(accountType == "suspend"){
                if(document.getElementById("searchSuspendEmail").value.length > 0){
                    checkProfileSize(document.getElementById("searchSuspendEmail").value.toLowerCase());
                }
                if(document.getElementById("searchSuspendEmail").value.toLowerCase().length === null || document.getElementById("searchSuspendEmail").value.toLowerCase() === ""){
                    document.getElementById("suspend1TR").style.display = "none";
                    document.getElementById("suspend2TR").style.display = "none";
                    document.getElementById("suspend3TR").style.display = "none";
                    document.getElementById("suspend4TR").style.display = "none";
                    document.getElementById("suspendButton").style.display = "none";
                }
                else{
                    document.getElementById("updateList").style.display = "none";
                    document.getElementById("suspendButton").style.display = "none";
                    suspendProfileList();
                }
            }
            else if(accountType == "view"){
                viewTable();
            }
            else{
                if(document.getElementById("searchUpdateEmail").value.length > 0){
                    checkProfileSize(document.getElementById("searchUpdateEmail").value.toLowerCase());
                }
                if(document.getElementById("searchUpdateEmail").value.toLowerCase().length === null || document.getElementById("searchUpdateEmail").value.toLowerCase() === ""){
                    document.getElementById("updateList").style.display = "none";
                }
                else{
                    updateProfileList();
                }
            }
        }

        var updateProfile;
        var updateName;
        var updateEmail;
        var updatePassword;
        var updatePhoneNumber;
        var updateStatus;
        var updateDescription;

        function updateProfileList(){
            document.getElementById("updateList").style.display = "none";
            var op = document.getElementById("updateDetails").getElementsByTagName("option");
            for(var x=0; x<op.length; x++){
                op[x].disabled = true;
            }
            for(var x=0; x<profileTypeArray.length; x++){
                for(var y=0; y<op.length; y++){
                    if(op[y].value.toLowerCase() == profileTypeArray[x].toLowerCase()){
                        op[y].disabled = false;
                        document.getElementById("updateList").style.display = "block";
                        document.getElementById("updateDetails").value = op[y].value;
                    }
                }
            }
        }

        function suspendAccountProfile(){
            $.ajax({
                type: "POST",
                url: "suspend_account_data.php",
                data:{
                    email:document.getElementById("searchSuspendEmail").value.toLowerCase(),
                    profileID: profileType
                },
                success: function(data){
                    Swal.fire({
                        'title': 'Successfully suspended profile!',
                        'text': data,
                        'type': 'success'
                    }).then(setTimeout(function(){window.location.replace("admin_homepage.php");}, 2000))
                },
                error: function(data){
                    Swal.fire({
                        'title': 'Errors',
                        'text': 'There were errors in suspending profile, please refresh the page and try again.'
                    })
                }
            });
        }

        function updateMiscAccount(){
            updateStatus = document.getElementById("miscStatus").value;
            updateProfile = document.getElementById("updateDetails").value;
            updateName = "";
            updatePhoneNumber = "";
            updateDescription = document.getElementById("updateAccountDescription").value;
            updatePassword = document.getElementById("updateAccountPassword").value;
            updateEmail = document.getElementById("searchUpdateEmail").value;
            $.ajax({
                type: "POST",
                url: "update_account_data.php",
                data:{
                    profileID: updateProfile,
                    fullName: updateName,
                    email: updateEmail,
                    accountPassword: updatePassword,
                    phoneNumber: updatePhoneNumber,
                    accountStatus: updateStatus,
                    accountDescription: updateDescription
                },
                success: function(data){
                    Swal.fire({
                        'title': 'Successfully updated profile details!',
                        'text': data,
                        'type': 'success'
                    }).then(setTimeout(function(){window.location.replace("admin_homepage.php");}, 2000))
                },
                error: function(data){
                    Swal.fire({
                        'title': 'Errors',
                        'text': 'There were errors in updating your profile, please refresh the page and try again.'
                    })
                }
            });
        }

        function updateCustomerAccount(){
            updateStatus = document.getElementById("customerStatus").value;
            updateProfile = document.getElementById("updateDetails").value;
            updateName = document.getElementById("updateCustomerAccountName").value;
            updatePhoneNumber = document.getElementById("updateCustomerAccountNumber").value;
            updateDescription = document.getElementById("updateCustomerAccountDescription").value;
            updatePassword = document.getElementById("updateCustomerAccountPassword").value;
            updateEmail = document.getElementById("searchUpdateEmail").value;
            $.ajax({
                type: "POST",
                url: "update_account_data.php",
                data:{
                    profileID: updateProfile,
                    fullName: updateName,
                    email: updateEmail,
                    accountPassword: updatePassword,
                    phoneNumber: updatePhoneNumber,
                    accountStatus: updateStatus,
                    accountDescription: updateDescription
                },
                success: function(data){
                    Swal.fire({
                        'title': 'Successfully updated profile details!',
                        'text': data,
                        'type': 'success'
                    }).then(setTimeout(function(){window.location.replace("admin_homepage.php");}, 2000))
                },
                error: function(data){
                    Swal.fire({
                        'title': 'Errors',
                        'text': 'There were errors in updating your profile, please refresh the page and try again.'
                    })
                }
            });
        }

        function viewTable(){
            $("#viewTableData tr").remove(); 
            var dataArrays = '<?php echo json_encode($accountDataArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var dataArray = dataArrays.split('].');
            var profileArray = [];
            var totalProfileArray = [];

            var x;
            var tempString = "";
            for (x=0;x<dataArray.length;x++)
            {
                profileArray.push(dataArray[x]);
            }
            for (x=0;x<profileArray.length;x++){
                tempString = String(profileArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                totalProfileArray.push(tempString);
            }

            var x;
            var y = 0;
            var tempString = "";
            var table = document.getElementById('viewTableData');
            var row;
            var searchReq = document.getElementById('searchViewEmail').value;
            for (x=0; x<totalProfileArray.length; x++){
                if(totalProfileArray[x][3].toLowerCase().includes(searchReq.toLowerCase()) || 
                    totalProfileArray[x][1].toLowerCase().includes(searchReq.toLowerCase()) ||
                    totalProfileArray[x][7].toLowerCase().includes(searchReq.toLowerCase()) ||
                    totalProfileArray[x][6].toLowerCase().includes(searchReq.toLowerCase())){
                    if (y==0){
                        row = table.insertRow(y);
                        row.style.backgroundColor = "#5BBDE4CC";
                        var cell0 = row.insertCell(0);
                        cell0.innerHTML = '<td id="viewEmail' + String(x) +'" style="width:auto;padding:5px;">'+
                                        '<text style="width:auto;padding:5px;display:inline-block">Email</text></td>';
                        var cell1 = row.insertCell(1);
                        cell1.innerHTML = '<td id="viewType' + String(x) +'" style="width:auto;padding:5px;">'+
                                        '<text style="width:120px;padding:5px;display:inline-block">Profile Type</text></td>';
                        var cell2 = row.insertCell(2);
                        cell2.innerHTML = '<td id="viewDescription' + String(x) +'" style="width:300px;padding:5px;">'+
                                        '<text style="width:300px;padding:5px;display:inline-block">Description</text></td>';
                        var cell3 = row.insertCell(3);
                        cell3.innerHTML = '<td id="viewStatus' + String(x) +'" style="width:auto;padding:5px;">'+
                                        '<text style="width:150px;padding:5px;display:inline-block;">Account status</text></td>';
                    }
                    row = table.insertRow(y+1);
                    row.style.backgroundColor = "#A8A1A166";
                    var cell0 = row.insertCell(0);
                    cell0.innerHTML = '<td id="viewEmail' + String(x) +'" style="width:auto;padding:5px">'+
                                    '<text style="width:auto;padding:5px;display:inline-block">' + totalProfileArray[x][3] +'</text></td>';
                    var cell1 = row.insertCell(1);
                    cell1.innerHTML = '<td id="viewType' + String(x) +'" style="width:auto;padding:5px">'+
                                    '<text style="width:auto;padding:5px;display:inline-block">' + totalProfileArray[x][1] +'</text></td>';
                    var cell2 = row.insertCell(2);
                    cell2.innerHTML = '<td id="viewDescription' + String(x) +'" style="width:300px;padding:5px">'+
                                    '<text style="width:300px;padding:5px;display:inline-block">' + totalProfileArray[x][7] +'</text></td>';
                    var cell3 = row.insertCell(3);
                    cell3.innerHTML = '<td id="viewStatus' + String(x) +'" style="width:auto;padding:5px">'+
                                    '<text style="width:150px;padding:5px;display:inline-block">' + totalProfileArray[x][6] +'</text></td>';
                    y++
                }           
            }        
        }

        function sendCalendarInvite(){
            var eventName = document.getElementById("eventName").value;
            var emailDetails = document.getElementById("emailDescription").value;
            var emailAddress = document.getElementById("emailAddress").value;
            var inviteLink = document.getElementById("eventLink").value;
            var acceptButton = '<a target="_blank" href="'+inviteLink+'"><input type="button" value="Accept"></a>';
            var params = {
                eventName: eventName,
                emailDetails: emailDetails,
                emailAddress: emailAddress,
                acceptButton: acceptButton
            };

            const serviceID = "service_s95qq4x";
            const templateID = "template_l4x96o7";

            //Send email
            emailjs.send(serviceID, templateID, params).then(res=>{
                alert("Email has been sent");
                window.location.replace("admin_homepage.php");
            })
            .catch(err=>console.log(err));
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
                    <a href="admin_homepage.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="margin-left:0px;width:500px;height:200px;display:inline-block"></a>
                </div></br>

                <div style="float:left;margin-left:30px;display:inline-block">
                    <text style="color:#437E96;font-size:30px">INBOX</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:auto">
                            <input type="button" id="emailButton" name="emailButton" value="Check inbox" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="emailFunction();"></br>
                        </div></br></br>
                    </div></br>

                    <text style="color:#437E96;font-size:30px;">ACCOUNTS</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:auto">
                            <input type="button" id="createUserAccountButton" name="createUserAccountButton" value="Create user account" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="createUserAccountFunction()"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:auto">
                            <input type="button" id="viewUserAccountButton" name="viewUserAccountButton" value="View user account" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="viewUserAccountFunction();checkAccounts('view')"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:auto">
                            <input type="button" id="suspendUserAccountButton" name="suspendUserAccountButton" value="Suspend user account" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="suspendUserAccountFunction()"></br>
                        </div>
                        <div class="mouseOverEffects" style="width:auto">
                            <input type="button" id="updateUserAccountButton" name="updateUserAccountButton" value="Update user account" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="updateUserAccountFunction()"></br>
                        </div></br></br>
                    </div></br>

                    <text style="color:#437E96;font-size:30px">Calendar invite</text></br>
                    <div style="float:left;margin-left:40px;margin-top:30px;display:inline-block">
                        <div class="mouseOverEffects" style="width:auto">
                            <input type="button" id="calendarInviteButton" name="calendarInviteButton" value="Calendar invite" style="padding:10px;border:0px;background-color:transparent;cursor:pointer" onclick="calendarInviteFunction();"></br>
                        </div></br></br>
                    </div></br>
                </div>

                <div style="float:left;margin-left:200px;">
                    <div id="emailDisplay" style="display:none;width:900px;">
                        <text style="color:#437E96;font-size:40px;">
                            Check inbox                         
                        </text></br></br></br>
                        <div>
                            <input class="buttonEffects" type="button" style="float:left;margin-left:15%;width:200px;font-size:20px;padding-5px;" value="Reservation email" onclick="displayEmailR()">
                            <input class="buttonEffects" type="button" style="float:right;margin-right:15%;width:200px;font-size:20px;padding-5px;" value="Delivery email" onclick="displayEmailD()"></br>
                        </div></br></br>
                        <div style="background-color:#3280F466;">
                            <text style="margin-right:auto;display:inline-block;font-size:20px;width:100px">Status</text>
                            <text style="margin-left:100px;margin-right:auto;display:inline-block;font-size:20px;width:400px;">Description</text>
                            <text style="margin-left:10px;margin-right:auto;display:inline-block;font-size:20px;width:200px;">Date</text>
                        </div>
                        <div id="displayR" class="example" style="font-size:20px;height:300px;overflow-y:auto;max-height:600px;display:none">
                            <table id="displayReservationInfo">
                            </table>
                        </div>
                        <div id="displayD" class="example" style="font-size:20px;height:300px;overflow-y:auto;max-height:600px;display:none">
                            <table id="displayDeliveryInfo">
                            </table>
                        </div>
                    </div>
                </div>    

                <div style="float:left;margin-left:200px;">
                    <div id="createUserAccountDisplay" style="display:none;width:600px;">
                        <text style="color:#437E96;font-size:30px;">
                            Create user account                              
                        </text></br></br>
                        <div id="createAccount" style="font-size:20px;display:block">
                            <label style="width:120px;display:inline-block">Profile type: </label>
                            <select id="create" name="input_profile" style="margin-left:25px;width:304px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" onchange="checkProfileType(this.id)" onclick="checkProfileType(this.id)">
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                                <option value="owner">Owner</option>
                                <option value="customer">Customer</option>
                            </select>
                            </br></br>
                            <div id="miscType" style="display:none">
                                <label style="width:120px;display:inline-block">Email: </label><input type="text" id="createAccountEmail1" name="input_email1" style="margin-top:5px;margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter email address"></br></br>
                                <label style="width:120px;display:inline-block">Password: </label><input type="text" id="createAccountPassword1" name="input_password1" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter password"></br></br>
                                <label style="width:120px;display:inline-block">Description: </label><input type="text" id="createAccountDescription1" name="input_description1" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter description"></br></br>
                                <input type="button" name="create1" class="buttonHoverEffect" style="display:inline-block;width:485px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Create account" onclick="createMiscAccount()">
                            </div>
                            <div id="customerType" style="display:none">
                                <label style="width:120px;display:inline-block">Full name: </label><input type="text" id="createAccountName2" name="input_fullname2" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter full name"></br></br>
                                <label style="width:120px;display:inline-block">Email: </label><input type="text" id="createAccountEmail2" name="input_email2" style="margin-top:5px;margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter email address"></br></br>
                                <label style="width:120px;display:inline-block">Password: </label><input type="text" id="createAccountPassword2" name="input_password2" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter password"></br></br>
                                <label style="width:140px;display:inline-block">Phone number: </label><input type="text" id="createAccountNumber2" name="input_phone2" style="margin-left:10px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter phone number"></br></br>
                                <label style="width:120px;display:inline-block">Description: </label><input type="text" id="createAccountDescription2" name="input_description2" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter description"></br></br>
                                <input type="button" name="create2" class="buttonHoverEffect" style="display:inline-block;width:485px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Create account" onclick="createCustomerAccount()">
                            </div>
                        </div></br>
                    </div>
                </div>
                <div style="float:left;margin-left:200px;">
                    <div id="viewUserAccountDisplay" style="display:none;width:600px;">
                        <text style="color:#437E96;font-size:30px;">
                            View user account                          
                        </text></br></br>
                        <div>
                            <input type="text" id="searchViewEmail" style="width:300px;height:30px;display:inline-block;font-size:20px;background-color:#A8A1A166;border:none;border-radius:5px;" placeholder="Enter keywords">
                            <input type="button" id="view" class="buttonHoverEffect" style="margin-left:20px;width:100px;height:40px;display:inline-block;font-size:20px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="search" onclick="checkAccounts(this.id);">
                        </div></br>
                        <div id="displayViewTable" style="display:block">
                            <table id="viewTableData" rules="all" style="font-size:20px">
                            </table>
                        </div>
                    </div>
                </div>
                <div style="float:left;margin-left:200px;">
                    <div id="suspendUserAccountDisplay" style="display:none;width:600px;">
                        <text style="color:#437E96;font-size:30px;">
                            Suspend user account                           
                        </text></br></br>
                        <div>
                            <input type="text" id="searchSuspendEmail" style="width:300px;height:30px;display:inline-block;font-size:20px;background-color:#A8A1A166;border:none;border-radius:5px;" placeholder="Enter email address">
                            <input type="button" id="suspend" class="buttonHoverEffect" style="margin-left:20px;width:100px;height:40px;display:inline-block;font-size:20px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="search" onclick="checkAccounts(this.id);">
                        </div></br>
                        <div style="display:block">
                            <table id="suspendTable" rules="all">
                                <tr style="background-color:#5BBDE4CC;">
                                    <td style="width:200px;padding:5px"><center>Select</center></td>
                                    <td style="width:200px;padding:5px">Profile Type</td>
                                    <td style="width:300px;padding:5px">Description</td>
                                    <td style="width:200px;padding:5px">Account status</td>
                                </tr>
                                <tr id="suspend1TR" style="background-color:#A8A1A166;display:none">
                                    <td><center><input type="checkbox" id="suspend1" style="cursor:pointer" onclick="selectProfileType(this.id)"></center></td>
                                    <td id="suspendType1" style="width:200px;padding:5px"></td>
                                    <td id="suspendDescription1" style="width:300px;padding:5px"></td>
                                    <td id="suspendStatus1" style="width:200px;padding:5px"></td>
                                </tr>
                                <tr id="suspend2TR" style="background-color:#A8A1A166;display:none">
                                    <td><center><input type="checkbox" id="suspend2" style="cursor:pointer" onclick="selectProfileType(this.id)"></center></td>
                                    <td id="suspendType2" style="width:200px;padding:5px"></td>
                                    <td id="suspendDescription2" style="width:300px;padding:5px"></td>
                                    <td id="suspendStatus2" style="width:200px;padding:5px"></td>
                                </tr>
                                <tr id="suspend3TR" style="background-color:#A8A1A166;display:none"> 
                                    <td><center><input type="checkbox" id="suspend3" style="cursor:pointer" onclick="selectProfileType(this.id)"></center></td>
                                    <td id="suspendType3" style="width:200px;padding:5px"></td>
                                    <td id="suspendDescription3" style="width:300px;padding:5px"></td>
                                    <td id="suspendStatus3" style="width:200px;padding:5px"></td>
                                </tr>
                                <tr id="suspend4TR" style="background-color:#A8A1A166;display:none">
                                    <td><center><input type="checkbox" id="suspend4" style="cursor:pointer" onclick="selectProfileType(this.id)"></center></td>
                                    <td id="suspendType4" style="width:200px;padding:5px"></td>
                                    <td id="suspendDescription4" style="width:300px;padding:5px"></td>
                                    <td id="suspendStatus4" style="width:200px;padding:5px"></td>
                                </tr>
                            </table></br>
                            <div>
                                <input type="button" id="suspendButton" class="buttonHoverEffect" style="display:inline-block;width:600px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px;display:none" value="Suspend account" onclick="suspendAccountProfile()" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="float:left;margin-left:200px;">
                    <div id="updateUserAccountDisplay" style="display:none;width:600px;">
                        <text style="color:#437E96;font-size:30px;">
                            Update user account                           
                        </text></br></br>
                        <div>
                            <input type="text" id="searchUpdateEmail" style="width:300px;height:30px;display:inline-block;font-size:20px;background-color:#A8A1A166;border:none;border-radius:5px;" placeholder="Enter email address">
                            <input type="button" id="update" class="buttonHoverEffect" style="margin-left:20px;width:100px;height:40px;display:inline-block;font-size:20px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="search" onclick="checkAccounts(this.id);">
                        </div></br>
                        <div id="updateList" style="font-size:20px;display:none">
                            <label style="width:160px;display:inline-block">Select profile type: </label>
                            <select id="updateDetails" style="margin-left:15px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer" onchange="checkProfileType(this.id)" onclick="checkProfileType(this.id)">
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                                <option value="owner">Owner</option>
                                <option value="customer">Customer</option>
                            </select></br></br>
                            <div id="updateMiscType" style="display:none">
                                <label style="width:150px;display:inline-block">Password: </label><input type="text" id="updateAccountPassword" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter password"></br></br>
                                <label style="width:150px;display:inline-block">Description: </label><input type="text" id="updateAccountDescription" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter description"></br></br>
                                <label style="width:160px;display:inline-block">Select status type: </label>
                                <select id="miscStatus" style="margin-left:15px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer">
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                </select></br></br>
                                <input type="button" class="buttonHoverEffect" style="display:inline-block;width:485px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Update account" onclick="updateMiscAccount()">
                            </div>
                            <div id="updateCustomerType" style="display:none">
                                <label style="width:150px;display:inline-block">Full name: </label><input type="text" id="updateCustomerAccountName" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter full name"></br></br>
                                <label style="width:150px;display:inline-block">Password: </label><input type="text" id="updateCustomerAccountPassword" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter password"></br></br>
                                <label style="width:150px;display:inline-block">Phone number: </label><input type="text" id="updateCustomerAccountNumber" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter phone number"></br></br>
                                <label style="width:150px;display:inline-block">Description: </label><input type="text" id="updateCustomerAccountDescription" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px" placeholder="Enter description"></br></br>
                                <label style="width:160px;display:inline-block">Select status type: </label>
                                <select id="customerStatus" style="margin-left:15px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer">
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                </select></br></br>
                                <input type="button" class="buttonHoverEffect" style="display:inline-block;width:485px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Update account" onclick="updateCustomerAccount()">
                            </div>
                        </div>
                    </div>
                </div>

                <div style="float:left;margin-left:200px;">
                    <div id="calendarInviteDisplay" style="display:none;width:900px;">
                        <text style="color:#437E96;font-size:40px;">
                            Calendar invites                         
                        </text></br></br></br>
                        <div>
                            <label style="width:150px;display:inline-block">Event name:</label><input type="text" id="eventName" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                            <label style="width:150px;display:inline-block">Event link:</label><input type="text" id="eventLink" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                            <label style="width:150px;display:inline-block">Email address:</label></label><input type="text" id="emailAddress" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></br></br>
                            <label style="width:150px;display:inline-block">Description:</label></label><textarea id="emailDescription" style="margin-left:30px;width:300px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px"></textarea></br></br>
                            <input type="button" style="display:inline-block;width:485px;height:40px;cursor:pointer;background-color:#5BBDE4CC;border-radius:10px" value="Send invite" onclick="sendCalendarInvite()">
                        </div>
                    </div>
                </div>    
            </div>
        </form>
    </body>
</html>