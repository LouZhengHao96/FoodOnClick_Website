<?php
class Controller
{
    public $account_ID;
    public $fullname;
    public $email;
    public $phoneNumber;
    public $outlet;
    public $date;
    public $timeslot;
    public $pax_amount;
    public $seatingArea;
    public $order_ID;
    public $item;
    public $quantity;
    public $reservation_ID;
    public $report_name;
    public $category;
    public $profileName;
    public $functions;
    public $description;
    public $status;
    public $password;
    public $menuitemID;
    public $cardno;
    public $expiry;
    public $cvc;
    public $menuitem_name;
    public $price;
    public $menuitem_description;
    public $item_picture;
    public $couponname;
    public $validBegin;
    public $validEnd;
    public $TnC;
    public $Percentage;

    public function getfullname()
    {
        return $this->fullname;
    }
    public function setfullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function getemail()
    {
        return $this->email;
    }
    public function setemail($email)
    {
        $this->email = $email;
    }
    public function getphoneNumber()
    {
        return $this->phoneNumber;
    }
    public function setphoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }   
    public function getaccount_ID()
    {
        return $this->account_ID;
    }
    public function setaccount_ID($account_ID)
    {
        $this->account_ID = $account_ID;
    }
    public function getoutlet()
    {
        return $this->outlet;
    }
    public function setoutlet($outlet)
    {
        return $this->outlet = $outlet;
    }

    public function getdate()
    {
        return $this->date;
    }
    public function setdate($date)
    {
        return $this->date = $date;
    }
    public function gettimeslot()
    {
        return $this->timeslot;
    }
    public function settimeslot($timeslot)
    {
        return $this->timeslot = $timeslot;
    }
    public function getpax_amount()
    {
        return $this->pax_amount;
    }
    public function setpax_amount($pax_amount)
    {
        return $this->pax_amount = $pax_amount;
    }
    public function getseatingArea()
    {
        return $this->seatingArea;
    }
    public function setseatingArea($seatingArea)
    {
        return $this->seatingArea = $seatingArea;
    }

    public function getReservationDetails(){
        return $this->account_ID.$this->fullname.$this->email.$this->phoneNumber.$this->outlet.$this->date
        .$this->timeslot.$this->pax_amount.$this->seatingArea;
    }

    public function getEmptyinputs()
    {
        return ;
    }

    public function getorder_ID()
    {
        return $this->order_ID;
    }
    public function setorder_ID($order_ID)
    {
        return $this->order_ID = $order_ID;
    }

    public function getitem()
    {
        return $this->item;
    }
    public function setitem($item)
    {
        return $this->item = $item;
    }

    public function getquantity()
    {
        return $this->quantity;
    }
    public function setquantity($quantity)
    {
        return $this->quantity = $quantity;
    }

    public function getOrderDetails()
    {
        return $this->order_ID.$this->fullname.$this->item.$this->quantity;
    }

    public function getreservation_ID()
    {
        return $this->reservation_ID;
    }
    public function setreservation_ID($reservation_ID)
    {
        return $this->reservation_ID = $reservation_ID;
    }

    public function getReservationwithID(){
        return $this->reservation_ID.$this->fullname.$this->pax_amount.$this->timeslot;
    }

    public function getCreateReservation(){
        return $this->fullname.$this->pax_amount.$this->timeslot.$this->seatingArea;
    }

    public function getreport_name()
    {
        return $this->report_name;
    }
    public function setreport_name($report_name)
    {
        return $this->report_name = $report_name;
    }

    public function getcategory()
    {
        return $this->category;
    }
    public function setcategory($category)
    {
        return $this->category = $category;
    }

    public function getprofileName()
    {
        return $this->profileName;
    }
    public function setprofileName($profileName)
    {
        return $this->profileName = $profileName;
    }

    public function getfunctions()
    {
        return $this->functions;
    }
    public function setfunctions($functions)
    {
        return $this->functions = $functions;
    }

    public function getdescription()
    {
        return $this->description;
    }
    public function setdescription($description)
    {
        return $this->description = $description;
    }

    public function getstatus()
    {
        return $this->status;
    }
    public function setstatus($status)
    {
        return $this->status = $status;
    }

    public function getpassword()
    {
        return $this->password;
    }
    public function setpassword($password)
    {
        return $this->password = $password;
    }

    public function getmenuitemID()
    {
        return $this->menuitemID;
    }
    public function setmenuitemID($menuitemID)
    {
        return $this->menuitemID = $menuitemID;
    }

    public function getcardno()
    {
        return $this->cardno;
    }
    public function setcardno($cardno)
    {
        return $this->cardno = $cardno;
    }

    public function getexpiry()
    {
        return $this->expiry;
    }
    public function setexpiry($expiry)
    {
        return $this->expiry = $expiry;
    }

    public function getcvc()
    {
        return $this->cvc;
    }
    public function setcvc($cvc)
    {
        return $this->cvc = $cvc;
    }

    public function getmenuitem_name()
    {
        return $this->menuitem_name;
    }
    public function setmenuitem_name($menuitem_name)
    {
        return $this->menuitem_name = $menuitem_name;
    }

    public function getprice()
    {
        return $this->price;
    }
    public function setprice($price)
    {
        return $this->price = $price;
    }

    public function getmenuitem_description()
    {
        return $this->menuitem_description;
    }
    public function setmenuitem_description($menuitem_description)
    {
        return $this->menuitem_description = $menuitem_description;
    }

    public function getitem_picture()
    {
        return $this->item_picture;
    }
    public function setitem_picture($item_picture)
    {
        return $this->item_picture = $item_picture;
    }
   
    public function getcouponname()
    {
        return $this->couponname;
    }
    public function setcouponname($couponname)
    {
        return $this->couponname = $couponname;
    }

    public function getvalidBegin()
    {
        return $this->validBegin;
    }
    public function setvalidBegin($validBegin)
    {
        return $this->validBegin = $validBegin;
    }

    public function getvalidEnd()
    {
        return $this->validEnd;
    }
    public function setvalidEnd($validEnd)
    {
        return $this->validEnd = $validEnd;
    }

    public function getTnC()
    {
        return $this->TnC;
    }
    public function setTnC($TnC)
    {
        return $this->TnC = $TnC;
    }

    public function getPercentage()
    {
        return $this->Percentage;
    }
    public function setPercentage($Percentage)
    {
        return $this->Percentage = $Percentage;
    }


}
