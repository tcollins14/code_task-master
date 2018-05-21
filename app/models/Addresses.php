<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;

use Carbon\Carbon;

class Addresses extends Eloquent {

  protected $fillable = ['address_line1', 'address_line2', 'town', 'county', 'country', 'postcode', 'from_date', 'until_date'];

  public $errors = [];

  public function __construct($data =[])

  {
    foreach ($data as $key => $value) {
          $this->$key = $value;
      };

    }


    public function validate($user){

        if ($this->address_line1 == '') {
           $this->errors[] = 'Address Line 1 is required';
        }

        if (strlen($this->address_line1) >= 30) {
          $this->errors[] = 'Address Line 1 must not exceed 30 characters';
        }

        if (strlen($this->address_line2) >= 30) {
          $this->errors[] = 'Address Line 2 must not exceed 30 characters';
        }

        if ($this->town == '') {
           $this->errors[] = 'Town is required';
        }

        if ($this->country == '' || $this->country == '(please select a country)') {
           $this->errors[] = 'Country is required';
        }

        if ($this->postcode == '') {
           $this->errors[] = 'Postcode is required';
        }

        if ($this->from_date > $this->until_date) {
            $this->errors[] = 'From date needs to be before until date';
        }

        if($this->until_date < $this->from_date) {
            $this->errors[] = 'Until date needs to be after from date';
        }

        if ($this->from_date < $user->dob) {
           $this->errors[] = 'From date needs to be on/after Date of birth';
        }
      }

    public function getFormattedDate($value)
    {
        $date = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
        return $date;
    }

    public static function findAddressById($id) {
      $address = Addresses::find($id);

      return $address;
    }

    public static function findAddressesById($user) {

      $addresses = Addresses::where('user_id', $user->id)->get();

      return $addresses;
    }

    public function addAddress($data, $user) {
      $address = new Addresses();
      $address->address_id = $data['address_id'];
      $address->address_line1 = $data['address_line1'];
      $address->address_line2 = $data['address_line2'];
      $address->town = $data['town'];
      $address->county = $data['county'];
      $address->country = $data['country'];
      $address->postcode = $data['postcode'];
      $address->from_date = $address->getFormattedDate($data['from_date']);
      $address->until_date = $address->getFormattedDate($data['until_date']);

      $address->validate($user);

      if (empty($address->errors)) {
        $query = array("user_id" => $user->id, "address_line1" => $address->address_line1, "address_line2" => $address->address_line2, "town" => $address->town, "county" => $address->county, "country" => $address->country, "postcode" => $address->postcode, "from_date" => $address->from_date, "until_date" => $address->until_date);
    
    $add = DB::table('addresses')->insert($query);
     
    return $add;
    }
    return false;
    }

    public function updateAddress($data, $user) {
      $this->address_id = $data['address_id'];
      $this->address_line1 = $data['address_line1'];
      $this->address_line2 = $data['address_line2'];
      $this->town = $data['town'];
      $this->county = $data['county'];
      $this->country = $data['country'];
      $this->postcode = $data['postcode'];
      $this->from_date = $this->getFormattedDate($data['from_date']);
      $this->until_date = $this->getFormattedDate($data['until_date']);

      $this->validate($user);

      if (empty($this->errors)) {

        $query = array("address_line1" => $this->address_line1, "address_line2" => $this->address_line2, "town" => $this->town, "county" => $this->county, "country" => $this->country, "postcode" => $this->postcode, "from_date" => $this->from_date, "until_date" => $this->until_date);  

    $update = DB::table('addresses')->where('id', $this->address_id)->update($query);
     
    return $update;
    }
    return false;
    }

    public function deleteAddress($aid)
    {

      $address = Addresses::find($aid);

      if ($address->delete())
      {
        return true;
      } else {
        return false;
      }
    }
  }