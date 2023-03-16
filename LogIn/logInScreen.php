<?php
require_once("accountDB.php");
?>
<!DOCTYPE html>
<html>
    <script>
        function wrongFunction(){
            document.getElementById("myPopup").style.visibility = 'visible';
        }

        function returnFunction(){
            document.getElementById("myPopup").style.visibility = 'hidden';
        }

        function mouseOver(){
            document.getElementById("returnButton").style.border = "2px solid black";
            document.getElementById("returnButton").style.borderColor = "black";
        }

        function mouseOut(){
            document.getElementById("returnButton").style.border = "0px";
            document.getElementById("returnButton").style.borderColor = "";
        }

        function signUpFunction(){
            window.location.href = "../LogIn/registerAccount.php";
        }

        function checkLogIn(){
            var slotArrays = '<?php echo json_encode($dataArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
            var slotArray = slotArrays.split('].');
            var accountArray = [];
            var actualAccountArray = [];
            var x;
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
            for (x=0;x<actualAccountArray.length;x++)
            {
                if((document.getElementById("inputEmail").value).toLowerCase() == (actualAccountArray[x][3]).toLowerCase() &&
                    document.getElementById("inputPassword").value == actualAccountArray[x][4] && 
                    document.getElementById("selectProfile").value.toLowerCase() == actualAccountArray[x][1].toLowerCase()){
                    checkTOF = true;
                    if (actualAccountArray[x][6].toLowerCase() != "suspended"){
                        var emailCookieText = document.getElementById("inputEmail").value.toLowerCase();
                        setCookie("email", emailCookieText, 1);

                        var passwordCookieText = document.getElementById("inputPassword").value;
                        setCookie("password", passwordCookieText, 1);
                        setCookie("fullName", actualAccountArray[x][2], 1);
                        setCookie("accountID", actualAccountArray[x][0], 1);
                        setCookie("number", actualAccountArray[x][5], 1);
                        
                        if(actualAccountArray[x][1].toLowerCase() == "customer"){
                            window.location.href = "../customer/customer_landingPage.php";
                        }
                        else if(actualAccountArray[x][1].toLowerCase() == "admin"){
                            window.location.href = "../admin/admin_homepage.php";
                        }
                        else if(actualAccountArray[x][1].toLowerCase() == "staff"){
                            window.location.href = "../staff/staff_homepage.php";
                        }
                        else if(actualAccountArray[x][1].toLowerCase() == "owner"){
                            window.location.href = "../owner/owner_homepage.php";
                        }
                        break;
                    }
                    else{
                        document.getElementById("myPopup").style.visibility = "visible";
                        break;
                    }
                }
                else{
                    checkTOF = false;
                }
            }    
            if(checkTOF == false){
                document.getElementById("myPopup").style.visibility = "visible";
            }       
        }

        function setCookie(nameCookie, valueCookie, timeCookie){
            const date = new Date();
            date.setTime(date.getTime() +  (timeCookie * 24 * 60 * 60 * 1000));
            let expires = "expires=" + date.toUTCString();
            document.cookie = `${nameCookie}=${valueCookie}; ${expires}; path=/`
        }

        function deleteCookie(nameOfCookie){
            setCookie(nameOfCookie, null, null);
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
          margin-left: auto;
          margin-right: auto;
          width: 100px;
          height: 30px;
          font-size: 15px;
          text-align: center;
          display: block;
        }
        .buttonEffects:hover {
                border: 2px solid black;
                cursor:pointer;
        }
    </style>
    <body style="background-color:#FEF2E5;">
        <form>
            <table style="margin-left:auto;margin-right:auto;width:800px;display:block">
                <td style="width:800px;">
                <a href="../index.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="margin-left:auto;margin-right:auto;width:500px;height:200px;display:block"></a>
                <text id="signInPrompt" name="singInPrompt" style="background-color:#E2B9B6;border-radius:5px;width:300px;margin-left:auto;margin-right:auto;font-size:20px;display:block"><center>Please sign-in to start ordering!</center></text></br></br>
                <text id="welcomeText" name="welcomeText" style="margin-left:auto;margin-right:auto;width:250px;font-size:30px;display:block">WELCOME BACK</text></br></br>
                <center><label  style="font-size:20px;display:inline-block">Log in as:</label>
                    <select id="selectProfile" style="margin-left:25px;width:150px;background-color:#A8A1A166;border:none;border-radius:5px;font-size:20px;cursor:pointer">
                        <option value="Customer">Customer</option>
                        <option value="Admin">Admin</option>
                        <option value="Staff">Staff</option>
                        <option value="Owner">Owner</option>
                    </select></center></br></br>
                <text id="emailText" name="emailText" style="margin-left:auto;margin-right:auto;width:250px;font-size:15px;display:block">Email Address</text>
                <input type="text" id="inputEmail" name="inputEmail" style="background-color:#D9D9D9;border-radius:15px;border:0px;margin-left:auto;margin-right:auto;width:250px;height:30px;padding:20px;font-size:15px;display:block" placeholder="Enter your email"></br>
                <text id="passwordText" name="passwordText" style="margin-left:auto;margin-right:auto;width:250px;font-size:15px;display:block">Password</text>
                <input type="password" id="inputPassword" name="inputPassword" style="background-color:#D9D9D9;border-radius:15px;border:0px;margin-left:auto;margin-right:auto;width:250px;height:30px;padding:20px;font-size:15px;display:block" placeholder="Enter your password"></br></br>
                <input type="button" class="buttonEffects" id="logInButton" name="logInButton" value="Log In" onclick="checkLogIn()"></br>
                <text id="orText" name="orText" style="margin-left:auto;margin-right:auto;width:20px;display:block">OR</text></br>
                <input type="button" class="buttonEffects" id="signUpButton" name="signUpButton" value="Sign Up" onclick="signUpFunction()"></br>
                <div class="popup">
                    <span class="popuptext" id="myPopup" style="align-items:center;display:flex;justify-content:flex-end;font-size:30px;">
                    <img src="../MoshiQ2 IMG Assets/Unsuccessful.png">
                    Login error!
                    <input type="button" id="returnButton" name="returnButton" value="Return" style="background-color:#4F4F4F;border-radius:10px;border:0px;color:white;height:40px;font-size:15px;width:90%;margin-left:auto;margin-right:auto" onclick="returnFunction()" onmouseover="mouseOver()" onmouseout="mouseOut()">
                    </span></br>
                </div>
                </td>
            </table>
        </form>
    </body>
</html>