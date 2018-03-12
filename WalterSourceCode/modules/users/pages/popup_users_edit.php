<?php
  require_once '../../../configuration.php';
  include_once $root.'/modules/users/functions.php';
 ?>
 <div class="header">
 	<a class="btn close" data-widget="close-ajax" data-id="opt2"><i class="ion-android-close"></i></a>
 	<h4><span><?php echo _('Ažuriranje!'); ?></span></h4>
 </div>

 <section>
 	<div class="content clear">

     <?php
       $get = $db->query("SELECT * FROM users WHERE user_id='".$_GET['id']."'");
       if($get->rowCount()>0){
         $row = $get->fetch();
  
     ?>



		<div id="res"></div>

		<form id="popup_form" method="post" enctype="multipart/form-data">

			<input type="hidden" name="request" value="user-edit"/>
      <input type="hidden" name="request_id" value="<?php echo $row['user_id']; ?>"/>
      <input type="hidden" name="oldpass" value="<?php echo $row['password']; ?>"/>
      <input type="hidden" name="oldusername" value="<?php echo $row['username']; ?>"/>
      <input type="hidden" name="oldimage" value="<?php echo $row['image']; ?>"/>

      <div class="row">

        <div class="col-sm-6">
          <label><?php echo _('Ime'); ?></label>
          <input type="text" name="fname" value="<?php echo $row['fname']; ?>" class="form-control" required>
        </div>
        <div class="col-sm-6">
          <label><?php echo _('Prezime'); ?></label>
          <input type="text" name="lname" value="<?php echo $row['lname']; ?>" class="form-control" required>
        </div>

      </div><br/>

<!--       <div class="row">

        <div class="col-sm-5 text-center">
          <?php if($row['image'] != 'none'){ ?>
            <img src="<?php echo $_timthumb.$_uploadUrl; ?>/<?php echo $row['image']; ?>" class="img-circle" style="width:70%;">
          <?php }else{ ?>
            <img src="<?php echo $_themeUrl; ?>/images/noimage-user.png" class="img-circle" style="width:70%;">
          <?php } ?>
        </div>
      

      </div><br/> -->

       <div class="row">

        <div class="col-sm-12">
      
          <label><?php echo _('Nivo administracije'); ?></label>
          <select name="role" class="form-control" required>
            <?php echo _optionRole($row['role']); ?>
          </select>
        </div>

      </div><br/>

    

      <label><?php echo _('Korisničko ime'); ?></label>
      <input type="text" name="username" value="<?php echo $row['username']; ?>" class="form-control" required><br/>

     <label><?php echo _('Lozinka'); ?></label>
      <input type="password" name="password" value="<?php echo $row['password']; ?>" class="form-control" required><br/>
      <hr/>

      <button type="submit" class="btn btn-red pull-right"><?php echo _('Spasi!'); ?> <i class="ion-ios-download-outline"></i></button>


		</form>

    <script src="<?php echo $_pluginUrl; ?>/jquery/jquery.js"></script>
    <script src="<?php echo $_pluginUrl; ?>/validation/jquery.validate.min.js"></script>
    <script src="<?php echo $_pluginUrl; ?>/validation/jquery.form.js"></script>
		<script>
      $( document ).ready(function(){
        $('.dialog-loader').hide();
      });
      $("#popup_form").validate({
        focusCleanup: true,
            submitHandler: function(form) {
              $('.dialog-loader').show();
              $(form).ajaxSubmit({
                url:"<?php echo $url.'/modules/users/ajax.php'; ?>",
                type:"post",
                success: function(data){
                  $("#res").html(data);
                    $('.dialog-loader').hide();
                }
              });
            }
      });
		</script>

    <?php
      }else{
        echo '<div class="alert alert-danger"><b>'._('Greška!').'</b><br/>'._('Pogrešan ID stranice, molimo kontaktirajte administratora.').'</div>';
      }
     ?>

	</div>
  <div class="dialog-loader"><i></i></div>
</section>
