<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo _settings('app_name'); ?></title>


    <!-- Pace -->
    <script src="<?php echo $_pluginUrl; ?>/pace/pace.js"></script>
    <style>
    	.pace {
		  -webkit-pointer-events: none;
		  pointer-events: none;

		  -webkit-user-select: none;
		  -moz-user-select: none;
		  user-select: none;
      position: fixed;
      z-index: 99999;
      background: rgba(0,0,0,0);
      width:100%;
      height:100%;
		}
		.pace-inactive {
		  display: none;
		}
		.pace .pace-progress {
		  background: #cc0000;
		  position: fixed;
		  z-index: 2000;
		  top: 60px;
		  right: 100%;
		  width: 100%;
		  height: 1px;
		}
    </style>

    <!-- Google webfonts - Tititllium -->
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,700' rel='stylesheet' type='text/css'>

    <!-- Ion Icons -->
    <link href="<?php echo $_cssUrl; ?>/ionicons.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?php echo $_cssUrl; ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $_cssUrl; ?>/bootstrap-theme.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="<?php echo $_pluginUrl; ?>/select2/select2.min.css" rel="stylesheet">

    <!-- Bootstrap datepicker CSS -->
    <link href="<?php echo $_pluginUrl; ?>/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">

    <!-- Bootstrap touchspin CSS -->
    <link href="<?php echo $_pluginUrl; ?>/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

    <!-- icheck CSS -->
    <link href="<?php echo $_pluginUrl; ?>/icheck/skins/square/blue.css" rel="stylesheet">

    <!-- Farbtastic CSS -->
    <link href="<?php echo $_pluginUrl; ?>/farbtastic/farbtastic.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="<?php echo $_cssUrl; ?>/main.css" rel="stylesheet">
    <style>
      body{
        background:<?php echo _settings('color_bg'); ?>;
        color:<?php echo _settings('color_fg'); ?>;
      }
      header,
      header > ul li ul{
        background:<?php echo _settings('color_header_bg'); ?>;
        color:<?php echo _settings('color_header_fg'); ?>;
      }
      header > ul li a,
      header .user,
      a{
        color:<?php echo _settings('color_header_fg'); ?>;
      }
      header > ul li a:hover,
      header > ul li.current > a,
      nav > ul li.current a,
      header h1,
      header h1 a,
      a:hover{
        color:<?php echo _settings('color_header_act'); ?>;
      }
      h1,h2,h3,h4,h5,h6{
        color:<?php echo _settings('color_h'); ?>;
      }
      .btn.btn-red{
        background: <?php echo _settings('color_button_bg'); ?>;
        color:<?php echo _settings('color_button_fg'); ?>;
      }
      .inputfile-1 + label {
          color: <?php echo _settings('color_button_fg'); ?>;
          background-color: <?php echo _settings('color_button_bg'); ?>;
      }
      label.radio > input:checked + img,
      label.radio > input:checked + i,
      label.radio > input:checked + span{
        	border-color: <?php echo _settings('color_button_bg'); ?>;
      }
      label.radio > input:checked + span{
        color: <?php echo _settings('color_button_bg'); ?>;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>

    <nav class="collapsed">
      <?php echo pageMenu(); ?>
    </nav>

    <!-- START - Topbar header -->
    <header class="full">

      <a class="navicon hidden-lg hidden-md"><i class="ion-navicon"></i></a>
      <h1><a href="<?php echo $url; ?>">
        <?php if(_settings('logo')=='none'){ ?>
        <?php echo _settings('app_name'); ?>
        <?php }else{ ?>

        <?php } ?>
      </a>
      </h1>

      <?php echo pageMenu(); ?>

      <div class="user clearfix">
        <span class="hidden-xs"><?php echo _('Pozdrav!'); ?> <?php echo $_user['fname'].' '.$_user['lname']; ?></b></span>
        <a class="dropdown-toggle" href="?action=logout" title="<?php echo _('Odjava!'); ?>"><i class="ion-log-out"></i></a>
      </div>

    </header>
    <!-- START - Topbar header -->
