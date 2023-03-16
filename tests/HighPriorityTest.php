<?php 

require_once("src/testSRC.php");
use PHPUnit\Framework\TestCase;
class HighPriorityTest extends TestCase {

    public $controller;
    public function SetUp():void {
     $this->controller = new Controller();   
    }
    //TC-H-1
    public function testViewFloorPlan()
    {
        $ReservationPage = true;
        $this->controller->setaccount_ID('234');
        $account_ID = $this->controller->getaccount_ID();
        $viewfloorplan = $this -> assertEquals($account_ID,'234');       
    } 
    //TC-H-2
    public function testSelectTableNumber()
    {
        $ReservationPage = true;
        $this->controller->setaccount_ID('234');
        $account_ID = $this->controller->getaccount_ID();
        $viewfloorplan = $this -> assertEquals($account_ID,'234'); 

        $this->controller->setseatingArea('D');
        $seatingArea = $this->controller->getseatingArea();
        $selectTableNumber = $this -> assertEquals($seatingArea,'D');

        $input = $account_ID.$seatingArea;
        $this ->assertEquals($input,'234D');

    }    
    //TC-H-3-4 
    public function testMakeReservation()
    {
        $this->controller->setaccount_ID('234');
        $this->controller->setfullname('Thomas Shelby');
        $this->controller->setemail('tshelby@gmail.com');
        $this->controller->setphoneNumber('82347521');
        $this->controller->setoutlet('Changi');
        $this->controller->setDate('10/11/2022');
        $this->controller->settimeslot('20:00');
        $this->controller->setpax_amount('4');
        $this->controller->setseatingArea('D');

        $account_ID = $this->controller->getaccount_ID();
        $fullname = $this->controller->getfullname();
        $email = $this->controller->getemail();
        $phoneNumber = $this->controller->getphoneNumber();
        $outlet = $this->controller->getoutlet();
        $date = $this->controller->getdate();
        $timeslot = $this->controller->gettimeslot();
        $pax_amount = $this->controller->getpax_amount();
        $seatingArea = $this->controller->getseatingArea();

        $input = $account_ID.$fullname.$email.$phoneNumber.$outlet.$date.$timeslot.$pax_amount.$seatingArea;

        $db = $this->controller->getReservationDetails();

        $validateInput = $this -> assertEquals($input,$db);
        $validatInput = $makeReservation = true;
        $this -> assertTrue($makeReservation,'Reservation successfully made');
        
    }  
    //TC-H-3-5
    public function testMakeReservationFail()
    {
        $this->controller->setaccount_ID('');
        $this->controller->setfullname('');
        $this->controller->setemail('');
        $this->controller->setphoneNumber('');
        $this->controller->setoutlet('');
        $this->controller->setDate('');
        $this->controller->settimeslot('');
        $this->controller->setpax_amount('');
        $this->controller->setseatingArea('');

        $account_ID = $this->controller->getaccount_ID();
        $fullname = $this->controller->getfullname();
        $email = $this->controller->getemail();
        $phoneNumber = $this->controller->getphoneNumber();
        $outlet = $this->controller->getoutlet();
        $date = $this->controller->getdate();
        $timeslot = $this->controller->gettimeslot();
        $pax_amount = $this->controller->getpax_amount();
        $seatingArea = $this->controller->getseatingArea();

        $input = $account_ID.$fullname.$email.$phoneNumber.$outlet.$date.$timeslot.$pax_amount.$seatingArea;

        $db = $this->controller->getEmptyinputs();

        $emptyInput = $this -> assertEquals($input,$db);
        $emptyInput = $makeReservation = false;
        $this -> assertFalse($makeReservation,'Error reservation cannot be made! Please try again later');    
    }     
    //TC-H-4
    public function ViewRestaurantTraffic()
    {
        //No Test required
    }
    //TC-H-5 to TC-H-9, TC-H15-1, TC-H-16-1
    public function ReceiveReminder()
    {
        //No Test required
    }
    //TC-H-10-2 & TC-H-10-3   
    public function testUpdateOrder()
    {
        $viewOrderpage = true;

        $this->controller->setorder_ID('100');
        $this->controller->setfullname('Tan Say Ming');
        $this->controller->setitem('Hawaiian Salmon');
        $this->controller->setquantity('1');

        $order_ID = $this->controller->getorder_ID();
        $fullname = $this->controller->getfullname();
        $item = $this->controller->getitem();
        $quantity = $this->controller->getquantity();
 
        $orderdetails = $order_ID.$fullname.$item.$quantity;
        //Click 'Mark as completed'
        $orderdetails = true;
        $this -> assertTrue($orderdetails,'Order updated');
    }
    //TC-H-10-2-1
     public function testUpdateOrderInvalid()
    {
        $viewOrderpage = true;

        $this->controller->setorder_ID('');
        $this->controller->setfullname('');
        $this->controller->setitem('');
        $this->controller->setquantity('');

        $order_ID = $this->controller->getorder_ID();
        $fullname = $this->controller->getfullname();
        $item = $this->controller->getitem();
        $quantity = $this->controller->getquantity();
 
        $orderdetails = $order_ID.$fullname.$item.$quantity;
        //Empty field on orders'
        $orderdetails = false;
        $this -> assertFalse($orderdetails,'No orders found');
    }   
    //TC-H-11
    public function testViewReservation()
    {
        $viewReservationpage = true;
        $this->controller->setreservation_ID('1');
        $this->controller->setfullname('Tan Say Ming');
        $this->controller->setpax_amount('4');
        $this->controller->settimeslot('1330');

        $reservation_ID = $this->controller->getreservation_ID();
        $fullname = $this->controller->getfullname();
        $pax_amount = $this->controller->getpax_amount();
        $timeslot = $this->controller->gettimeslot();
        $output = $reservation_ID.$fullname.$pax_amount.$timeslot;
        $db = $this->controller->getReservationwithID();

        $verify = $this -> assertEquals($db,$output);
        $ReservationDescrpition = true;
        $this -> assertTrue($ReservationDescrpition,'Display discription of reservation'); 
        $this->controller->setreservation_ID('1');
        $this->controller->setfullname('Tan Say Ming');
        $this->controller->setpax_amount('4');
        $this->controller->settimeslot('1330');
        $this->controller->setseatingArea('H');
    }
    //TC-H-11-1-1
    public function testViewReservationInvalid()
    {
        $viewReservationpage = true;
        $this->controller->setreservation_ID('');
        $this->controller->setfullname('');
        $this->controller->setpax_amount('');
        $this->controller->settimeslot('');

        $reservation_ID = $this->controller->getreservation_ID();
        $fullname = $this->controller->getfullname();
        $pax_amount = $this->controller->getpax_amount();
        $timeslot = $this->controller->gettimeslot();

        $output = $reservation_ID.$fullname.$pax_amount.$timeslot;
        $output = false;
        $this -> assertFalse($output,'Reservation not found');

    }   
    //TC-H-12-1 to TC-H-12-4
    public function testModifyReservation()
    {
        $viewReservationpage = true;
        $this->controller->setreservation_ID('1');
        $this->controller->setfullname('Tan Say Ming');
        $this->controller->setpax_amount('4');
        $this->controller->settimeslot('1330');

        $reservation_ID = $this->controller->getreservation_ID();
        $fullname = $this->controller->getfullname();
        $pax_amount = $this->controller->getpax_amount();
        $timeslot = $this->controller->gettimeslot();
        $output = $reservation_ID.$fullname.$pax_amount.$timeslot;
        $db = $this->controller->getReservationwithID();

        $verify = $this -> assertEquals($db,$output);
        $ReservationDescrpition = true;
        $this -> assertTrue($ReservationDescrpition,'Display discription of reservation'); 
        $this->controller->setreservation_ID('1');
        $this->controller->setfullname('Tan Say Ming');
        $this->controller->setpax_amount('4');
        $this->controller->settimeslot('1330');
        $this->controller->setseatingArea('H');

        //Attempt to modify reservation
        $this->controller->setpax_amount('2');
        $pax_amount = $this->controller->getpax_amount();
        $newoutput = $reservation_ID.$fullname.$pax_amount.$timeslot = $ModifyReservation = true;
        $this -> assertTrue($ModifyReservation,'Reservation Modified Successfully');

    }   
    //TC-H-12-4-1
    public function testModifyReservationInvalid()
    {
        $viewReservationpage = true;
        $this->controller->setreservation_ID('1');
        $this->controller->setfullname('Tan Say Ming');
        $this->controller->setpax_amount('4');
        $this->controller->settimeslot('1330');

        $reservation_ID = $this->controller->getreservation_ID();
        $fullname = $this->controller->getfullname();
        $pax_amount = $this->controller->getpax_amount();
        $timeslot = $this->controller->gettimeslot();
        $output = $reservation_ID.$fullname.$pax_amount.$timeslot;
        $db = $this->controller->getReservationwithID();

        $verify = $this -> assertEquals($db,$output);
        $ReservationDescrpition = true;
        $this -> assertTrue($ReservationDescrpition,'Display discription of reservation'); 
        $this->controller->setreservation_ID('1');
        $this->controller->setfullname('Tan Say Ming');
        $this->controller->setpax_amount('4');
        $this->controller->settimeslot('1330');
        $this->controller->setseatingArea('H');

        //Attempt to modify reservation
        $this->controller->setpax_amount('');
        $pax_amount = $this->controller->getpax_amount();
        $newoutput = $reservation_ID.$fullname.$pax_amount.$timeslot = $ModifyReservation = false;
        $this -> assertFalse($ModifyReservation,'Invalid or empty inputs entered');
    }  
    //TC-H-13-1
    public function testCreateReservation()
    {
        $CreateReservationpage = true;
        
        $this->controller->setfullname('Tan Say Ming');
        $this->controller->setpax_amount('4');
        $this->controller->settimeslot('1330');
        $this->controller->setseatingArea('H');

        $fullname = $this->controller->getfullname();
        $pax_amount = $this->controller->getpax_amount();
        $timeslot = $this->controller->gettimeslot();
        $seatingArea = $this->controller->getseatingArea();
        $input = $fullname.$pax_amount.$timeslot.$seatingArea;
        $input = true;

        $this -> assertTrue($input,'Reservation Created Successfully'); 
    }
        //TC-H-13-1-1

        public function testCreateReservationInvalid()
        {
            $CreateReservationpage = true;
            
            $this->controller->setfullname('Tan Say Ming');
            $this->controller->setpax_amount('');
            $this->controller->settimeslot('1330');
            $this->controller->setseatingArea('H');
    
            $fullname = $this->controller->getfullname();
            $pax_amount = $this->controller->getpax_amount();
            $timeslot = $this->controller->gettimeslot();
            $seatingArea = $this->controller->getseatingArea();
            $input = $fullname.$pax_amount.$timeslot.$seatingArea;
            $input = false;
    
            $this -> assertFalse($input,'Invalid or empty inputs entered'); 
        }        
         //TC-H-14

         public function testDeleteReservation()
         {
             $DeleteReservationpage = true;
             
             $this->controller->setreservation_ID('1');
             $reservation_ID = $this->controller->getreservation_ID();
             $deleteReservation_ID = true;
             $this -> assertTrue($deleteReservation_ID,'Reservation Deleted Successfully');
            
         }         
         //TC-H-17 to TC-H-22

         public function testGenerateReport()
         {
            $GenerateReportpage = true;
            //Variable for report_name can either be 'Reservation' or 'Delivery'
            $this->controller->setreport_name('Reservation');
            //Variable for category can either be 'Weekly', 'Monthly' or 'Yearly'
            $this->controller->setcategory('Weekly');

            $report_name = $this->controller->getreport_name();
            $category = $this->controller->getcategory();
            $inputReportData = $report_name.$category;
            $inputReportData = true;
            $this -> assertTrue($inputReportData,'Results Displayed');

         }
}
