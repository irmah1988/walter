<?php
  _pagePermission(2, false);
 ?>

<!-- START - Main section -->
<section class="full">

  <div class="container-fluid">


    <div class="row">

      <div class="col-sm-6">
        <h2>
          <?php echo _('Lista radnika'); ?><br/><br/>
        </h2>
      </div>
      <div class="col-sm-6 text-right"><br/>
        <div class="pull-right">
          <a href="<?php echo $url.'/modules/'.$_mod.'/pages/popup_users_add.php'; ?>" data-widget="ajax" data-id="opt2" data-width="500" class="btn btn-red btn-lg"><?php echo _('Novi radnik'); ?> 
            <i class="ion-ios-plus-empty"></i></a>
        </div>
        <form class="search" method="get">
          <input type="hidden" name="m" value="<?php echo $_mod; ?>">
          <input type="hidden" name="p" value="<?php echo $_page; ?>">
        </form>
      </div>

    </div>


    <?php

      $limit	= 20;

      if($_num){

        $offset = ($_num - 1) * $limit;

      }else{

        $offset = 0; $_num = 1;

      }

      $where = "";
      $path = '?m='.$_mod.'&p='.$_page;

      if(isset($_GET['t'])){
        $type = $_GET['t'];
        if($type=='inactive'){
          $where .= "WHERE status='1'";
        }else{
          $where .= "WHERE status='0' AND role='$type'";
        }
        $path .= '&t='.$type;
      }else{
        $type = '';
        $where = "WHERE status='0'";
      }

      if($_search){
        $where .= " AND fname LIKE '%$_search%' OR lname LIKE '%$_search%'";
        $path .= '&q='.$_search;
      }

      $path .= '&pg=';

      $query = $db->query("SELECT * FROM users ".$where." ORDER BY role ASC limit $offset, $limit");
      $get2 = $db->query("SELECT * FROM users ".$where." ORDER BY role ASC");
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
            <th width="70" class="hidden-xs"></th>
            <th><?php echo _('Radnik'); ?></th>
            <th class="hidden-xs"><?php echo _('Uloga'); ?></th>
            <th class="hidden-xs"><?php echo _('Izmjena'); ?></th>
            <th class="hidden-xs"><?php echo _('Brisanje'); ?></th>
            <th width="120"></th>
          </tr>
        </thead>
        <tbody>
          <?php
              foreach($query as $item){
                $i++;
                $tools_id = $item['user_id'];
          ?>
          <tr id="opt-<?php echo $tools_id; ?>">
            <td class="hidden-xs"><?php echo $tools_id; ?></td>
            <td class="text-center" class="hidden-xs">
              <?php if($item['image'] != 'none'){ ?>
                <img src="<?php echo $_timthumb.$_uploadUrl; ?>/<?php echo $item['image']; ?>" class="img-circle" style="width:100%;">
              <?php }else{ ?>
                <img src="<?php echo $_themeUrl; ?>/images/noimage-user.png" class="img-circle" style="width:100%;">
              <?php } ?>
            </td>
            <td><?php echo $item['fname'].' '.$item['lname']; ?><br/></td>
            <td class="hidden-xs"><?php echo _role($item['role']); ?></td>
            <td class="hidden-xs">
<!-- izmjena -->
   <a href="<?php echo $url.'/modules/'.$_mod.'/pages/popup_users_edit.php?id='.$tools_id; ?>" data-widget="ajax" data-id="opt2" data-width="500" class="table-btn"><i class="ion-edit">
            </td>
            <td class="hidden-xs">
<!-- brisanje -->
  <a href="<?php echo $url.'/modules/'.$_mod.'/ajax.php'; ?>" class="table-btn" data-widget="remove" data-id="users:<?php echo $tools_id; ?>" data-text="<?php echo _('Dali ste sigurni da želite deaktivirati korisnika:'); ?> <?php echo $item['user_id'].' '.$item['fname'].' '.$item['lname']; ?>"><i class="ion-android-close"></i></a>


</td>
 <td class="hidden-xs"></td>
          </tr>
          <?php } ?>
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


  </div>


</section>
<!-- END - Main section -->

<?php

  include $_themeRoot.'/footer.php';

 ?>

</body>
</html>
