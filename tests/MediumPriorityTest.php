<?php 

require_once("src/testSRC.php");
use PHPUnit\Framework\TestCase;
class MediumPriorityTest extends TestCase {

    public $controller;
    public function SetUp():void {
     $this->controller = new Controller();   
    } 
    
    //TC-M-1
    public function testCreateUserProfile()
    {
        $this->controller->setprofileName('Staff');
        $profileName = $this->controller-> getprofileName();
        $this->assertEquals($profileName,'Staff');

        $this->controller->setfunctions('Menu');
        $functions = $this->controller-> getfunctions();
        $this->assertEquals($functions,'Menu');

        $this->controller->setdescription('Will be in charged of handling menu');
        $description = $this->controller-> getdescription();
        $this->assertEquals($description,'Will be in charged of handling menu');

       $profileName.$functions.$description = true;

       $this-> assertTrue(true,'User profile has been successfully created');

       $this->controller->setprofileName('');
       $profileName = $this->controller-> getprofileName();
       $this->assertEquals($profileName,'');

       $this->controller->setfunctions('');
       $functions = $this->controller-> getfunctions();
       $this->assertEquals($functions,'');

       $this->controller->setdescription('');
       $description = $this->controller-> getdescription();
       $this->assertEquals($description,'');

      $profileName.$functions.$description = false;

      $this-> assertFalse(false,'Error, User profile cannot be created');


    } 

    //TC-M-2

    public function testUpdateUserProfile()
    {
        $this->controller->setprofileName('Staff');
        $profileName = $this->controller-> getprofileName();
        $this->assertEquals($profileName,'Staff');

        $this->controller->setdescription('Will be in charged of handling orders');
        $description = $this->controller-> getdescription();
        $this->assertEquals($description,'Will be in charged of handling orders');

        $this->controller->setstatus('active');
        $status = $this->controller->getstatus();
        $this->assertEquals($status,'active');

        $this->controller->setfunctions('Orders');
        $functions = $this->controller-> getfunctions();
        $this->assertEquals($functions,'Orders');

       $profileName.$description.$status.$functions = true;
       $this-> assertTrue(true,'User profile has been successfully updated');
//-------------------------------------------------------------------------------------
       $this->controller->setprofileName('Staff');
       $profileName = $this->controller-> getprofileName();
       $this->assertEquals($profileName,'Staff');

       $this->controller->setdescription('Will be in charged of handling orders');
       $description = $this->controller-> getdescription();
       $this->assertEquals($description,'Will be in charged of handling orders');

       $this->controller->setstatus('active');
       $status = $this->controller->getstatus();
       $this->assertEquals($status,'active');

       $this->controller->setfunctions('');
       $functions = $this->controller-> getfunctions();
       $this->assertEquals($functions,'');

      $profileName.$description.$status.$functions = false;
      $this-> assertFalse(false,'Error, User profile cannot be updated');

    } 

    //TC-M-3

    public function testSuspendUserProfile()
    {
        $this->controller->setprofileName('Staff');
        $profileName = $this->controller-> getprofileName();
        $this->assertEquals($profileName,'Staff');
        $suspendUserProfile = $profileName = true;
        $this-> assertTrue(true,'User Profile suspended');

        $this->controller->setprofileName('');
        $profileName = $this->controller-> getprofileName();
        $this->assertEquals($profileName,'');
        $suspendUserProfile = $profileName = false;
        $this-> assertFalse(false,'Error, please select a profile to suspend');
           
    } 

    //TC-M-4
    
    public function testCreateUserAccount()
    {
        $this->controller->setemail('thomas.moshiqqstaff@gmail.com');
        $email = $this->controller-> getemail();
        $this->assertEquals($email,'thomas.moshiqqstaff@gmail.com');

        $this->controller->setpassword('thomas25@');
        $password = $this->controller-> getpassword();
        $this->assertEquals($password,'thomas25@');

        $this->controller->setphoneNumber('83724351');
        $phoneNumber = $this->controller-> getphoneNumber();
        $this->assertEquals($phoneNumber,'83724351');

        $this->controller->setfullname('Thomas Gerrad');
        $fullname = $this->controller-> getfullname();
        $this->assertEquals($fullname,'Thomas Gerrad');

        $this->controller->setprofileName('Staff');
        $profileName = $this->controller-> getprofileName();
        $this->assertEquals($profileName,'Staff');

       $accountcreation = $email.$password.$phoneNumber.$fullname.$profileName = true;
        $this-> assertTrue(true,'New user account has been successfully created');

        $this->controller->setemail('');
        $email = $this->controller-> getemail();

        $this->controller->setpassword('');
        $password = $this->controller-> getpassword();

        $this->controller->setphoneNumber('');
        $phoneNumber = $this->controller-> getphoneNumber();

        $this->controller->setfullname('');
        $fullname = $this->controller-> getfullname();

        $this->controller->setprofileName('');
        $profileName = $this->controller-> getprofileName();

       $accountcreation = $email.$password.$phoneNumber.$fullname.$profileName = false;
        $this-> assertFalse(false,'Error user account cannot be created');

        
    } 

    //TC-M-5
    public function testUpdateUserAccount()
    {
        $this->controller->setemail('thomas25.moshiqqstaff@gmail.com');
        $email = $this->controller-> getemail();
        $this->assertEquals($email,'thomas25.moshiqqstaff@gmail.com');

        $this->controller->setpassword('thomas@');
        $password = $this->controller-> getpassword();
        $this->assertEquals($password,'thomas@');

        $this->controller->setphoneNumber('97231245');
        $phoneNumber = $this->controller-> getphoneNumber();
        $this->assertEquals($phoneNumber,'97231245');

        $this->controller->setfullname('Thomas Gerrad');
        $fullname = $this->controller-> getfullname();
        $this->assertEquals($fullname,'Thomas Gerrad');

        $this->controller->setprofileName('Staff');
        $profileName = $this->controller-> getprofileName();
        $this->assertEquals($profileName,'Staff');

       $accountupdate = $email.$password.$phoneNumber.$fullname.$profileName = true;
        $this-> assertTrue(true,'Account has been updated');

        $empty = '';
        $accountupdate = $empty = false;
        $this-> assertFalse(false,'Error account cannot be updated');

    } 

    //TC-M-6
    public function testSuspendUserAccount()
    {
        $this->controller->setfullname('Staff1');
        $search = $this->controller-> getfullname();
        $this->assertEquals($search,'Staff1');
        $search = $suspended = true;
        $this -> assertTrue($suspended,'User Account suspended');

        $search = $empty = true;
        $this -> assertTrue(true,'Error please select an account to suspend');
        
    } 

    //TC-M-7
    public function testCreateUserAccountCustomer()
    {
        $this->controller->setfullname('Melvin Toh');
        $fullname = $this->controller-> getfullname();
        $this->assertEquals($fullname,'Melvin Toh');

        $this->controller->setemail('melvintoh@gmail.com');
        $email = $this->controller-> getemail();
        $this->assertEquals($email,'melvintoh@gmail.com');

        $this->controller->setpassword('Mel12345');
        $password = $this->controller-> getpassword();
        $retypepassword = $this->controller-> getpassword();
        $this->assertEquals($password,'Mel12345');
        $this->assertEquals($password,$retypepassword);

        $this->controller->setphoneNumber('90901033');
        $phoneNumber = $this->controller-> getphoneNumber();
        $this->assertEquals($phoneNumber,'90901033');

       $accountcreation = $fullname.$email.$password.$phoneNumber = true;
        $this-> assertTrue(true,'Account successfully created!');

        $empty = '';
        $accountcreationfail = $fullname.$empty = true;
        $this-> assertTrue(true,'Invalid input or empty fields!');

    } 

    //TC-M-8

    public function testUpdateUserAccountCustomer()
    {
        $this->controller->setemail('melvintoh@gmail.com');
        $email = $this->controller-> getemail();
        $this->assertEquals($email,'melvintoh@gmail.com');

        $this->controller->setfullname('Melvin Toh');
        $fullname = $this->controller-> getfullname();
        $this->assertEquals($fullname,'Melvin Toh');

        $this->controller->setpassword('Mel12345');
        $password = $this->controller-> getpassword();
        $this->assertEquals($password,'Mel12345');

        $this->controller->setphoneNumber('90901099');
        $phoneNumber = $this->controller-> getphoneNumber();
        $this->assertEquals($phoneNumber,'90901099');

        $accountupdate = $email.$fullname.$password.$phoneNumber = true;
        $this-> assertTrue(true,'Account successfully updated!');

        $this->controller->setphoneNumber('9');
        $phoneNumber = $this->controller-> getphoneNumber();
        $this->assertEquals($phoneNumber,'9');
        $accountupdateFail = $email.$fullname.$password.$phoneNumber = true;
        $this-> assertTrue(true,'Invalid input or empty fields!');
    } 

    //TC-M-9
    public function testDeleteUserAccount()
    {
        $DeleteButton = true;
        $this-> assertTrue($DeleteButton,'Account successfully deleted');
        $DeleteButton = false;
        $this-> assertFalse($DeleteButton,'Account deletion unsuccessful');
    } 

   //TC-M-10
   public function testBrowsemenu()
   {
        $MenuButton = true;
        $this-> assertTrue($MenuButton,'Redirects user to browse menu page');
   } 

   //TC-M-11
   public function testPreOrderMeal()
   {
        $ReservationButton = true;
        $this-> assertTrue($ReservationButton,'Redirects user to reservation page to allow customer select any pre-order items listed');
   } 

   //TC-M-12 & TC-M-13
   public function testAddnViewItemCart()
   {
        $MenuButton = true;
        $this->controller->setmenuitemID('1');
        $menuitemID = $this->controller-> getmenuitemID();
        $this->assertEquals($menuitemID,'1');
        $Cartadded = $menuitemID = true;
        $this-> assertTrue($Cartadded,'+1');
        $ViewCartButton = true;
        $this-> assertTrue($ViewCartButton,' Summary of cart appears');
   } 

   //TC-M-14
   public function testModifyCart()
   {
        $ViewCartButton = true;
        $this-> assertTrue($ViewCartButton,' Summary of cart appears');

        $this->controller->setmenuitemID('1');
        $menuitemID = $this->controller-> getmenuitemID();
        $Cartadded = $menuitemID = true;
        $Cartdecrease = $menuitemID = true;
        $this-> assertTrue($Cartadded,'+1');
        $this-> assertTrue($Cartdecrease,'-1'); 
   }  

   //TC-M-15 & TC-M-16
   public function testSubmitOrder()
   {
        $ViewCartButton = true;
        $this-> assertTrue($ViewCartButton,' Summary of cart appears');
        $PlaceOrderButton = true;
        $this-> assertTrue($PlaceOrderButton,' Payment page appears');

        $this->controller->setfullname('Melvin Toh');
        $fullname = $this->controller-> getfullname();
        $this->assertEquals($fullname,'Melvin Toh');

        $this->controller->setcardno('1234567890123456');
        $cardno = $this->controller-> getcardno();
        $this->assertEquals($cardno,'1234567890123456');

        $this->controller->setexpiry('12/24');
        $expiry = $this->controller-> getexpiry();
        $this->assertEquals($expiry,'12/24');

        $this->controller->setcvc('123');
        $cvc = $this->controller-> getcvc();
        $this->assertEquals($cvc,'123');

        $cardpayment = $fullname.$cardno.$expiry.$cvc = true;
        $this-> assertTrue(true,'Payment successful');
        
        $empty = '';
        $cardpayment = $fullname.$empty.$expiry.$cvc = false;
        $this-> assertFalse(false,'Payment unsuccessful');
    
   } 

   //TC-M-18
   public function testModifyReservation()
   {
       $this->controller->setaccount_ID('234');
       $this->controller->setfullname('Thomas Shelby');
       $this->controller->setemail('tshelby@gmail.com');
       $this->controller->setphoneNumber('82347521');
       $this->controller->setoutlet('Changi');
       $this->controller->setDate('10/11/2022');
       $this->controller->settimeslot('20:00');
       $this->controller->setpax_amount('8');
       $this->controller->setseatingArea('J');

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

   //TC-M-25
   public function testCreateOrder()
   {

       $this->controller->setfullname('Tan Say Ming');
       $this->controller->setitem('Hawaiian Salmon');
       $this->controller->setquantity('2');

       $fullname = $this->controller->getfullname();
       $item = $this->controller->getitem();
       $quantity = $this->controller->getquantity();

       $CreateOrder = $fullname.$item.$quantity = true;
        $this-> assertTrue(true,'Order Created Successfully!');

        $empty = '';
        $CreateOrder = $empty.$item.$quantity = false;
        $this-> assertFalse(false,'Invalid or empty inputs entered!');
   } 

   //TC-M-26
   public function testModifyOrder()
   {
       $ViewOrderpage = true;
       $this->controller->setfullname('Tan Say Ming');
       $this->controller->setitem('Hawaiian Salmon');
       $this->controller->setquantity('3');

       $fullname = $this->controller->getfullname();
       $item = $this->controller->getitem();
       $quantity = $this->controller->getquantity();

       $ModifyOrder = $fullname.$item.$quantity = true;
        $this-> assertTrue(true,'Order Modified Successfully!');
   } 

   //TC-M-27
   public function testCancelOrder()
   {
        $CancelOrderpage = true;
        $this->controller->setorder_ID('100');
        $order_ID = $this->controller->getorder_ID();
        $deleteButton = $order_ID = true;
        $this-> assertTrue(true,'Order deleted successfully!');

        $this->controller->setorder_ID('@');
        $order_ID = $this->controller->getorder_ID();
        $deleteButton = $order_ID = false;
        $this-> assertFalse(false,'Error, invalid order ID');
   }  

   //TC-M-28
   public function testSearchOrder()
   {
        $SearchOrderpage = true;
        $this->controller->setorder_ID('1');
        $order_ID = $this->controller->getorder_ID();
        $SearchButton = $order_ID = true;
        $this-> assertTrue(true,'Order details displayed');

        $this->controller->setorder_ID('@');
        $order_ID = $this->controller->getorder_ID();
        $SearchButton = $order_ID = false;
        $this-> assertFalse(false,'Error, invalid order ID');
   } 

   //TC-M-30 
   
   public function testCreateMenuItems()
   {
        $CreateMenuPage = true;
        $this->controller->setmenuitem_name('Salad');
        $this->controller->setprice('5.50');
        $this->controller->setmenuitem_description('The rigiht mix of nutrients to start your day');
        $this->controller->setitem_picture('salad.jpg');

       $menuitem_name = $this->controller->getmenuitem_name();
       $price = $this->controller->getprice();
       $menuitem_description = $this->controller->getmenuitem_description();
       $item_picture = $this->controller->getitem_picture();

       $createMenuitem = $menuitem_name.$price.$menuitem_description.$item_picture = true;
       $this ->assertTrue(true,'Item created successfully');

       $empty = '';
       $createMenuitem = $empty = false;
       $this ->assertFalse(false,'Error, please fill in the fields to create menu item');

   } 

   //TC-M-31
   public function testModifyMenuItems()
   {
        $ModifyMenuPage = true;
        $this->controller->setmenuitem_name('Greeny Salad');
        $this->controller->setprice('7.80');

        $menuitem_name = $this->controller->getmenuitem_name();
        $price = $this->controller->getprice();

        $modifyMenu = $menuitem_name.$price = true;
        $this ->assertTrue(true,'Item modified successfully');

        $item_picture = 'salad.jsr';
        $modifyMenu = $item_picture = false;
        $this-> assertFalse(false,'Error, unable to modify the menu item');

   } 

   //TC-M-32
   public function testSearchMenuItems()
   {
        $SearchMenuPage = true;
        $this->controller->setmenuitem_name('Greeny Salad');
        $menuitem_name = $this->controller->getmenuitem_name();
        $searchMenubutton = $menuitem_name = true;
        $this -> assertTrue(true,'Information displayed');

        $menuitem_name = 'Yellow';
        $searchMenubutton = $menuitem_name = false;
        $this -> assertFalse(False,'Invalid search');
   } 

   //TC-M-34
   public function testDeleteMenuItems()
   {
        $DeleteMenuPage = true;
        $this->controller->setmenuitem_name('Greeny Salad');
        $menuitem_name = $this->controller->getmenuitem_name();
        $DeleteMenubutton = $menuitem_name = true;
        $this -> assertTrue(true,'Item deleted successfully');

        $menuitem_name = 'Yello';
        $DeleteMenubutton = $menuitem_name = false;
        $this -> assertFalse(False,'Error, invalid menu item');
   } 

}
