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

  //GET USER BY id
  function getUserById($uid){
    if($result = $this->link->query("SELECT * FROM user WHERE user_id = '$uid'")){
      return $result->fetch_object();
    }
    else {
      return false;
    }
  }

  //----------------------------------------------------------------------------

  //----------------------------------------------------------------------------
  //PLACE
  //***CREATE PLACE
  function createPlace($array){
    $place_name      = $array[RequestKey::$PLACE_NAME];
    $place_location  = $array[RequestKey::$PLACE_LOCATION];
    $place_category  = $array[RequestKey::$PLACE_CATEGORY];
    if($place = $this->link->query("INSERT INTO place (place_name, place_location, place_category) VALUES ('$place_name', '$place_location', 'place_cetegory')")){
      return true;
    }
    else{
      return false;
    }
  }
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
  //DELETE PLACE
  function deletePlace($pid){
    if($result = $this->link->query("DELETE FROM place WHERE place_id = '$pid'")){
      return true;
    }
    else {
      return false;
    }
  }

  //LAST PLACE ID
  function lastPlaceId(){
    if($result = $this->link->query("SELECT * FROM place")){
      $place_id = 0;
      while ($re = $result->fetch_object()) {
        if ($place_id < $re->place_id){
          $place_id = $re->place_id;
        }
      }
      return $place_id;
    }
    return false;
  }

  //CEK SAME LOCATION
  function isLocationExist($loc){
    if ($result = $this->link->query("SELECT * FROM place WHERE place_location = '$loc'")) {
      if ($result->num_rows > 0) {
        return true;
      }
      else {
        return false;
      }
    }
  }
  //----------------------------------------------------------------------------

  //----------------------------------------------------------------------------
  //MASJID
  //CREATE MASJID
  function createMasjid($array){
    $masjid_name      = $array[RequestKey::$MASJID_NAME];
    $masjid_place_id  = $array[RequestKey::$MASJID_PLACE_ID];
    $masjid_history   = $array[RequestKey::$MASJID_HISTORY];
    if ($result = $this->link->query("INSERT INTO masjid (masjid_name, place_id, masjid_history) VALUES ('$masjid_name', '$masjid_place_id', '$masjid_history')")) {
      return true;
    }
    else{
      return false;
    }
  }

  //EDIT MASJID
  function editMasjid($array){
    $masjid_id        = $array[RequestKey::$MASJID_ID];
    $masjid_name      = $array[RequestKey::$MASJID_NAME];
    $masjid_history   = $array[RequestKey::$MASJID_HISTORY];
    if ($result = $this->link->query("UPDATE masjid SET masjid_name = '$masjid_name', masjid_history = '$masjid_history' WHERE masjid_id = '$masjid_id'")) {
      return true;
    }
    else{
      return false;
    }
  }

  //GET MASJID
  function getAllMasjid() {
    if ($result = $this->link->query("SELECT * FROM place WHERE place_category = 0")) {
      return $result;
    }
    else{
      return false;
    }
  }

  //GET MASJID BY ID
  function getMasjidById($mid) {
    if ($result = $this->link->query("SELECT * FROM masjid WHERE masjid_id = '$mid'")) {
      return $result->fetch_object();
    }
    else{
      return false;
    }
  }

  //GET MASJID BY PLACE ID
  function getMasjidByPlaceId($pid  ) {
    if ($result = $this->link->query("SELECT * FROM masjid WHERE place_id = '$pid'")) {
      return $result->fetch_object();
    }
    else{
      return false;
    }
  }

  //DELETE MASJID
  function deleteMaasjid($mid){
    if($result = $this->link->query("DELETE FROM masjid WHERE masjid_id = '$mid'")){
      return true;
    }
    else{
      return false;
    }
  }
    //----------------------------------------------------------------------------

    //----------------------------------------------------------------------------
    //KAJIAN

    //CHECK Cek Kajian
    function isKajianExist($mid) {
      if ($result = $this->link->query("SELECT * FROM masjid_kajian WHERE masjid_id = $mid")) {
        if ($result->num_rows > 0) {
          return true;
        }
      }
      return false;
    }

    //GET ALL KAJIAN
    function getAllKajian($mid) {
      if ($result = $this->link->query("SELECT * FROM masjid_kajian WHERE masjid_id = $mid ORDER BY kajian_date ASC, kajian_time ASC ")) {
        return $result;
      }
      else{
        return false;
      }
    }

    //GET KAJIAN BY ID
    function getKajianById($kid) {
      if ($result = $this->link->query("SELECT * FROM masjid_kajian WHERE kajian_id = $kid")) {
        return $result->fetch_object();
      }
      else{
        return false;
      }
    }

    //CREATE KAJIAN
    function createKajian($array){
      $masjid_id          = $array[RequestKey::$KAJIAN_MASJID_ID];
      $kajian_date        = $array[RequestKey::$KAJIAN_DATE];
      $kajian_time         = $array[RequestKey::$KAJIAN_TIME];
      $kajian_title        = $array[RequestKey::$KAJIAN_TITLE];
      $kajian_description  = $array[RequestKey::$KAJIAN_DESCRIPTION];
      $kajian_speaker      = $array[RequestKey::$KAJIAN_SPEAKER];
      if ($result = $this->link->query("INSERT INTO masjid_kajian (masjid_id, kajian_date, kajian_time, kajian_title, kajian_description, kajian_speaker) VALUES ('$masjid_id', '$kajian_date', '$kajian_time', '$kajian_title', '$kajian_description', '$kajian_speaker')")) {
        return true;
      }
      else{
        return false;
      }
    }

    //EDIT KAJIAN
    function editKajian($array){
      $kajian_id           = $array[RequestKey::$KAJIAN_ID];
      $kajian_date         = $array[RequestKey::$KAJIAN_DATE];
      $kajian_time         = $array[RequestKey::$KAJIAN_TIME];
      $kajian_title        = $array[RequestKey::$KAJIAN_TITLE];
      $kajian_description  = $array[RequestKey::$KAJIAN_DESCRIPTION];
      $kajian_speaker      = $array[RequestKey::$KAJIAN_SPEAKER];
      if ($result = $this->link->query("UPDATE masjid_kajian SET kajian_date = '$kajian_date', kajian_time = '$kajian_time', kajian_title = '$kajian_title', kajian_description = '$kajian_description', kajian_speaker = '$kajian_speaker' WHERE kajian_id = '$kajian_id'")) {
        return true;
      }
      else{
        return false;
      }
    }

    //DELETE KAJIAN
    function deleteKajian($kid){
      if($result = $this->link->query("DELETE FROM masjid_kajian WHERE kajian_id = '$kid'")){
        return true;
      }
      else{
        return false;
      }
    }

    //DELETE KAJIAN
    function deleteKajianByMid($mid){
      if($result = $this->link->query("DELETE FROM masjid_kajian WHERE masjid_id = '$mid'")){
        return true;
      }
      else{
        return false;
      }
    }


    //----------------------------------------------------------------------------

    //----------------------------------------------------------------------------
    //JUMAT
    //CHECK Cek Kajian
    function isJumatExist($mid) {
      if ($result = $this->link->query("SELECT * FROM masjid_jumat WHERE masjid_id = $mid")) {
        if ($result->num_rows > 0) {
          return true;
        }
      }
      return false;
    }

    //GET ALL JUMAT
    function getAllJumat($mid) {
      if ($result = $this->link->query("SELECT * FROM masjid_jumat WHERE masjid_id = $mid")) {
        return $result;
      }
      else{
        return false;
      }
    }

    //GET JUMAT BY ID
    function getJumatById($jid) {
      if ($result = $this->link->query("SELECT * FROM masjid_jumat WHERE jumat_id = $jid")) {
        return $result->fetch_object();
      }
      else{
        return false;
      }
    }

    //CREATE JUMAT
    function createJumat($array){
      $masjid_id   = $array[RequestKey::$JUMAT_MASJID_ID];
      $jumat_date  = $array[RequestKey::$JUMAT_DATE];
      $jumat_imam  = $array[RequestKey::$JUMAT_IMAM];
      if ($result = $this->link->query("INSERT INTO masjid_jumat (masjid_id, jumat_date, jumat_imam) VALUES ('$masjid_id', '$jumat_date', '$jumat_imam')")) {
        return true;
      }
      else{
        return false;
      }
    }

    //EDIT JUMAT
    function editJumat($array){
      $jumat_id   = $array[RequestKey::$JUMAT_ID];
      $jumat_date = $array[RequestKey::$JUMAT_DATE];
      $jumat_imam = $array[RequestKey::$JUMAT_IMAM];
      if ($result = $this->link->query("UPDATE masjid_jumat SET jumat_date = '$jumat_date', jumat_imam ='$jumat_imam' WHERE jumat_id = '$jumat_id'")) {
        return true;
      }
      else{
        return false;
      }
    }

    //DELETE JUMAT
    function deleteJumat($jid){
      if($result = $this->link->query("DELETE FROM masjid_jumat WHERE jumat_id = '$jid'")){
        return true;
      }
      else{
        return false;
      }
    }

    //DELETE JUMAT BY MID
    function deleteJumatByMid($mid){
      if($result = $this->link->query("DELETE FROM masjid_jumat WHERE masjid_id = '$mid'")){
        return true;
      }
      else{
        return false;
      }
    }

    //----------------------------------------------------------------------------

    //----------------------------------------------------------------------------
    //RUMAH
    //GET RUMAH
    function getRumah() {
      if ($result = $this->link->query("SELECT * FROM place WHERE place_category = 1")) {
        return $result;
      }
      else{
        return false;
      }
    }

    //CREATE FAMILY
    function createFamily($array){
      $family_place_id    = $array[RequestKey::$FAMILY_PLACE_ID];
      $family_name        = $array[RequestKey::$FAMILY_NAME];
      $family_status      = $array[RequestKey::$FAMILY_STATUS];
      $family_age         = $array[RequestKey::$FAMILY_AGE];
      $family_gender      = $array[RequestKey::$FAMILY_GENDER];
      $family_born_place  = $array[RequestKey::$FAMILY_BORN_PLACE];
      $family_born_date   = $array[RequestKey::$FAMILY_BORN_DATE];
      $family_education   = $array[RequestKey::$FAMILY_EDUCATION];
      $family_salary      = $array[RequestKey::$FAMILY_SALARY];
      $family_blood       = $array[RequestKey::$FAMILY_BLOOD];

      if ($result = $this->link->query("INSERT INTO `family` (
        `place_id`, `family_name`, `family_status`, `family_age`, `family_gender`, `family_born_place`, `family_born_date`, `family_education`, `family_salary`, `family_blood`)
        VALUES (
          `$family_place_id`, `$family_name`, `$family_status`, `$family_age`, `$family_gender`, `$family_born_place`, `$family_born_date`, `$family_education`, `$family_salary`, `$family_blood`)
          ")){
            return true;
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


      }
      ?>
