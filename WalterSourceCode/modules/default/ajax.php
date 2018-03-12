<?php

require_once '../../configuration.php';

  if(DEBUG){

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

  }

if(isset($_POST['request'])){


  if($_POST['request']=='request-add'){

    $_user = _user(_decrypt($_SESSION['SESSION_USER']));

    $ds   = explode('/', $_POST['from']);
    $de   = explode('/', $_POST['to']);

    $from = $ds[2].'-'.$ds[1].'-'.$ds[0];
    $to   = $de[2].'-'.$de[1].'-'.$de[0];

    $data = "INSERT INTO requests (
      user_id,parent_id,date_created,h_from,h_to,status,type) VALUES (?,?,?,?,?,?,?)";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_user['user_id'],
        $_user['parent'],
        date('Y-m-d H:i:s'),
        $from,
        $to,
        '0',
        'GO'
      )
    );
    if($res->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='year-add'){

    $_user = _user(_decrypt($_SESSION['SESSION_USER']));

    $data = "INSERT INTO hourlyrate_year (
      user_id,year) VALUES (?,?)";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_user['user_id'],
        $_POST['year']
      )
    );
    if($res->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='month-add'){

    $_user = _user(_decrypt($_SESSION['SESSION_USER']));

    $data = "INSERT INTO hourlyrate_month (
      user_id,year_id,month) VALUES (?,?,?)";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_user['user_id'],
        $_POST['year'],
        $_POST['month']
      )
    );
    if($res->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='day-add'){

    $_user = _user(_decrypt($_SESSION['SESSION_USER']));

    $data = "INSERT INTO hourlyrate_day (
      user_id,year_id,month_id,day,hour,status) VALUES (?,?,?,?,?,?)";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_user['user_id'],
        $_POST['year'],
        $_POST['month'],
        $_POST['day'],
        $_POST['hour'],
        $_POST['status']
      )
    );
    if($res->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='day-edit'){

    $this_id = $_POST['request_id'];
    $data = "UPDATE hourlyrate_day SET
      day = ?,
      hour = ?,
      status = ?
      WHERE id = ?";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_POST['day'],
        $_POST['hour'],
        $_POST['status'],
        $this_id
      )
    );
    if($res->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Izmjene su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='remove-requests_remove'){
    $this_id = $_POST['request_id'];
    $data = "DELETE FROM requests WHERE request_id = ?";
    $delete = $db->prepare($data);
    $delete->execute(array($this_id));
    if($delete){
      echo 1;
    }
  }


  if($_POST['request']=='remove-year_remove'){
    $this_id = explode('-',$_POST['request_id']);
    $this_id = $this_id[1];
    $data = "DELETE FROM hourlyrate_year WHERE id = ?";
    $delete = $db->prepare($data);
    $delete->execute(array($this_id));
    if($delete){
      echo 1;
    }
  }


  if($_POST['request']=='remove-month_remove'){
    $this_id = explode('-',$_POST['request_id']);
    $this_id = $this_id[1];
    $data = "DELETE FROM hourlyrate_month WHERE id = ?";
    $delete = $db->prepare($data);
    $delete->execute(array($this_id));
    if($delete){
      echo 1;
    }
  }


  if($_POST['request']=='remove-day_remove'){
    $this_id = $_POST['request_id'];
    $data = "DELETE FROM hourlyrate_day WHERE id = ?";
    $delete = $db->prepare($data);
    $delete->execute(array($this_id));
    if($delete){
      echo 1;
    }
  }


  if($_POST['request']=='remove-requests_archive'){

      $this_id = $_POST['request_id'];
      $data = "UPDATE requests SET
        is_archive = ?
        WHERE request_id = ?";

      $res = $db->prepare($data);
      $res->execute(
        array(
          '1',
          $this_id
        )
      );
      if($res->rowCount()==1) {
        echo 1;
      }

  }


  if($_POST['request']=='remove-tasks_archive'){

      $this_id = $_POST['request_id'];
      $data = "UPDATE tasks SET
        is_archive = ?
        WHERE task_id = ?";

      $res = $db->prepare($data);
      $res->execute(
        array(
          '1',
          $this_id
        )
      );
      if($res->rowCount()==1) {
        echo 1;
      }

  }


  if($_POST['request']=='accept-tasks'){

      $this_id = $_POST['request_id'];
      $data = "UPDATE tasks SET
        is_accepted = ?
        WHERE task_id = ?";

      $res = $db->prepare($data);
      $res->execute(
        array(
          '1',
          $this_id
        )
      );
      if($res->rowCount()==1) {
        echo 1;
      }

  }


  if($_POST['request']=='completed-tasks'){

      $this_id = $_POST['request_id'];
      $data = "UPDATE tasks SET
        is_finished = ?,
        date_finished = ?
        WHERE task_id = ?";

      $res = $db->prepare($data);
      $res->execute(
        array(
          '1',
          date('y-m-d H:i:s'),
          $this_id
        )
      );
      if($res->rowCount()==1) {
        echo 1;
      }

  }


  if($_POST['request']=='task-comment'){

    $data3 = "INSERT INTO comments (
      type,user_id,comment,date_created,comment_on) VALUES (?,?,?,?,?)";

    $res3 = $db->prepare($data3);
    $res3->execute(
      array(
        'task',
        $_POST['user_id'],
        $_POST['comment'],
        date('Y-m-d H:i:s'),
        $_POST['comment_on']
      )
    );
    if($res3->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='proc-tasks'){

      $this_id = $_POST['request_id'];
      $data = "UPDATE tasks_item SET
        status = ?,
        date_completed = ?
        WHERE taskitem_id = ?";

      $res = $db->prepare($data);
      $res->execute(
        array(
          $_POST['status'],
          date('y-m-d H:i:s'),
          $this_id
        )
      );
      if($res->rowCount()==1) {
        echo 1;
      }

  }


  if($_POST['request']=='count-tasks'){

      $this_id = $_POST['request_id'];
      $total_0 = $db->query("SELECT * FROM tasks_item WHERE task_id='$this_id'")->rowCount();
      $total_1 = $db->query("SELECT * FROM tasks_item WHERE task_id='$this_id' AND status='1'")->rowCount();

      if($total_1==$total_0){
        echo 'yes';
      }else{
        echo 'no';
      }

  }


  if($_POST['request']=='comments'){

    $user_id = $_POST['user'];
    $parent_id = $_POST['parent'];

    $comments = $db->query("SELECT * FROM comments WHERE comment_on='".$_POST['request_id']."' AND type='task'");
    if($comments->rowCount()>0){

      $user = _user($user_id);
      $parent = _user($parent_id);

      foreach($comments as $item){
        echo '<div class="comment">';
        if($item['user_id']==$user_id){
          echo '<div class="row">';
          echo '<div class="col-xs-9"><div class="text-u">';
          echo $item['comment'];
          echo '</div><small class="text-muted">'.date('d.m.Y H:i', strtotime($item['date_created'])).'</small></div>';
          echo '<div class="col-xs-3 text-center">';
          if($user['image'] != 'none'){
            echo '<img src="'.$_timthumb.$_uploadUrl.'/'.$user['image'].'&w=200&h=200" class="img-circle" style="width:70%;">';
          }else{
            echo '<img src="'.$_themeUrl.'/images/noimage-user.png" class="img-circle" style="width:70%;">';
          }
          echo '<br/><small>'.$user['fname'].' '.$user['lname'].'</small>';
          echo '</div>';
          echo '</div>';
        }else if($item['user_id']==$parent_id){
          echo '<div class="row">';
          echo '<div class="col-xs-3 text-center">';
          if($parent['image'] != 'none'){
            echo '<img src="'.$_timthumb.$_uploadUrl.'/'.$parent['image'].'&w=200&h=200" class="img-circle" style="width:70%;">';
          }else{
            echo '<img src="'.$_themeUrl.'/images/noimage-user.png" class="img-circle" style="width:70%;">';
          }
          echo '<br/><small>'.$parent['fname'].' '.$parent['lname'].'</small>';
          echo '</div>';
          echo '<div class="col-xs-9"><div class="text-p">';
          echo $item['comment'];
          echo '</div><small class="pull-right text-muted">'.date('d.m.Y H:i', strtotime($item['date_created'])).'</small></div>';
          echo '</div>';
        }
        echo '</div>';
      }
    }

  }



  if($_POST['request']=='profile-edit'){

    if($_POST['f4'] != ''){
      $pass = md5($_POST['f4']);
    }else{
      $pass = $_POST['oldpass'];
    }

    $check = $db->query("SELECT * FROM users WHERE username='".$_POST['username']."'");
    if($check->rowCount()>0){
      if($_POST['username'] == $_POST['oldusername']){
        $username = $_POST['username'];
      }else{
        $username = false;
      }
    }else{
      $username = $_POST['username'];
    }

    if(isset($_FILES['media_file'])){
      if(is_uploaded_file($_FILES['media_file']['tmp_name'])){
        $p_photo   = preg_replace('/[^\w\._]+/', '_', $_FILES['media_file']['name']);
        $p_photo = _checkFile($_uploadRoot.'/', $p_photo);
        $file = $_uploadRoot.'/'.$p_photo;
        if(copy($_FILES['media_file']['tmp_name'], $file)){
          unlink($_uploadRoot.'/'.$_POST['oldimage']);
        }
      }else{
          $p_photo = $_POST['oldimage'];
      }
    }else{
      $p_photo = $_POST['oldimage'];
    }

    if($username != false){

      $this_id = $_POST['request_id'];
      $data = "UPDATE users SET
        username = ?,
        password = ?,
        email = ?,
        image = ?,
        fname = ?,
        lname = ?,
        address = ?,
        zip = ?,
        city = ?,
        country = ?,
        phone = ?,
        lang = ?
        WHERE user_id = ?";

      $res = $db->prepare($data);
      $res->execute(
        array(
          $_POST['username'],
          $pass,
          $_POST['email'],
          $p_photo,
          $_POST['fname'],
          $_POST['lname'],
          $_POST['address'],
          $_POST['zip'],
          $_POST['city'],
          $_POST['country'],
          $_POST['phone'],
          $_POST['lang'],
          $this_id
        )
      );
      if($res->rowCount()==1) {
        echo '{"jsonrpc" : "2.0", "status" : "ok", "msg" : "<div class=\"alert alert-success text-center\">'._('Informacije su uspješno sapšene!').'</div>"}';
      }

    }else{

      echo '{"jsonrpc" : "2.0", "status" : "ok", "msg" : "<div class=\"alert alert-danger text-center\">'._('Korisničko ime je zauzeto. Molimo pokušajte sa nekim drugim.').'</div>"}';

    }

  }


}


?>
