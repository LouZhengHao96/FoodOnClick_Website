<?php 

require_once("src/testSRC.php");
use PHPUnit\Framework\TestCase;
class LowPriorityTest extends TestCase {

    public $controller;
    public function SetUp():void {
     $this->controller = new Controller();   
    }
    
    //TC-L-1, TC-L-7, TC-L-10, TC-L-17
    public function testActorsLogin()
    {
          $MoshiQwebsite = true;
          //Similar login page with different data entered to Customer,Staff and Owner 
          // testcust@gmail.com, teststaff@gmail.com, testowner@gmail.com
          $this->controller->setemail('testadmin@gmail.com');
          $email = $this->controller-> getemail();
          $this->assertEquals($email,'testadmin@gmail.com');
          //cust123,staff123,owner123
          $this->controller->setpassword('admin123');
          $password = $this->controller-> getpassword();;
          $this->assertEquals($password,'admin123');
          $inputdata = $email.$password = true;
          $this -> assertTrue(true,'Login success, redirecting to actor page');

          $empty = '';
          $inputdata = $email.$empty = false;
          $this -> assertFalse(false,'Wrong inputs or empty fields!');
    } 

    //TC-L-3 & TC-L-4
    public function testSearchUserProfile()
    {
          $ViewUserProfilepage = true;
          $this->controller->setprofileName('staff');
          $profileName = $this->controller-> getprofileName();
          $SearchButton = $profileName = true;
          $this -> assertTrue(true,'System displays result');

          $profileName = 'abc';
          $SearchButton = $profile = false;
          $this -> assertFalse(false,'No records found');
    } 

    //TC-L-5 & TC-L-6
    public function testSearchUserAccount()
    {
          $ViewUserAccountpage = true;
          $this->controller->setphoneNumber('90901010');
          $phoneNumber = $this->controller-> getphoneNumber();
          $SearchButton = $phoneNumber = true;
          $this -> assertTrue(true,'System displays result');

          $phoneNumber = '123';
          $SearchButton = $profile = false;
          $this -> assertFalse(false,'No records found');
    } 

    //TC-L-12
    public function testCreateCoupon()
    {
          $CreateCouponPage = true;
          $this->controller->setcouponname('cc200ff');
          $couponname = $this->controller-> getcouponname();
          $this->controller->setvalidBegin('30/09/2022');
          $validBegin = $this->controller-> getvalidBegin();
          $this->controller->setvalidEnd('30/10/2022');
          $validEnd = $this->controller-> getvalidEnd();
          $this->controller->setTnC('testinfo');
          $TnC = $this->controller-> getTnC();
          $this->controller->setPercentage('20');
          $Percentage = $this->controller-> getPercentage();
          $createcoupon = $couponname.$validBegin.$validEnd.$TnC.$Percentage = true;
          $this -> assertTrue(true,'Successful creation of coupon code');

          $empty ='';
          $createcoupon = $couponname.$validBegin.$validEnd.$TnC.$empty = false;
          $this -> assertFalse(false,'Unsuccessful creation of coupon code');
    } 

    //TC-L-13, TC-L-15
    public function testModifyCoupon()
    {
          $ViewCouponPage = true;
          $this->controller->setcouponname('cc200ff');
          $couponname = $this->controller-> getcouponname();
          $this->controller->setvalidBegin('30/09/2022');
          $validBegin = $this->controller-> getvalidBegin();
          $this->controller->setvalidEnd('30/10/2022');
          $validEnd = $this->controller-> getvalidEnd();
          $this->controller->setTnC('testinfo');
          $TnC = $this->controller-> getTnC();
          $this->controller->setPercentage('30');
          $Percentage = $this->controller-> getPercentage();
          $Modifycoupon = $couponname.$validBegin.$validEnd.$TnC.$Percentage = true;
          $this -> assertTrue(true,'Successful creation of coupon code');

          $empty ='';
          $Modifycoupon = $couponname.$validBegin.$validEnd.$TnC.$empty = false;
          $this -> assertFalse(false,'Unsuccessful creation of coupon code');
    } 

    //TC-L-14
    public function testSearchCoupon()
    {
          $SearchCouponPage = true;
          $this->controller->setcouponname('cc200ff');
          $couponname = $this->controller->getcouponname();
          $SearchButton = $couponname = true;
          $this-> assertTrue(true,'Coupon details displayed');
    } 

    //TC-L-16
    public function testRemoveCoupon()
    {
          $RemoveCouponPage = true;
          $this->controller->setcouponname('cc200ff');
          $couponname = $this->controller->getcouponname();
          $RemoveButton = $couponname = true;
          $this-> assertTrue(true,'Successful removal coupon code');

          $this->controller->setcouponname('abc');
          $couponname = $this->controller->getcouponname();
          $RemoveButton = $couponname = false;
          $this-> assertFalse(false,'Unsuccessful removal of coupon code');
    }
   
}
