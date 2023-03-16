<?php
require_once("accountDB.php");
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
        var fullName;
        var email;
        var accountPassword;
        var retypePassword;
        var phoneNumber;
        var profileID;

        var errorType1;
        var errorType2;
        var errorType3;
        var errorType4;
        var errorType5;

        function wrongFunction(){
            document.getElementById("myPopup").style.visibility = 'visible';
        }

        function returnFunction(){
            document.getElementById("myPopup").style.visibility = 'hidden';
        }

        function mouseOver(){
            document.getElementById("returnButton").style.border = "2px solid black";
            document.getElementById("returnButton").style.borderColor = "back";
        }

        function mouseOut(){
            document.getElementById("returnButton").style.border = "0px";
            document.getElementById("returnButton").style.borderColor = "";
        }

        function registerFunction(){
            fullName = document.getElementById("nameInput").value;
            email = document.getElementById("emailInput").value.toLowerCase();
            accountPassword = document.getElementById("passwordInput").value;
            retypePassword = document.getElementById("retypeInput").value;
            phoneNumber = document.getElementById("contactInput").value;

            if(email.toLowerCase().includes(".moshiqqadmin@gmail.com")){
                profileID = "admin";
            }
            else if(email.toLowerCase().includes(".moshiqqowner@gmail.com")){
                profileID = "owner";
            }
            else if(email.toLowerCase().includes(".moshiqqstaff@gmail.com")){
                profileID = "staff";
            }
            else{
                profileID = "customer";
            }

            $.ajax({
                type: "POST",
                url: "account_details_data.php",
                data:{
                    profileID:profileID,
                    fullName:fullName,
                    email:email,
                    accountPassword:accountPassword,
                    phoneNumber:phoneNumber,
                    accountStatus: "active",
                    accountDescription: "Created by customer"
                },
                success: function(data){
                    Swal.fire({
                        'title': 'Successfully created your account!',
                        'text': data,
                        'type': 'success'
                    }).then(function(){
                        window.location.replace("../LogIn/logInScreen.php");
                    });
                },
                error: function(data){
                    wrongFunction();
                }
            });
        }
        function backFunction(){
            window.location.href = "../LogIn/logInScreen.php";
        }

        function checkPassword(){
            if (document.getElementById("passwordInput").value == "" && document.getElementById("retypeInput").value == ""){
                document.getElementById("passwordError").innerHTML = "Required field";
                document.getElementById("retypeError").innerHTML = "Required field";
                errorType3 = true;
                errorType4 = true;
            }
            else if (document.getElementById("passwordInput").value != document.getElementById("retypeInput").value){
                document.getElementById("passwordError").innerHTML = "Passwords do not match!";
                document.getElementById("retypeError").innerHTML = "Passwords do not match!";
                errorType3 = true;
                errorType4 = true;
            }
            else{
                document.getElementById("passwordError").innerHTML = "</br>";
                document.getElementById("retypeError").innerHTML = "</br>";
                errorType3 = false;
                errorType4 = false;
            }
        }

        function checkName(){
            if(document.getElementById("nameInput").value == ""){
                document.getElementById("nameError").innerHTML = "Required field";
                errorType1 = true;
            }
            else{
                document.getElementById("nameError").innerHTML = "</br>";
                errorType1 = false;
            }
        }

        function checkEmail(){
            var slotArrays = '<?php echo json_encode($dataArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var slotArray = slotArrays.split('].');
            var accountArray = [];
            var actualAccountArray = []
            var x;
            var tempString = "";
            var tempString1 = "";
            for (x=0;x<slotArray.length;x++)
            {
                accountArray.push(slotArray[x]);
            }
            for (x=0;x<accountArray.length;x++){
                tempString = String(accountArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualAccountArray.push(tempString);
            }
            for (x=0;x<actualAccountArray.length;x++)
            {
                if(document.getElementById("emailInput").value.toLowerCase() == actualAccountArray[x][3].toLowerCase() && actualAccountArray[x][1].toLowerCase() == "customer"){
                    document.getElementById("emailError").innerHTML = "Email already used!";
                    errorType2 = true;
                    break;
                }
                else if(document.getElementById("emailInput").value == ""){
                    document.getElementById("emailError").innerHTML = "Required field";
                    errorType2 = true;
                }
                else if(document.getElementById("emailInput").value.includes("@") && 
                        document.getElementById("emailInput").value.includes(".com")){
                    document.getElementById("emailError").innerHTML = "</br>";
                    errorType2 = false;
                }
                else{
                    document.getElementById("emailError").innerHTML = "Invalid email format";
                    errorType2 = true;
                }
            }
        }

        function checkContact(){
            var slotArrays = '<?php echo json_encode($dataArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");;
            var slotArray = slotArrays.split('].');
            var accountArray = [];
            var actualAccountArray = []
            var x;
            var tempString = "";
            var tempString1 = "";
            for (x=0;x<slotArray.length;x++)
            {
                accountArray.push(slotArray[x]);
            }
            for (x=0;x<accountArray.length;x++){
                tempString = String(accountArray[x]).replaceAll('[','').replaceAll(']','');
                tempString = tempString.split(',');
                actualAccountArray.push(tempString);
            }
            for (x=0;x<actualAccountArray.length;x++)
            {
                if(document.getElementById("contactInput").value == actualAccountArray[x][5]){
                    document.getElementById("contactError").innerHTML = "Number already used!";
                    errorType5 = true;
                    break;
                }
                else if(document.getElementById("contactInput").value == ""){
                    document.getElementById("contactError").innerHTML = "Required field";
                    errorType5 = true;
                }
                else if(document.getElementById("contactInput").value.length != 8){
                    document.getElementById("contactError").innerHTML = "Invalid contact no. format!";
                    errorType5 = true;
                }
                else{
                    document.getElementById("contactError").innerHTML = "</br>";
                    errorType5 = false;
                }
            }
        }

        function checkRegister(){
            fullName = document.getElementById("nameInput").value;
            email = document.getElementById("emailInput").value;
            accountPassword = document.getElementById("passwordInput").value;
            retypePassword = document.getElementById("retypeInput").value;
            phoneNumber = document.getElementById("contactInput").value;

            if(fullName == "" || email == "" || accountPassword == "" || retypePassword == "" || phoneNumber == ""){
                document.getElementById("registerButton").disabled = true;
                document.getElementById("registerButton").style.background = "grey";
            }
            else{
                if(errorType1 == false && errorType2 == false && 
                    errorType3 == false && errorType4 == false && errorType5 == false){
                    document.getElementById("registerButton").disabled = false;
                    document.getElementById("registerButton").style.background = "#437E96";
                }
                else{
                    document.getElementById("registerButton").disabled = true;
                    document.getElementById("registerButton").style.background = "grey";
                }
            }
        }
    </script>
    <style>
        .popup {
            display: inline-block;
        }

        .popup .popuptext {
            visibility: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 44.2839px 49.2043px;
            gap: 29.52px;

            position: absolute;
            width: 500px;
            height: 240px;
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

        .buttonEffects {
          border-radius: 25px;
          background-color: #437E96;
          border: none;
          color: white;
        }
        .buttonEffects:hover {
                border: 2px solid black;
                cursor:pointer;
        }

    </style>
    <body onload="checkPassword();checkName();checkEmail();checkContact();checkRegister()" style="background-color:#FEF2E5;">
        <form>
            <div style="margin-left:auto;margin-right:auto;width:1200px;display:block">
                <a href="../index.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="margin-left:auto;margin-right:auto;width:500px;height:200px;display:block"></a>
                <text id="registerText" name="registerText" style="margin-left:40%;margin-right:auto;width:300px;font-size:30px;display:block">REGISTER ACCOUNT</text></br></br>
                <text id="nameText" name="nameText" style="margin-left:26%;float:left;margin-top:15px;margin-right:auto;width:150px;display:block">Full Name</text>
                <input type="text" id="nameInput" name="nameInput" style="background-color:#D9D9D9;border-radius:15px;border:0px;;font-size:15px;padding:10px;height:40px;width:300px" onkeyup="checkName();checkRegister()" required></br>
                <text id="nameError" name="nameError" style="color:red;margin-left:45%;margin-right:auto;width:300px;font-size:15px;display:block"></text></br>
                <text id="emailText" name="emailText" style="margin-left:26%;float:left;margin-top:15px;margin-right:auto;width:150px;display:block">Email Address</text>
                <input type="email" id="emailInput" name="emailInput" style="background-color:#D9D9D9;border-radius:15px;border:0px;font-size:15px;padding:10px;height:40px;width:300px" onkeyup="checkEmail();checkRegister()" required></br>
                <text id="emailError" name="emailError" style="color:red;margin-left:45%;margin-right:auto;width:300px;font-size:15px;display:block"></text></br>
                <text id="passwordText" name="passwordText" style="margin-left:26%;float:left;margin-top:15px;margin-right:auto;width:150px;display:block">Password</text>
                <input type="password" id="passwordInput" name="passwordInput" style="background-color:#D9D9D9;border-radius:15px;border:0px;font-size:15px;padding:10px;height:40px;width:300px" onkeyup="checkPassword();checkRegister()" required></br>
                <text id="passwordError" name="passwordError" style="color:red;margin-left:45%;margin-right:auto;width:300px;font-size:15px;display:block"></text></br>
                <text id="retypeText" name="retypeText" style="margin-left:26%;float:left;margin-top:15px;margin-right:auto;width:150px;display:block">Retype Password</text>
                <input type="password" id="retypeInput" name="retypeInput" style="background-color:#D9D9D9;border-radius:15px;border:0px;font-size:15px;padding:10px;height:40px;width:300px" onkeyup="checkPassword();checkRegister()" required></br>
                <text id="retypeError" name="retypeError" style="color:red;margin-left:45%;margin-right:auto;width:300px;font-size:15px;display:block"></text></br>
                <text id="contactText" name="contactText" style="margin-left:26%;float:left;margin-top:15px;margin-right:auto;width:150px;display:block">Contact No.</text>
                <input type="text" id="contactInput" name="contactInput" style="background-color:#D9D9D9;border-radius:15px;border:0px;font-size:15px;padding:10px;height:40px;width:300px" onkeyup="checkContact();checkRegister()" onkeypress="return /[0-9]/i.test(event.key)" required></br>
                <text id="contactError" name="contactError" style="color:red;margin-left:45%;margin-right:auto;width:300px;font-size:15px;display:block"></text></br>
                <input type="button" class="buttonEffects" id="backButton" name="backButton" value="Back" style="margin-left:40%;margin-right:auto;float:left;width:100px;height:30px;font-size:15px;text-align:center;display:block" onclick="backFunction()">
                <input type="button" class="buttonEffects" id="registerButton" name="registerButton" value="Register" style="margin-left:55%;margin-right:auto;width:100px;height:30px;font-size:15px;text-align:center;display:block" onclick="registerFunction();">
                <div class="popup">
                    <span class="popuptext" id="myPopup" style="align-items:center;justify-content:flex-end;font-size:30px;" hidden>
                    <img src="../MoshiQ2 IMG Assets/Unsuccessful.png">
                    Error, unable to register account
                    <input type="button" id="returnButton" name="returnButton" value="Return" style="background-color:#4F4F4F;border-radius:10px;border:0px;color:white;height:40px;font-size:15px;width:90%;margin-left:auto;margin-right:auto" onclick="returnFunction()" onmouseover="mouseOver()" onmouseout="mouseOut()">
                    </span></br>
                </div>
            </div>
        </form>
    </body>
</html>