<?php
require_once('reservationDB.php');
require_once('promoDB.php');
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
  <script type="text/javascript">
    var pax;
    var paxType;
    var paxType1 = ["B1", "B2", "C1", "C2", "F1", "F2", "G1", "G2"];
    var paxType2 = ["A1", "A2", "A3", "A4", "D1", "D2", "D3", "D4", "E1", "E2", "E3", "E4", "H1", "H2", "H3", "H4"];
    var allButtons = ["A1", "A2", "A3", "A4", "B1", "B2", "C1", "C2", "D1", "D2", "D3", "D4",
                      "E1", "E2", "E3", "E4", "F1", "F2", "G1", "G2", "H1", "H2", "H3", "H4",
                      "I1", "I2", "I3", "I4", "I5", "I6", "I7", "I8",
                      "J1", "J2", "J3", "J4", "J5", "J6", "J7", "J8"];

    //For storing reservation details in database
    var customerID;
    var customerName;
    var emailAddress;
    var phoneNumber;
    var outletLocation;
    var dateSlot;
    var timeSlot;
    var paxAmount;
    var seatingArea;
    var discountCode;
    var item_1;
    var item_2;
    var item_3;
    var item_4;
    var item_5;
    var timerCounter;
    var reservationNumID;
    var preorderList = [];
    var checkSeat = [];
    var editPax;
    var checkDate;
    var checkTime;
    var checkLocation;

    $(function(){
      //Set date to current date + 4, prevent user from selecting previous dates
      var currentDate = new Date();
      var numberOfDaysToAdd = 4;
      currentDate.setDate(currentDate.getDate() + numberOfDaysToAdd);
      var day = String(currentDate.getDate()).padStart(2, '0');
      var month = String(currentDate.getMonth() + 1).padStart(2, '0');
      var year = currentDate.getFullYear();

      currentDate = year + '-' + month + '-' + day;
      $('#dateSelect').attr('min',currentDate);
      $('#dateSelect').attr('value',currentDate);
    });

    function selectedPax(){
      uncheckElements();
      pax = document.getElementById("pax").value;
      var tempDate = document.getElementById("dateSelect").value;
      var tempTime = document.getElementById("timeSelect").value;
      var tempLocation = document.getElementById("outletLocation").value;
      for (var i=0; i<allButtons.length;i++){
        document.getElementById(allButtons[i]).disabled = true;
        if (pax == "1" || pax =="2"){
          paxType = 1;
          for (var j=0; j<paxType1.length;j++){
            document.getElementById(paxType1[j]).disabled = false;
          }
        }
        else if (pax == "3" || pax =="4"){
          paxType = 2;
          for (var j=0; j<paxType2.length;j++){
            document.getElementById(paxType2[j]).disabled = false;
          }
        }
        else if (pax == "5"){
          paxType = 3;
            document.getElementById(allButtons[i]).disabled = false;
        }
        else{
          paxType = 4;
        }
      }
      if (paxType == 1){
        document.getElementById("B").disabled = false;
        document.getElementById("C").disabled = false;
        document.getElementById("F").disabled = false;
        document.getElementById("G").disabled = false;
        document.getElementById("A").disabled = true;
        document.getElementById("D").disabled = true;
        document.getElementById("E").disabled = true;
        document.getElementById("H").disabled = true;
        document.getElementById("I").disabled = true;
        document.getElementById("J").disabled = true;
      }
      else if (paxType == 2){
        document.getElementById("A").disabled = false;
        document.getElementById("D").disabled = false;
        document.getElementById("E").disabled = false;
        document.getElementById("H").disabled = false;
        document.getElementById("I").disabled = true;
        document.getElementById("J").disabled = true;
        document.getElementById("B").disabled = true;
        document.getElementById("C").disabled = true;
        document.getElementById("F").disabled = true;
        document.getElementById("G").disabled = true;
      }
      else if (paxType == 3){
        document.getElementById("A").disabled = false;
        document.getElementById("B").disabled = false;
        document.getElementById("C").disabled = false;
        document.getElementById("D").disabled = false;
        document.getElementById("E").disabled = false;
        document.getElementById("F").disabled = false;
        document.getElementById("G").disabled = false;
        document.getElementById("H").disabled = false;
        document.getElementById("I").disabled = false;
        document.getElementById("J").disabled = false;
      }
      else{
        document.getElementById("A").disabled = true;
        document.getElementById("B").disabled = true;
        document.getElementById("C").disabled = true;
        document.getElementById("D").disabled = true;
        document.getElementById("E").disabled = true;
        document.getElementById("F").disabled = true;
        document.getElementById("G").disabled = true;
        document.getElementById("H").disabled = true;
        document.getElementById("I").disabled = true;
        document.getElementById("J").disabled = true;
      }

      if(pax == editPax && tempDate == checkDate && tempTime == checkTime && tempLocation == checkLocation){
        for(var z=0;z<checkSeat.length;z++){
            seatingCluster = document.getElementsByClassName("seat"+checkSeat[z]);
            document.getElementById(checkSeat[z]).disabled = false;
            document.getElementById(checkSeat[z]).checked = true;
            for(var j=0;j<seatingCluster.length;j++){
                seatingCluster[j].style.backgroundColor = '#7FFF00';
            }
        }
    }
      countDown();
    }

    var actualBookedArray = [];
    var boolCheck = false;
    function checkSlots(){
      actualBookedArray = [];
      var slotArrays = '<?php echo json_encode($reservationsArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
      var slotArray = slotArrays.split('].');
      var bookedArray = [];
      var x;
      var tempString = "";
      var tempString1 = "";
      var tempLocation = document.getElementById("outletLocation").value;
      var tempDate = document.getElementById("dateSelect").value;
      var tempTime = document.getElementById("timeSelect").value;
      for (x=0;x<slotArray.length;x++)
      {
        bookedArray.push(slotArray[x]);
      }
      for (x=0;x<bookedArray.length;x++){
        tempString = String(bookedArray[x]).replaceAll('[','').replaceAll(']','');
        tempString = tempString.split(',');
        actualBookedArray.push(tempString);
      }
      for (x=0;x<actualBookedArray.length;x++)
      {
        if (actualBookedArray[x][6] == tempDate && actualBookedArray[x][7] == tempTime && 
        actualBookedArray[x][5]==tempLocation && actualBookedArray[x][0]!=String(document.getElementById("accountReservationID").value)){        
          var seating = actualBookedArray[x][9];
          var seatingCluster;
          for (var i=0; i<seating.length; i++){
            seatingCluster = document.getElementsByClassName("seat"+seating[i]);
            document.getElementById(seating[i]).disabled = true;
            for (var j=0; j<seatingCluster.length; j++){
              seatingCluster[j].style.backgroundColor = '#FF0000';
            }
          }
        }
      }
      countDown();
    }

    function selectedArea(){
      pax = document.getElementById("pax").value;
      var seating = document.getElementsByClassName("seatingArea");
      var seatings = "";
      var seatingCluster;
      var checking = 0;

      for (var i=0; i<seating.length; i++){
        if(paxType!=3){
          if(paxType==1){
            for (var j=0;j<seating.length;j++){
              if(seating[j].checked==true){
                checking = 1;
              }
              else{
                seating[j].disabled = true;
              }
              if(checking==0){
                document.getElementById('B').disabled = false;
                document.getElementById('C').disabled = false;
                document.getElementById('F').disabled = false;
                document.getElementById('G').disabled = false;
              }
            }            
          }
          if(paxType==2){
            for (var j=0;j<seating.length;j++){
              if(seating[j].checked==true){
                checking = 1;
              }
              else{
                seating[j].disabled = true;
              }
              if(checking==0){
                document.getElementById('A').disabled = false;
                document.getElementById('D').disabled = false;
                document.getElementById('E').disabled = false;
                document.getElementById('H').disabled = false;
              }
            } 
          }
        }
    
        if(seating[i].checked){
            seatings += seating[i].value;
            seatingCluster = document.getElementsByClassName("seat"+seating[i].value);
            for(var j=0;j<seatingCluster.length;j++){
                seatingCluster[j].style.backgroundColor = '#7FFF00';
            }
        }
        else{
            seatingCluster = document.getElementsByClassName("seat"+seating[i].value);
            for(var j=0;j<seatingCluster.length;j++){
                seatingCluster[j].style.backgroundColor = '';
            }
        }
    }
      seatingArea = seatings;
      console.log(seatingArea);
      checkSlots();
      countDown();
    }

    function uncheckElements(){
      var uncheck=document.getElementsByClassName("seatingArea");
      for (var i=0; i<uncheck.length; i++){
        uncheck[i].checked=false;
      }
      countDown();
    }

    function submittedDetails(){
      customerID = getCookie("accountID");
      customerName = document.getElementById('name').value;
      emailAddress = document.getElementById('emailAddress').value;
      phoneNumber = document.getElementById('phoneNumber').value;
      outletLocation = document.getElementById('outletLocation').value;
      dateSlot = document.getElementById('dateSelect').value;
      timeSlot = document.getElementById('timeSelect').value;
      paxAmount = document.getElementById('pax').value;
      applyPromoCode();
      if (checkDiscount == ""){
        discountCode = "none";
      }
      else{
        discountCode = checkDiscount; 
      } 

      document.getElementById('displaySubjectType').innerHTML = "Reservation";
      document.getElementById('displayReservationID').innerHTML = parseInt(document.getElementById("accountReservationID").value);
      document.getElementById('displayCustomerName').innerHTML = customerName;
      document.getElementById('displayCustomerEmailAddress').innerHTML = emailAddress;
      document.getElementById('displayCustomerPhoneNumber').innerHTML = phoneNumber;
      document.getElementById('displayCustomerOutletLocation').innerHTML = outletLocation;
      document.getElementById('displayCustomerDateSlot').innerHTML = dateSlot;
      document.getElementById('displayCustomerTimeSlot').innerHTML = timeSlot;
      document.getElementById('displayCustomerPaxAmount').innerHTML = paxAmount;
      document.getElementById('displayCustomerSeatingArea').innerHTML = seatingArea;
      document.getElementById('displayCustomerDiscountCode').innerHTML = discountCode;

      var getPreorder = document.getElementsByClassName("preorderItems");
      for (var i=0; i<getPreorder.length; i++){
        if (getPreorder[i].checked){
          preorderList.push(getPreorder[i].value);
        }
        else{
          preorderList.push("none");
        }
      }

      item_1 = preorderList[0];
      item_2 = preorderList[1];
      item_3 = preorderList[2];
      item_4 = preorderList[3];
      item_5 = preorderList[4];   

      document.getElementById('item_1').innerHTML = item_1;
      document.getElementById('item_2').innerHTML = item_2;
      document.getElementById('item_3').innerHTML = item_3;
      document.getElementById('item_4').innerHTML = item_4;
      document.getElementById('item_5').innerHTML = item_5;

      $.ajax({
        type: "POST",
        url: "edit_reservation_details.php",
        data:{
          displayReservationID:parseInt(document.getElementById("accountReservationID").value),
          displayCustomerName:customerName,
          displayCustomerEmailAddress:emailAddress,
          displayCustomerPhoneNumber:phoneNumber,
          displayCustomerOutletLocation:outletLocation,
          displayCustomerDateSlot:dateSlot,
          displayCustomerTimeSlot:timeSlot,
          displayCustomerPaxAmount:paxAmount,
          displayCustomerSeatingArea:seatingArea,
          displayCustomerDiscountCode:discountCode,
          item_1:item_1,
          item_2:item_2,
          item_3:item_3,
          item_4:item_4,
          item_5:item_5
        },
        success: function(data){
          Swal.fire({
            'title': 'Successfully submitted reservation details!',
            'text': data,
            'type': 'success'
          }).then(setTimeout(function(){window.location.replace("../customer/accountDetails.php");}, 2000))
        },
        error: function(data){
          Swal.fire({
            'title': 'Errors',
            'text': 'There were errors in your booking, please refresh the page and try again.'
          })
        }
      });

      var displayMessage = "Dear " + customerName + ", \r\n" +
                            "Attached are your reservation details: \r\n" +
                            "Name: " + customerName + "\r\n" + 
                            "Email Address: " + emailAddress + "\r\n" + 
                            "Phone Number: " + phoneNumber + "\r\n" + 
                            "Outlet Location: " + outletLocation + "\r\n" + 
                            "Date: " + dateSlot + "\r\n" + 
                            "Time: " + timeSlot + "\r\n" + 
                            "Amount of people: " + paxAmount + "\r\n" + 
                            "Seating area: " + seatingArea + "\r\n" + 
                            "Discount code: " + discountCode + "\r\n" + 
                            "Pre-order item 1: " + item_1 + "\r\n" + 
                            "Pre-order item 2: " + item_2 + "\r\n" + 
                            "Pre-order item 3: " + item_3 + "\r\n" + 
                            "Pre-order item 4: " + item_4 + "\r\n" + 
                            "Pre-order item 5: " + item_5;

      var displaySubjectType = "Reservation";

      var tempSeatArea;
      if (seatingArea.length > 1){
        tempSeatArea = "";
        for (var i=0; i < seatingArea.length; i++){
          if (i+1 == seatingArea.length){
            tempSeatArea += seatingArea[i];
          }
          else{
            tempSeatArea += seatingArea[i] + ", ";
          }
        }
      }
      else{
        tempSeatArea = seatingArea;
      }

      var tempTiming;
      switch(timeSlot){
        default:
          tempTiming = "Error in retrieving timing";
          break;
        case "timeSlot1":
          tempTiming = "11:00";
          break;
        case "timeSlot2":
          tempTiming = "12:00";
          break;
        case "timeSlot3":
          tempTiming = "13:00";
          break;
        case "timeSlot4":
          tempTiming = "14:00";
          break;
        case "timeSlot5":
          tempTiming = "15:00";
          break;
        case "timeSlot6":
          tempTiming = "16:00";
          break;
        case "timeSlot7":
          tempTiming = "17:00";
          break;
        case "timeSlot8":
          tempTiming = "18:00";
          break;
        case "timeSlot9":
          tempTiming = "19:00";
          break;
        case "timeSlot10":
          tempTiming = "20:00";
          break;
      }

      var tempPax;
      if (paxAmount == "5"){
        tempPax = "5+";
      }
      else{
        tempPax = paxAmount;
      }

      reservationNumID = document.getElementById('displayReservationID').value;
      
      var inboxDescription = "(Edited)R" + String(parseInt(reservationNumID)) +
                              ": Reservation for " + customerName +
                              "~~ at " + dateSlot.replaceAll('-','/')+ 
                              "~~ " + tempTiming + "~~ for " + tempPax +
                              "(" + tempSeatArea.replaceAll(",", "~~") + ")";
      var inboxDate = String(new Date().toJSON().slice(0,10).replace(/-/g,'/'));

      $.ajax({
        type: "POST",
        url: "inbox_details_data.php",
        data:{
          inboxStatus:inboxStatus,
          inboxDescription:inboxDescription,
          inboxDate:inboxDate
        }
      });

      var params = {
        displaySubjectType: displaySubjectType,
        reservationID: reservationNumID,
        customerName: customerName,
        emailAddress: emailAddress,
        phoneNumber: phoneNumber,
        outletLocation: outletLocation,
        dateSlot: dateSlot,
        timeSlot: tempTiming,
        paxAmount: tempPax,
        seatingArea: tempSeatArea,
        discountCode: discountCode,
        item_1: item_1,
        item_2: item_2,
        item_3: item_3,
        item_4: item_4,
        item_5: item_5
      };

      const serviceID = "service_f6ewb26";
      const templateID = "template_0rrz30s";

      //Send email
      emailjs.send(serviceID, templateID, params).then(res=>{
          console.log(res);
      })
      .catch(err=>console.log(err));

      params = {
        displaySubjectType: displaySubjectType,
        reservationID: reservationNumID,
        customerName: customerName,
        emailAddress: "fyp22s3@gmail.com",
        phoneNumber: phoneNumber,
        outletLocation: outletLocation,
        dateSlot: dateSlot,
        timeSlot: tempTiming,
        paxAmount: tempPax,
        seatingArea: tempSeatArea,
        discountCode: discountCode,
        item_1: item_1,
        item_2: item_2,
        item_3: item_3,
        item_4: item_4,
        item_5: item_5
      };

      emailjs.send(serviceID, templateID, params).then(res=>{
          console.log(res);
      })
      .catch(err=>console.log(err));
      countDown();
    }

    function clearSelection(){
      var uncheck=document.getElementsByClassName("preorderItems");
      for (var i=0; i<uncheck.length; i++){
        uncheck[i].checked=false;
      }
      countDown();
    }

    function profileDetails(){
        var tempLogInID = getCookie("reservationID");
        document.getElementById("accountReservationID").value = tempLogInID;
        inputAllFields();
        countDown();
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

    function inputAllFields(){
        var slotArrays = '<?php echo json_encode($reservationsArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
        var slotArray = slotArrays.split('].');
        var bookedArray = [];
        var x;
        var tempString = "";
        var tempString1 = "";
        var tempArray = [];
        var tempLocation = document.getElementById("outletLocation").value;
        var tempDate = document.getElementById("dateSelect").value;;
        var tempTime = document.getElementById("timeSelect").value;;
        for (x=0;x<slotArray.length;x++)
        {
            bookedArray.push(slotArray[x]);
        }
        for (x=0;x<bookedArray.length;x++){
            tempString = String(bookedArray[x]).replaceAll('[','').replaceAll(']','');
            tempString = tempString.split(',');
            tempArray.push(tempString);
        }
        for (x=0;x<tempArray.length;x++){
            if(String(tempArray[x][0]) == String(document.getElementById("accountReservationID").value)){
                document.getElementById('name').value = tempArray[x][2];
                document.getElementById('emailAddress').value = tempArray[x][3];
                document.getElementById('phoneNumber').value = tempArray[x][4];
                document.getElementById('outletLocation').value = tempArray[x][5];
                document.getElementById('dateSelect').value = tempArray[x][6];
                document.getElementById('timeSelect').value = tempArray[x][7];
                document.getElementById('pax').value = tempArray[x][8];
                document.getElementById('applyPromo').value = tempArray[x][10];
                
                editPax = tempArray[x][8];
                checkDate = tempArray[x][6];
                checkTime = tempArray[x][7];
                checkLocation = tempArray[x][5];
                var seating = tempArray[x][9];
                var seatingCluster;
                for (var i=0; i<seating.length; i++){
                    seatingCluster = document.getElementsByClassName("seat"+seating[i]);
                    //document.getElementById(seating[i]).disabled = true;
                    checkSeat.push(seating[i]);
                    /*for (var j=0; j<seatingCluster.length; j++){
                    seatingCluster[j].style.backgroundColor = '#7FFF00';
                    }*/
                }
                for(var z=0;z<checkSeat.length;z++){
                    seatingCluster = document.getElementsByClassName("seat"+checkSeat[z]);
                    document.getElementById(checkSeat[z]).disabled = false;
                    document.getElementById(checkSeat[z]).checked = true;
                    for(var j=0;j<seatingCluster.length;j++){
                        seatingCluster[j].style.backgroundColor = '#7FFF00';
                    }
                }
                for(var z=11; z<=15;z++){
                  if(tempArray[x][z] != "none"){
                    document.getElementById("item"+String(z-10)).checked = true;
                  }
                }
                break;
            }    
        }
        selectedArea();
    }

    function enableSubmitButton(){
      var requiredField1 = document.getElementById('name').value;
      var requiredField2 = document.getElementById('emailAddress').value;
      var requiredField3 = document.getElementById('phoneNumber').value;
      var requiredField4 = document.getElementById('outletLocation').value;
      var requiredField5 = document.getElementById('dateSelect').value;
      var requiredField6 = document.getElementById('timeSelect').value;
      var requiredField7 = document.getElementById('pax').value;
      var requiredField8 = seatingArea;

      if(requiredField1 == "" || requiredField2 == "" || requiredField3 == "" || requiredField4 == "" || requiredField5 == "" || 
        requiredField6 == "" || requiredField7 == "" || requiredField8 == null || requiredField8 == ""){
          document.getElementById('submitDetails').disabled = true;
          document.getElementById('submitDetails').style.cursor = "default";
      }
      else{
        document.getElementById('submitDetails').disabled = false;
        document.getElementById('submitDetails').style.cursor = "pointer";
      }
      countDown();
    }

    var checkDiscount;
    function applyPromoCode(){
      var slotArrays = '<?php echo json_encode($promoArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
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
        if (actualPromoCodeArray[x][0] == tempPromoCode)
        {        
          checkDiscount = actualPromoCodeArray[x][0];
          document.getElementById("validityText").innerHTML = "Valid";
          document.getElementById("validityText").style.color = "green";
          console.log("Promo Code is valid");
          break;
        }
        else if(tempPromoCode == "" || tempPromoCode == null){
          checkDiscount = "none";
          document.getElementById("validityText").innerHTML = "";
          console.log("Promo Code is empty");
        }
        else{
          checkDiscount = "none";
          document.getElementById("validityText").innerHTML = "Invalid";
          document.getElementById("validityText").style.color = "red";
          console.log("Promo Code is invalid");
        }
      }
      countDown();
    }

    var actualBookedArray1 = [];
    function countTotalReservations(){
      
      var slotArrays = '<?php echo json_encode($reservationsArray);?>'.replaceAll('[[','[').replaceAll(']]',']').replaceAll('],',']].').replaceAll('"',"");
      var slotArray = slotArrays.split('].');
      var bookedArray = [];
      var x;
      var tempString = "";
      var tempString1 = "";
      var tempLocation = document.getElementById("outletLocation").value;
      var tempDate = document.getElementById("dateSelect").value;;
      var tempTime = document.getElementById("timeSelect").value;;
      for (x=0;x<slotArray.length;x++)
      {
        bookedArray.push(slotArray[x]);
      }
      for (x=0;x<bookedArray.length;x++){
        tempString = String(bookedArray[x]).replaceAll('[','').replaceAll(']','');
        tempString = tempString.split(',');
        actualBookedArray1.push(tempString);
      }
      var reservationCount;
      if(actualBookedArray1.length != 0 && actualBookedArray1[actualBookedArray1.length-1] != ""){
        reservationCount = actualBookedArray1.length;
      }
      else{
        reservationCount = 0;
      }
      document.getElementById("reservationCount").innerHTML = reservationCount;
    }

    var myVar;
    function timerFunction(duration, display){
      var timer = duration, minutes, seconds;
      myVar = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
          window.location.href = "edit_reservation.php";
        }
      }, 1000);
    }

    function countDown(){
      var fiveMinutes = 60 * 5,
      display = document.querySelector('#reservationTimer');
      clearTimeout(myVar);
      timerFunction(fiveMinutes, display);
    }

    function backButton(){
      window.location.href = "../customer/accountDetails.php";
    }
  </script>

  <style>
  .outdoorViewLeft{
    display: inline-block;
    transform: rotate(-90deg);
    margin-top: 20px;
  }

  .outdoorViewRight{
    display: inline-block;
    transform: rotate(90deg);
    margin-top: 20px;
  }
  </style>

  <body style="background-color:#FEF2E5;" onload="profileDetails();enableSubmitButton();countTotalReservations();countDown();">
    <div style="width:700px;margin-left:auto;margin-right:auto;">
    <a href="../customer/customer_landingPage.php"><img src="../MoshiQ2 IMG Assets/Logo.png" style="width:300px;margin-left:auto;margin-right:auto;width:500px;display:block"></a></br>
      <div style="">
        <p style="margin-left:15%;font-size:12px">Total reservations made: <text id="reservationCount"></text></p>
        <p style="margin-left:15%;font-size:20px;background-color:#C3E3A2;width:69%;padding:5px;border-radius:5px">Your page will be refreshed when inactive in...  <text id="reservationTimer" name="reservationTimer" style="float:right;">05:00</text></p>
        <p style="text-align:center;"><b>Reserve a place! Enjoy the ambience!</b></p>
      </div>
    <form action="edit_reservation_details.php/" method="POST">
      <fieldset style="width:454px;margin:auto;">
      <fieldset style="width:434px">
        <legend style="color:black">Enter personal details</legend>
        <text style="color:black;width:100px;display:inline-block">Reservation ID</text><span style="margin-left:10px;display:inline-block">:</span><input id="accountReservationID" type="text" style="display:inline-block;margin-left:10px" disabled><br>
        <text style="color:black;width:100px;display:inline-block">Name</text><span style="margin-left:10px;display:inline-block">:</span><input id="name" style="margin-top:5px;margin-left:10px" type="text" onchange="enableSubmitButton()" onkeyup="enableSubmitButton()" onkeydown="enableSubmitButton()"><br>
        <text style="color:black;width:100px;display:inline-block">Email address</text><span style="margin-left:10px;display:inline-block">:</span><input id="emailAddress" style="margin-top:5px;margin-left:10px" type="email" onchange="enableSubmitButton()" onkeyup="enableSubmitButton()" onkeydown="enableSubmitButton()"><br>
        <text style="color:black;width:100px;display:inline-block">Phone number</text><span style="margin-left:10px;display:inline-block">:</span><input id="phoneNumber" style="margin-top:5px;margin-left:10px" type="text" onkeypress="return /[0-9]/i.test(event.key)" onchange="enableSubmitButton()" onkeyup="enableSubmitButton()" onkeydown="enableSubmitButton()"><br>
      </fieldset><br>

      <fieldset style="width:434px">
        <legend style="color:black">Select Outlet</legend>
        <text style="color:black">Location: </text><select name="outletLocation" id="outletLocation" style="width:120px;text-align:center" onchange="selectedPax();selectedArea();enableSubmitButton()">
          <option value="CHANGI">Changi</option>
          <option value="TAMPINES">Tampines</option>
          <option value="KALLANG">Kallang</option>
          <option value="SENTOSA">Sentosa</option>
          <option value="YISHUN">Yishun</option>
        </select>
      </fieldset><br>

      <fieldset style="width:434px">
        <legend style="color:black">Select Date, Timeslot and Pax amount</legend>
        <text style="color:black">Date : </text><input id="dateSelect" type="date" onchange="selectedPax();selectedArea()"><br><br>
        <text style="color:black">Time slot: </text><select name="timeSelect" id="timeSelect" style="width:60px;text-align:center" onchange="selectedPax();selectedArea();enableSubmitButton()">
          <option value="timeSlot1">11:00</option>
          <option value="timeSlot2">12:00</option>
          <option value="timeSlot3">13:00</option>
          <option value="timeSlot4">14:00</option>
          <option value="timeSlot5">15:00</option>
          <option value="timeSlot6">16:00</option>
          <option value="timeSlot7">17:00</option>
          <option value="timeSlot8">18:00</option>
          <option value="timeSlot9">19:00</option>
          <option value="timeSlot10">20:00</option>
        </select><br><br>
        <text style="color:black">Amount of people: </text><select name="pax" id="pax" style="width:60px;text-align:center" onclick="selectedPax();selectedArea();enableSubmitButton()" onchange="selectedPax();selectedArea();enableSubmitButton()">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5+</option>
        </select>
      </fieldset><br>

      <fieldset style="width:434px">
        <legend style="color:black">Please select seating area(s)</legend>
        <input type="checkbox" id="A" class="seatingArea" name="A" value="A" onclick="selectedArea();enableSubmitButton()"/><label for="A" onchange="enableSubmitButton()">A</label><br>
        <input type="checkbox" id="B" class="seatingArea" name="B" value="B" onclick="selectedArea();enableSubmitButton()"/><label for="B" onchange="enableSubmitButton()">B</label><br>
        <input type="checkbox" id="C" class="seatingArea" name="C" value="C" onclick="selectedArea();enableSubmitButton()"/><label for="C" onchange="enableSubmitButton()">C</label><br>
        <input type="checkbox" id="D" class="seatingArea" name="D" value="D" onclick="selectedArea();enableSubmitButton()"/><label for="D" onchange="enableSubmitButton()">D</label><br>
        <input type="checkbox" id="E" class="seatingArea" name="E" value="E" onclick="selectedArea();enableSubmitButton()"/><label for="E" onchange="enableSubmitButton()">E</label><br>
        <input type="checkbox" id="F" class="seatingArea" name="F" value="F" onclick="selectedArea();enableSubmitButton()"/><label for="F" onchange="enableSubmitButton()">F</label><br>
        <input type="checkbox" id="G" class="seatingArea" name="G" value="G" onclick="selectedArea();enableSubmitButton()"/><label for="G" onchange="enableSubmitButton()">G</label><br>
        <input type="checkbox" id="H" class="seatingArea" name="H" value="H" onclick="selectedArea();enableSubmitButton()"/><label for="H" onchange="enableSubmitButton()">H</label><br>
        <input type="checkbox" id="I" class="seatingArea" name="I" value="I" onclick="selectedArea();enableSubmitButton()"/><label for="I" onchange="enableSubmitButton()">I</label><br>
        <input type="checkbox" id="J" class="seatingArea" name="J" value="J" onclick="selectedArea();enableSubmitButton()"/><label for="J" onchange="enableSubmitButton()">J</label><br>
      </fieldset><br>

      <fieldset style="width:434px">
        <legend style="color:black">Selected area(s)</legend>
        <text style="color:red">Red indicates taken seating area(s)</text></br>
        <text style="color:green">Green indicates your chosen seating area(s)</text></br>
        <text style="color:grey">Light grey indicates the available seating area(s)</text></br></br>

        <table>
          <table>
            <tr>
              <td><input style="margin-left:74px" id="A1" type="button" class="seatA" value="A" disabled="true"></td>
              <td><input id="A2" type="button" value="A" class="seatA" disabled="true"></td>
              <td><input style="margin-left:16px" id="B1" type="button" class="seatB" value="B" disabled="true"></td>
              <td><input id="B2" type="button" value="B" class="seatB" disabled="true"></td>
              <td><input style="margin-left:16px" id="C1" type="button" class="seatC" value="C" disabled="true"></td>
              <td><input id="C2" type="button" value="C" class="seatC" disabled="true"></td>
              <td><input style="margin-left:16px" id="D1" type="button" class="seatD" value="D" disabled="true"></td>
              <td><input id="D2" type="button" value="D" class="seatD" disabled="true"></td>
            </tr>
          </table>

          <table>
            <tr>
              <td><text style="margin-left:68px" disabled="true"></td>
              <td><input style="margin-left:2px" id="A3" type="button" class="seatA" value="A" disabled="true"></td>
              <td><input id="A4" type="button" value="A" class="seatA" disabled="true"></td>
              <td><input style="margin-left:165px" id="D3" type="button" class="seatD" value="D" disabled="true"></td>
              <td><input id="D4" type="button" value="D" class="seatD" disabled="true"></td>
              <td><text style="margin-left:3px"></td>
            </tr>
          </table>

          <table>
            <tr style="margin-top:50px">
              <td><text class="outdoorViewLeft" style="margin-left:10px" id="verticalLeftOutdoor">Outdoor<br>
                <text id="verticalLeftView" style="margin-left:10px">view</td>
              <td><text style="margin-left:120px;" id="counter">Counter</td>
              <td><text class="outdoorViewRight" style="margin-left:120px" id="verticalRightOutdoor">Outdoor<br>
                <text id="verticalRightView" style="margin-left:10px">view</td>
            </tr>
          </table>

          <table style="margin-top:20px">
            <tr>
              <td><input style="margin-left:74px" id="E1" type="button" class="seatE" value="E" disabled="true"></td>
              <td><input id="E2" type="button" value="E" class="seatE" disabled="true"></td>
              <td><input style="margin-left:165px" id="H1" type="button" class="seatH" value="H" disabled="true"></td>
              <td><input id="H2" type="button" value="H" class="seatH" disabled="true"></td>
            </tr>
          </table>

          <table>
            <tr>
              <td><input style="margin-left:74px" id="E3" type="button" value="E" class="seatE" disabled="true"></td>
              <td><input id="E4" type="button" value="E" class="seatE" disabled="true"></td>
              <td><input style="margin-left:16px" id="F1" type="button" value="F" class="seatF" disabled="true"></td>
              <td><input id="F2" type="button" value="F" class="seatF" disabled="true"></td>
              <td><input style="margin-left:16px" id="G1" type="button" value="G" class="seatG" disabled="true"></td>
              <td><input id="G2" type="button" value="G" class="seatG" disabled="true"></td>
              <td><input style="margin-left:16px" id="H3" type="button" value="H" class="seatH" disabled="true"></td>
              <td><input id="H4" type="button" value="H" class="seatH" disabled="true"></td>
            </tr>
          </table>

          <table>
            <tr>
              <td><text style="margin-left:90px" id="empty"></td>
            </tr>
          </table>

          <table>
            <tr>
              <td><input style="margin-left:74px;width:25px" id="I1" type="button" value="I" class="seatI" disabled="true"></td>
              <td><input style="width:25px" id="I2" type="button" value="I" class="seatI" disabled="true"></td>
              <td><input style="width:25px" id="I3" type="button" value="I" class="seatI" disabled="true"></td>
              <td><input style="margin-left:108px;width:25px" id="J1" type="button" value="J" class="seatJ" disabled="true"></td>
              <td><input style="width:25px"id="J2" type="button" value="J" class="seatJ" disabled="true"></td>
              <td><input style="width:25px" id="J3" type="button" value="J" class="seatJ" disabled="true"></td>
            </tr>
          </table>

          <table>
            <tr>
              <td><input style="margin-left:74px;width:25px" id="I4" type="button" value="I" class="seatI" disabled="true"></td>
              <td><input style="margin-left:29px;width:25px" id="I5" type="button" value="I" class="seatI" disabled="true"></td>
              <td><input style="margin-left:108px;width:25px" id="J4" type="button" value="J" class="seatJ" disabled="true"></td>
              <td><input style="margin-left:29px;width:25px" id="J5" type="button" value="J" class="seatJ" disabled="true"></td>
            </tr>
          </table>

          <table>
            <tr>
              <td><input style="margin-left:74px;width:25px" id="I6" type="button" value="I" class="seatI" disabled="true"></td>
              <td><input style="width:25px" id="I7" type="button" value="I" class="seatI" disabled="true"></td>
              <td><input style="width:25px" id="I8" type="button" value="I" class="seatI" disabled="true"></td>
              <td><text style="margin-left:20px" id="entrance">|Entrance|</td>
              <td><input style="margin-left:21px;width:25px" id="J6" type="button" value="J" class="seatJ" disabled="true"></td>
              <td><input style="width:25px" id="J7" type="button" value="J" class="seatJ" disabled="true"></td>
              <td><input style="width:25px" id="J8" type="button" value="J" class="seatJ" disabled="true"></td>
            </tr>
          </table>       
        </table>
      </fieldset></br>

      <fieldset style="width:434px">
        <legend style="color:black">Pre-order</legend>
        <text style="color:black">Items in this section are at a discounted rate!</text></br></br>
        <input type="checkbox" id="item1" class="preorderItems" name="Hawaiian Salmon" value="Hawaiian Salmon"/><label for="Hawaiian Salmon" style="color:black">Hawaiian Salmon <s>(U.P. $15.50)</s> $15</label></br>
        <input type="checkbox" id="item2" class="preorderItems" name="Colourful Goddess" value="Colourful Goddess"/><label for="Colourful Goddess" style="color:black">Colourful Goddess <s>(U.P. $15.50)</s> $15</label></br>
        <input type="checkbox" id="item3" class="preorderItems" name="Shoyu Tuna Specials" value="Shoyu Tuna Specials"/><label for="Shoyu Tuna Specials" style="color:black">Shoyu Tuna Specials <s>(U.P. $12.80)</s> $11.90</label></br>
        <input type="checkbox" id="item4" class="preorderItems" name="Summer Fling" value="Summer Fling"/><label for="Summer Fling" style="color:black">Summer Fling <s>(U.P. $8.90)</s> $7.50</label></br>
        <input type="checkbox" id="item5" class="preorderItems" name="Spidey Senses" value="Spidey Senses"/><label for="Spidey Senses" style="color:black">Spidey Senses <s>(U.P. $5.60)</s> $4.90</label></br></br>
        <input type="button" id="clearSelected" name="clearSelected" value="Clear Selection" style="margin-left:auto;margin-right:auto;display:block" onclick="clearSelection();countDown()"></br>
      </fieldset>

      <fieldset style="width:434px">
        <legend style="color:black">Apply promocode</legend>
        <input type="text" id="applyPromo" style="width:200px;display:inline-block" onchange="countDown()">
        <input type="button" style="margin-left:5px;display:inline-block;width:100px;cursor:pointer" value="Apply" onclick="applyPromoCode()">
        <text id="validityText" style="margin-left:5px;"></text>
      </fieldset>

      <br><text id="showBookings" name="showBookings"></text>
      
      <p hidden>
        <br><text id="displaySubjectType" name="displaySubjectType"></text>
        <br><text id="displayReservationID" name="displayReservationID"></text>
        <br><text id="displayCustomerName" name="displayCustomerName"></text>
        <br><text id="displayCustomerEmailAddress" name="displayCustomerEmailAddress"></text>
        <br><text id="displayCustomerPhoneNumber" name="displayCustomerPhoneNumber"></text>
        <br><text id="displayCustomerOutletLocation" name="displayCustomerOutletLocation"></text>
        <br><text id="displayCustomerDateSlot" name="displayCustomerDateSlot"></text>
        <br><text id="displayCustomerTimeSlot" name="displayCustomerTimeSlot"></text>
        <br><text id="displayCustomerPaxAmount" name="displayCustomerPaxAmount"></text>
        <br><text id="displayCustomerSeatingArea" name="displayCustomerSeatingArea"></text>
        <br><text id="displayCustomerDiscountCode" name="displayCustomerDiscountCode"></text>
        <br><text id="item_1" name="item_1"></text>
        <br><text id="item_2" name="item_2"></text>
        <br><text id="item_3" name="item_3"></text>
        <br><text id="item_4" name="item_4"></text>
        <br><text id="item_5" name="item_5"></text>
      </p>
      <br><input type="button" style="float:left;margin-left:15%;width:30%;cursor:pointer" value="Back" onclick="backButton()"><input type="button" name="submitDetails" id="submitDetails" value="Update reservation" style="float:right;margin-right:15%;width:30%;" onclick="submittedDetails();return confirm('Are you sure?');">
    </form>
    </fieldset>
    </div>
  </body>
</html>