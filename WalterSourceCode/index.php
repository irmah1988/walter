<?php

  ob_start();

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once 'configuration.php';

  // Include admin menu
  include_once $root.'/CORE/menu.php';



  echo $db_error;

  if(!isset($_SESSION['SESSION_USER']) || (trim($_SESSION['SESSION_USER'])=='')){

    header('Location: '.$url.'/modules/default/login.php');

  }else{

    $session 	= $_SESSION['SESSION_USER'];

    $_defaultMod    = 'default';
    $_defaultPage   = 'profile';


    if($action=='logout'){

      unset($_SESSION['SESSION_USER']);
      header('Location: '.$url.'/modules/default/login.php?action=loggedout');

    }else{

      $_user = _user(_decrypt($session));

      include_once $_themeRoot.'/header.php';

      if(isset($_mod)){

        include_once $root.'/modules/'.$_mod.'/index.php';

      }else{

        $_mod = $_defaultMod;
        include_once $root.'/modules/'.$_mod.'/index.php';

      }

    }

  }

 ?>
