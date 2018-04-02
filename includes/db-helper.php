<?php
class DBHelper{
  private $link;
  public $perPage         = 5;
  public $strBadRequest   = "bad request";
  public $strBadQuery     = "bad query";
  public $strNotFound     = "data not found";
  public $accessForbidden = "access forbidden";
  public $quota           = 51200;
  public $jateng          = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','71','72','73','74','75','76');

  function __construct() {
    require_once('connect.php');
    $conn = new Connect();
    $this->link = $conn->link;
  }

  function escapeInput($string) {
    return $this->link->real_escape_string($string);
  }


  //----------------------------------------------------------------------------

  //----------------------------------------------------------------------------
  // USER
  //****CHANGE USER DETAIL
  function updateUser($array) {
    $user_id        = $array[RequestKey::$USER_ID];
    $user_name      = $array[RequestKey::$USER_NAME];
    $user_username  = $array[RequestKey::$USER_USERNAME];

    if ($result = $this->link->query("UPDATE user SET user_name = '$user_name', user_username = '$user_username'")) {
      return true;
    }
    return false;
  }

  //***CHANGE USER PASSWORD
  function changePassword($uid,$new) {
    if ($result = $this->link->query("UPDATE user SET user_password = '$new' WHERE user_id = '$uid'")) {
      return true;
    }
    return false;
  }

  //***READ USER
  function login($username,$password) {
    $password = sha1($password);
    if ($result = $this->link->query("SELECT * FROM user WHERE user_username = '$username' AND user_password = '$password'")) {
      if($result->num_rows > 0) {
        return $result->fetch_object();
      }
    }
    else {
      return false;
    }
  }

  //----------------------------------------------------------------------------

  //----------------------------------------------------------------------------
  //PLACE
  //***CREATE PLACE

  //ALL PLACE
  function getAllPlace() {
    if ($result = $this->link->query("SELECT * FROM place")) {
      return $result;
    }
    else {
      return false;
    }
  }

  //PLACE BY ID
  function getPlaceById($pid) {
    if ($result = $this->link->query("SELECT * FROM place WHERE place_id = '$pid'")) {
      return $result->fetch_object();
    }
    else{
      return false;
    }
  }

  //GET MASJID
  function getMasjid() {
    if ($result = $this->link->query("SELECT * FROM place WHERE place_category = 0")) {
      return $result;
    }
    else{
      return false;
    }
  }

  //GET MASJID
  function getRumah() {
    if ($result = $this->link->query("SELECT * FROM place WHERE place_category = 1")) {
      return $result;
    }
    else{
      return false;
    }
  }
  //COUNT PLACE
  function countPlace() {

    if ($result = $this->link->query("SELECT * FROM place")) {
      return $result->num_rows;
    }
    else{
      return false;
    }
  }

  //----------------------------------------------------------------------------
}
?>
