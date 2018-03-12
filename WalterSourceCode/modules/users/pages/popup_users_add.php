<?php
  require_once '../../../configuration.php';
  $_user = _user(_decrypt($_SESSION['SESSION_USER']));
 ?>
<div class="header">
	<a class="btn close" data-widget="close-ajax" data-id="opt2"><i class="ion-android-close"></i></a>
	<h4><span> <?php echo _('Novi unos'); ?></span></h4>
</div>

<section>
	<div class="content clear">

		<div id="res"></div>

		<form id="popup_form" method="post">

			<input type="hidden" name="request" value="user-add"/>


   <div class="row">

        <div class="col-sm-6">
          <label><?php echo _('Ime'); ?></label>
          <input type="text" name="fname" class="form-control" required>
        </div>
        <div class="col-sm-6">
          <label><?php echo _('Prezime'); ?></label>
          <input type="text" name="lname" class="form-control" required>
        </div>

      </div><br/>
<!-- 
      <div class="row">

        <div class="col-sm-5 text-center">
          <img src="<?php echo $_themeUrl; ?>/images/noimage-user.png" class="img-circle" style="width:70%;">
        </div>
        <div class="col-sm-7">
          <label><?php echo _('Fotografija'); ?></label>
          <input type="file" name="media_file" id="file-1" class="inputfile inputfile-1 big" accept="image/*" data-multiple-caption="{count} files selected"/>
          <label for="file-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
              <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
            </svg>
            <span><?php echo _('Odaberi'); ?>&hellip;</span>
          </label>
          <small><?php echo _('Dozvoljeni formati JPG/PNG/GIF. Preporućene dimenzije 480x640 px (portret).'); ?></small>
        </div>

      </div><br/> -->

 <div class="row">

        <div class="col-sm-12">
          <label><?php echo _('Nivo administracije'); ?></label>
          <select name="role" class="form-control" required>
            <?php echo _optionRole(); ?>
          </select>
        </div>

      </div><br/>

      <label><?php echo _('Korisničko ime'); ?></label>
      <input type="text" name="username" class="form-control" required><br/>

      <label><?php echo _('Lozinka'); ?></label>
      <input type="password" name="password" class="form-control" required><br/>

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
  		$('#date').datepicker({
  			todayBtn: "linked",
  			format: 'dd/mm/yyyy',
  			startDate: startDate
  		});
      $('.content').on('click','input[name=is_end_date]',function(){
        if($(this).is(':checked')){
          $('#dt').show();
          $(this).attr('required',true);
        }else{
          $('#dt').hide();
          $(this).attr('required',false);
        }
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
								url:"<?php echo $url.'/modules/users/ajax.php'; ?>",
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
