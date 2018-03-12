<?php
  _pagePermission(3, false);

    $query = $db->query("SELECT * FROM presence where user_id='".$_user['user_id']."'");

     $get2 = $db->query("SELECT * FROM presence ORDER BY date_created DESC");
     $total = $get2->rowCount();
 

 ?>

<!-- START - Main section -->
<section class="full">

  <br/>

  <div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <div class="box">
          <div class="head" style="height:50px;">
            <lable > Korisnički podaci TEST</lable>
						<div class="box-head-btn">

							<a href="#" class="ion-ios-arrow-up" data-widget="collapse" data-id="c1a"></a>
						</div>
					</div>
					<div class="content" id="c1a" style="display: block;">

            <table class="alt">
              <tr>
                <td width="40%" class="text-center">
                  <?php if($_user['image'] != 'none'){ ?>
                    <img src="<?php echo $_timthumb.$_uploadUrl; ?>/<?php echo $_user['image']; ?>&w=200&h=200" class="img-circle" style="width:40%;">
                  <?php }else{ ?>
                    <img src="<?php echo $_themeUrl; ?>/images/noimage-user.png" class="img-circle" style="width:40%;">
                  <?php } ?>
                </td>
                <td>
                  <big><b><?php echo $_user['fname'].' '.$_user['lname']; ?></b></big><br/>
                  <?php echo _role($_user['role']); ?>
                </td>
              </tr>

             
            </table>

          </div>
        </div>
<?php 
if(($_user['role'])!=0) {

?>
           <div class="box">
          <div class="head" style="height:50px;">
             <lable > Odsustva</lable>
            <div class="box-head-btn">
              <a href="#" class="ion-ios-arrow-up" data-widget="collapse" data-id="c1b"></a>
            </div>
          </div>
          <div class="content" id="c1b" style="display: block;">

            <table class="alt">
      <?php
          if($total>0){
            $i = 0;


  

  

         ?>
        <thead>
          <tr>

            <th class="hidden-xs" width="200" ><?php echo _('Prisustvo'); ?></th>
            <th class="hidden-xs" width="200" ><?php echo _('Na dan'); ?></th>
            <th class="hidden-xs" width="200" ><?php echo _('Registrovano u'); ?></th>
            <th class="hidden-xs" width="700" ><?php echo _('Komentar'); ?></th>
           
          </tr>
        </thead>
        <tbody>
  <?php
            foreach($query as $uquery) {
    

  $presence = $uquery['presence'];
  $date = $uquery['date_presence'];
  $dateCreated = $uquery['date_created'];
  $comment = $uquery['comment'];


?>
              <td class="hidden-xs"><?php echo  _presence($presence); ?></td>
              <td ><?php echo date('d/m/Y',strtotime($date)); ?></td>
              <td ><?php echo date('H:i',strtotime($dateCreated)); ?></td>
              <td class="hidden-xs"><?php echo $comment; ?></td>
           
         
          



 <td class="hidden-xs"></td>
          </tr>
 
        </tbody>
        <?php } }else{ echo '<tr><td colspan="3" class="text-center">'._('Još nije bilo unosa').'</td></tr>'; } ?>



             
            </table>

          </div>

        </div>

<?php } ?>

      </div>

            


    </div>


  </div>


</section>
<!-- END - Main section -->

<?php

  include $_themeRoot.'/footer.php';

 ?>

</body>
</html>
