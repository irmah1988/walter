<?php
  _pagePermission(1, false);
   $_user = _user(_decrypt($_SESSION['SESSION_USER']));

 ?>

<!-- START - Main section -->
<section class="full">

  <div class="container-fluid">


    <div class="row">

      <div class="col-sm-6">
        <h2>
          <?php echo _('Daily Scrum'); ?><br/><br/>
        </h2>
      </div>
      <div class="col-sm-6 text-right"><br/>
        <div class="pull-right">
          <a href="<?php echo $url.'/modules/'.$_mod.'/pages/popup_tasks_add.php'; ?>" data-widget="ajax" data-id="opt2" data-width="500" class="btn btn-red btn-lg"><?php echo _('Novi unos'); ?> <i class="ion-ios-plus-empty"></i></a>
        </div>
      </div>

    </div>

    <?php

      $limit	= 20;

      if($_num){

        $offset = ($_num - 1) * $limit;

      }else{

        $offset = 0; $_num = 1;

      }

      $path = '?m='.$_mod.'&p='.$_page;

      if(isset($_GET['t'])){
        $type = $_GET['t'];
        $where .= " AND is_archive='1'";
        $path .= '&t='.$type;
      }else{
        $type = '';

      }

      if(isset($_GET['u'])){
        $usr = $_GET['u'];
        if($usr != ''){
          $where .= " AND user_id='".$usr."'";
          $path .= '&u='.$usr;
        }else{
          $usr = '';
          $where .= "";
        }
      }else{
        $usr = '';
  
      }

      if(isset($_GET['d'])){
        $dt = $_GET['d'];
        if($dt != ''){
          $where .= " AND date_created LIKE '%$dt%'";
          $path .= '&d='.$dt;
        }else{
          $dt = '';
          $where .= "";
        }
      }else{
        $dt = '';
  
      }

      $path .= '&pg=';

      $query = $db->query("SELECT * FROM presence ORDER BY date_created DESC limit $offset, $limit");
      $get2 = $db->query("SELECT * FROM presence ORDER BY date_created DESC");
      $total = $get2->rowCount();

    


     ?>


    <div class="box">
      <div class="content">
      <table class="table table-hover">
        <?php
          if($total>0){
            $i = 0;
         ?>
        <thead>
          <tr>
            <th width="40" class="hidden-xs"><?php echo _('ID'); ?></th>
         
            <th class="hidden-xs" width="200"><?php echo _('Radnik'); ?></th>
            <th class="hidden-xs" width="200" ><?php echo _('Prisustvo'); ?></th>
            <th class="hidden-xs" width="200" ><?php echo _('Na dan'); ?></th>
            <th class="hidden-xs" width="200" ><?php echo _('Registrovano u'); ?></th>
            <th class="hidden-xs" width="700" ><?php echo _('Komentar'); ?></th>
           
          </tr>
        </thead>
        <tbody>
          <?php
              foreach($query as $item){
                $i++;
                $tools_id = $item['user_id'];
                $dateP = $item['date_presence'];
                $presence = $item['presence'];
                $dateCreated = $item['date_created'];
                $comment = $item['comment'];

                $user_c = $db->query("SELECT * FROM users WHERE user_id='$tools_id'");

                foreach($user_c as $c){
                 $fname = $c['fname'];
                 $lname = $c['lname'];
                }


          ?>
          <tr id="opt-<?php echo $tools_id; ?>">
            <td class="hidden-xs"><?php echo $tools_id; ?></td>
             <td class="hidden-xs"><?php echo $fname.' '.$lname; ?></td>
                <td class="hidden-xs"><?php echo _presence($item['presence']); ?></td>
              <td ><?php echo date('d/m/Y',strtotime($dateP)); ?></td>
              <td ><?php echo date('H:i',strtotime($dateCreated)); ?></td>
              <td class="hidden-xs"><?php echo $comment; ?></td>
           
         
          

<!--               <td class="text-center" class="hidden-xs">
              <?php if($item['image'] != 'none'){ ?>
                <img src="<?php echo $_timthumb.$_uploadUrl; ?>/<?php echo $item['image']; ?>" class="img-circle" style="width:100%;">
              <?php }else{ ?>
                <img src="<?php echo $_themeUrl; ?>/images/noimage-user.png" class="img-circle" style="width:100%;">
              <?php } ?>
            </td> -->

          <!--   <td><?php echo $item['fname'].' '.$item['lname']; ?><br/></td> -->
            <!-- <td class="hidden-xs"><?php echo _role($item['role']); ?></td> -->
          



 <td class="hidden-xs"></td>
          </tr>
          <?php 
 } ?>
        </tbody>
        <?php }else{ echo '<tr><td colspan="3" class="text-center">'._('Još nije bilo unosa').'</td></tr>'; } ?>
      </table>
      <div class="text-right">
        <div class="btn-group">
        <?php echo _pagination($path, $_num, $limit, $total); ?>
        </div>
      </div>
    </div>
    </div>


    <div class="text-center">
      <div class="btn-group">
      <?php echo _pagination($path, $_num, $limit, $total); ?>
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
