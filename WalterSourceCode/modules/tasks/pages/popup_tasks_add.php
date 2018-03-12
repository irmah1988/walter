<?php
  require_once '../../../configuration.php';
  $_user = _user(_decrypt($_SESSION['SESSION_USER']));
 ?>
<div class="header">
	<a class="btn close" data-widget="close-ajax" data-id="opt2"><i class="ion-android-close"></i></a>
	<h4><span><?php echo _('Daily Scrum'); ?> - <?php echo _('Novi unos'); ?></span></h4>
</div>

<section>
	<div class="content clear">

		<div id="res"></div>

		<form id="popup_form" method="post">

			<input type="hidden" name="request" value="tasks-add"/>


      <label><?php echo _('Radnik:'); ?></label>
      <select name="user" class="form-control" required>
        <option value=""><?php echo _('Odaberi'); ?></option>
        <?php
          $_user_role = $_user['role'];
          $get_users = $db->query("SELECT * FROM users WHERE role > '$_user_role'");
          if($get_users->rowCount()>0){
            foreach($get_users as $user){
              echo '<option value="'.$user['user_id'].'">'.$user['fname'].' '.$user['lname'].'</option>';
            }
          }
        ?>
      </select>

         <hr/>

          <label><?php echo _('Prisustvo'); ?></label>
          <select name="presence" class="form-control">
            <?php echo _optionPresence(2); ?>
          </select>

      <hr/>
 <label><?php echo _('Na dan:'); ?></label>
     
     <!--    <input type="text" name="date" class="form-control" id="date" placeholder="dd/mm/yyyy"> -->
         <div class="input-group input-daterange">
       <input type="text" name="date" class="form-control" required><br>
       </div>
    


      <hr/>

      <label><?php echo _('Komentar'); ?></label><br/>
      <textarea name="comment" class="form-control"></textarea><br/>


      <br/>

      <button type="submit" class="btn btn-red pull-right"><?php echo _('Spasi!'); ?> <i class="ion-ios-download-outline"></i></button>


		</form>

    <script src="<?php echo $_pluginUrl; ?>/jquery/jquery.js"></script>

    <!-- Bootstrap -->
    <script src="<?php echo $_jsUrl; ?>/bootstrap.min.js"></script>

    <!-- Bootstrap datepicker -->
    <script src="<?php echo $_pluginUrl; ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script src="<?php echo $_pluginUrl; ?>/validation/jquery.validate.min.js"></script>
    <script src="<?php echo $_pluginUrl; ?>/validation/jquery.form.js"></script>
		<script>
    $(function(){
     var today = new Date();
      var startDate = new Date();
      $('.input-daterange').datepicker({
        todayBtn: "linked",
        format: 'dd/mm/yyyy'
      });
        $( document ).ready(function(){
          $('.dialog-loader').hide();
        });
    });
			$("#popup_form").validate({
				focusCleanup: true,
						submitHandler: function(form) {
							$('.dialog-loader').show();
							$(form).ajaxSubmit({
								url:"<?php echo $url.'/modules/tasks/ajax.php'; ?>",
								type:"post",
								success: function(data){
									$("#popup_form")[0].reset();
									$("#res").html(data);
			    					$('.dialog-loader').hide();
								}
							});
						}
			});
		</script>

	</div>
  <div class="dialog-loader"><i></i></div>
</section>
