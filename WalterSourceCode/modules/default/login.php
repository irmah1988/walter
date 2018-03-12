<?php

require_once '../../configuration.php';


if(@$_POST['login']){

  $uname = $_POST['username'];
	$check = $db->query( "SELECT * FROM users WHERE username = '$uname'" );
  if($check->rowCount()>0){
    $row = $check->fetch();
    if (md5($_POST['password']) == $row['password']) {
      if($row['status']=='0'){
    		session_start();
    		$_SESSION['SESSION_USER'] = _encrypt($row['user_id']);
    		$_SESSION['SESSION_TYPE'] = _encrypt($row['role']);
        header("Location: ".$url."/");
      }else{
        header("Location: ".$url."/modules/default/login.php?action=logindeactivated");
      }
  	}else{
  		sleep(5);
  		header("Location: ".$url."/modules/default/login.php?action=loginerror");
  	}
  }else{
    sleep(5);
    header("Location: ".$url."/modules/default/login.php?action=loginerror");
  }

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo _settings('app_name'); ?></title>

    <!-- Google webfonts - Tititllium -->
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,700' rel='stylesheet' type='text/css'>

    <!-- Ion Icons -->
    <link href="<?php echo $_cssUrl; ?>/ionicons.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?php echo $_cssUrl; ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $_cssUrl; ?>/bootstrap-theme.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="<?php echo $_cssUrl; ?>/main.css" rel="stylesheet">
    <style>
      body,
      .bg-login{
        background:<?php echo _settings('color_bg'); ?>;
        color:<?php echo _settings('color_fg'); ?>;
      }
      button.login-btn{
        background: <?php echo _settings('color_button_bg'); ?>;
        color:<?php echo _settings('color_button_fg'); ?>;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="bg-login">

  <div class="container login">

    <div class="row">
      <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">

        <div style="height:100px;"></div>
        <center>
          <?php if(_settings('logo')=='none'){ ?>
          <?php echo _settings('app_name'); ?>
          <?php }else{ ?>
          <img src="<?php echo $_uploadUrl; ?>/<?php echo _settings('logo'); ?>"></a>
          <?php } ?>
    		</center>
        <p>&nbsp;</p>

        <br/>

    		<form method="post" id="login" action="">
    			<input type="hidden" name="login" value="1"/>

    			<?php if($action == 'loginerror'){ ?>
    			<div class="alert alert-danger"><i class="ion-alert-circled"></i> <b><?php echo _('Greška!'); ?></b><br/><?php echo _('Pogrešno korisičko ime i/ili lozinka, molimo pokušajte ponovo.'); ?></div>
    			<?php } ?>

    			<?php if($action == 'loginerror2'){ ?>
    			<div class="alert alert-danger"><i class="ion-alert-circled"></i> <b><?php echo _('Greška!'); ?></b><br/><?php echo _('Vaš račun je deaktiviran. Za više informacija kontaktirajte  nas.'); ?></div>
    			<?php } ?>

    			<?php if($action == 'loggedout'){ ?>
    			<div class="alert alert-success"><i class="ion-ios-checkmark"></i> <b><?php echo _('Uspješno!'); ?></b><br/><?php echo _('Uspješno ste se odjavili sa administraicije. Vidimo se poslije.'); ?></div>
    			<?php } ?>

    			<?php if($action == 'logindeactivated'){ ?>
    			<div class="alert alert-warning"><i class="ion-minus-circled"></i> <b><?php echo _('Neuspješno!'); ?></b><br/><?php echo _('Vaš korisnički nalog je deaktiviran.'); ?></div>
    			<?php } ?>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon alt"><i class="ion-ios-person"></i></div>
              <input type="text" name="username" class="form-control alt" id="usr" autocomplete="off" placeholder="<?php echo _('Korisničko ime'); ?>" required>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon alt"><i class="ion-key"></i></div>
              <input type="password" name="password" class="form-control alt" id="pass" placeholder="<?php echo _('Lozinka'); ?>" required>
            </div>
          </div>

    			<button type="submit" class="login-btn"><?php echo _('Prijava!'); ?></button><br/>



    		</form>

      </div>
    </div>

  </div>

</body>
</html>
