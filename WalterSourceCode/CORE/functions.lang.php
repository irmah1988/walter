<?php


  function _lang($id){
    global $db;

    $query = $db->query("SELECT * FROM languages WHERE lang_id='$id'");
    if($query->rowCount()>0){

      $row = $query->fetch();
      return $row;

    }

  }


  function _getLocale(){
    global $_defaultLocale;

    if(!isset($_SESSION['SESSION_USER']) || (trim($_SESSION['SESSION_USER'])=='')){

      return $_defaultLocale;

    }else{

      $_user =  _user(_decrypt($_SESSION['SESSION_USER']));
      $_userLang = _lang($_user['lang']);
      return $_userLang['lang_code'];

    }

  }


  // Traslation support
  $locale = _getLocale().'.UTF-8';
  putenv("LANG=".$locale);
  setlocale(LC_ALL, $locale);
  bindtextdomain('messages', $root."/locale");
  textdomain('messages');


 ?>
