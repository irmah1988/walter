<?php


// check page permission
function _pagePermission($level, $strict=false){
  global $url;

  if(!isset($_SESSION['SESSION_USER']) || (trim($_SESSION['SESSION_USER'])=='')){
    echo '<script>window.location.href="'.$url.'/modules/default/login.php";</script>';
  }else{

    global $_user;


    if($strict==false){
      if($_user['role'] > $level){
        echo '<script>window.location.href="'.$url.'/modules/default/unauthorized.php";</script>';
      }
    }else{
      if($_user['role'] != $level){
        echo '<script>window.location.href="'.$url.'/modules/default/unauthorized.php";</script>';
      }
    }

  }

}


// Dropdown select for roles
function _optionRole($current=null){
  global $db;

  $roles = array(
    '0'=>_('Administrator'),
    '1'=>_('Zaposlenik')
  );

  $opt = '<option value="">'._('Odaberi...').'</option>';

  foreach($roles as $key=>$value){
    if($current==$key){
      $sel = 'selected="selected"';
    }else{
      $sel = '';
    }
    $opt .= '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
  }

  return $opt;

}


function _optionPresence($current=null){
  global $db;

  $roles = array(
    '0'=>_('DA'),
    '1'=>_('NE')
  );

  $opt = '<option value=2>'._('Odaberi...').'</option>';

  foreach($roles as $key=>$value){
    if($current==$key){
      $sel = 'selected="selected"';
    }else{
      $sel = '';
    }
    $opt .= '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
  }

  return $opt;

}


// Dropdown select for languages
function _optionLang($current){
  global $db;

  $opt = '<option value="">'._('Odaberi...').'</option>';

  $query = $db->query("SELECT * FROM languages ORDER BY lang_name ASC");
  if($query->rowCount()>0){

    foreach($query as $item){
      if($current==$item['lang_id']){
        $sel = 'selected="selected"';
      }else{
        $sel = '';
      }
      $opt .= '<option value="'.$item['lang_id'].'" '.$sel.'>'.$item['lang_name'].'</option>';
    }

  }else{

    $opt = '<option value="">'._('Nema dostupnih jezika.').'</option>';

  }

  return $opt;

}


// Dropdown select for languages
function _optionUser($current){
  global $db;

  $opt = '<option value="">'._('Odaberi...').'</option>';

  $query = $db->query("SELECT * FROM users WHERE role='0' ORDER BY fname ASC");
  if($query->rowCount()>0){

    $opt .= '<optgroup label="'._role(0).'">';
    foreach($query as $item){
      if($current==$item['user_id']){
        $sel = 'selected="selected"';
      }else{
        $sel = '';
      }
      $opt .= '<option value="'.$item['user_id'].'" '.$sel.'>'.$item['fname'].' '.$item['lname'].'</option>';
    }
    $opt .= '</optgroup>';

  }
  $query = $db->query("SELECT * FROM users WHERE role='1' ORDER BY fname ASC");
  if($query->rowCount()>0){

    $opt .= '<optgroup label="'._role(1).'">';
    foreach($query as $item){
      if($current==$item['user_id']){
        $sel = 'selected="selected"';
      }else{
        $sel = '';
      }
      $opt .= '<option value="'.$item['user_id'].'" '.$sel.'>'.$item['fname'].' '.$item['lname'].'</option>';
    }
    $opt .= '</optgroup>';

  }

  return $opt;

}




// Get username by login session ID
function _user($id){
  global $db;

  $query = $db->query("SELECT * FROM users WHERE user_id='$id'");
  if($query->rowCount()>0){

    $row = $query->fetch();
    return $row;

  }

}


function _role($role){

  if($role==0){
    return _('Administrator');
  }else if($role==1){
    return _('Zaposlenik');
  }

}


function _presence($role){

  if($role==0){
    return _('DA');
  }else if($role==1){
    return _('NE');
  }

}

// Encrypt string
function _encrypt( $q ) {

    $encoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( ENC_KEY ), $q, MCRYPT_MODE_CBC, md5( md5( ENC_KEY ) ) ) );
    return( $encoded );

}


// Decrypt string
function _decrypt( $q ) {

    $decoded = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( ENC_KEY ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( ENC_KEY ) ) ), "\0");
    return( $decoded );

}


// Pagination
function _pagination($path, $page, $limit, $total){
	$adjacents = 3;
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total/$limit);
	$lpm1 = $lastpage - 1;
	$pagination = "";
	if($lastpage > 1){
		if ($page > 1)
			$pagination.= "<a class='btn btn-default' href='".$path.$prev."'><i class='ion-ios-arrow-left'></i></a>";
		else
			$pagination.= "<span  class='btn btn-default disabled'>«</span>";
		if ($lastpage < 7 + ($adjacents * 2)){
			for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $page)
					$pagination.= "<span  class='btn btn-default active'>".$counter."</span>";
				else
					$pagination.= "<a class='btn btn-default' href='".$path.$counter."'>$counter</a>";
			}
		}elseif($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents * 2)){
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if ($counter == $page)
						$pagination.= "<span  class='btn btn-default active'>".$counter."</span>";
					else
						$pagination.= "<a class='btn btn-default' href='".$path.$counter."'>".$counter."</a>";
				}
				$pagination.= "<span  class='btn btn-default'>...</span>";
				$pagination.= "<a class='btn btn-default' href='".$path.$lpm1."'>".$lpm1."</a>";
				$pagination.= "<a class='btn btn-default' href='".$path.$lastpage."'>".$lastpage."</a>";
			}elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
				$pagination.= "<a class='btn btn-default' href='".$path."1'>1</a>";
				$pagination.= "<a class='btn btn-default' href='".$path."2'>2</a>";
				$pagination.= "<span  class='btn btn-default'>...</span>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if ($counter == $page)
						$pagination.= "<span  class='btn btn-default active'>".$counter."</span>";
					else
						$pagination.= "<a class='btn btn-default' href='".$path.$counter."'>".$counter."</a>";
				}
				$pagination.= "<span  class='btn btn-default'>...</span>";
				$pagination.= "<a class='btn' href='".$path.$lpm1."'>".$lpm1."</a>";
				$pagination.= "<a class='btn' href='".$path.$lastpage."'>".$lastpage."</a>";
			}else{
				$pagination.= "<a class='btn btn-default' href='".$path."1'>1</a>";
				$pagination.= "<a class='btn btn-default' href='".$path."2'>2</a>";
				$pagination.= "<span  class='btn btn-default'>...</span>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if ($counter == $page)
						$pagination.= "<span  class='btn btn-default active'>".$counter."</span>";
					else
						$pagination.= "<a class='btn btn-default' href='".$path.$counter."'>".$counter."</a>";
				}
			}
		}
		if ($page < $counter - 1)
			$pagination.= "<a class='btn btn-default' href='".$path.$next."'><i class='ion-ios-arrow-right'></i></a>";
		else
			$pagination.= "<span  class='btn btn-default disabled'>»</span>";
	}
	return $pagination;
}


function _url($string){
		setlocale(LC_ALL, 'en_US.UTF8');
		$string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		$string = strtolower($string);
		$string = substr($string, 0, 128);
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		$string = preg_replace("/[\s-]+/", " ", $string);
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}





    function _settings($key, $default=NULL){
  		global $db;

  		$get = $db->query("SELECT * FROM settings WHERE name='$key'");

  		if($get->rowCount()>0){
  			$row = $get->fetch();
  			return $row['value'];
  		}else{
        if($default==NULL){
          return '';
        }else{
          return $default;
        }
      }

  	}






 ?>
