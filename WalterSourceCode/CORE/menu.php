<?php

// Admin menu
function pageMenu(){
  global $_page, $_mod, $_user;

  $list_pages = array(

      'default'=>array(
      'name'=>_('Profil'),
      'icon'=>'ion-ios-person',
      'page'=>'profile',
      'role'=>array('0','1'),
      'subpages'=>array()

    ),
 'users'=>array(
      'name'=>_('Lista radnika'),
      'icon'=>'ion-ios-people',
      'page'=>'all',
      'role'=>array('0'),
      'subpages'=>array()
    ),

 'tasks'=>array(
      'name'=>_('Daily Scrum'),
      'icon'=>'ion-ios-clock',
      'page'=>'all',
      'role'=>array('0'),
      'subpages'=>array()
    ),

  
   
   

  );

  $menu = '<ul>';
  $i		= 0;

  foreach($list_pages as $slug=>$pages){

    $i++;
    $count_sub = count($pages['subpages']);
    if($_mod==$slug){
      $sel1 = ' class="current"';
    }else{
      $sel1 = '';
    }

    if(in_array($_user['role'], $pages['role'])){

      $menu .= '<li'.$sel1.'><a href="?m='.$slug.'&p='.$pages['page'].'"><i class="'.$pages['icon'].'"></i> <span>'.$pages['name'].'</span></a>';

      if($count_sub>0){

        $menu .= '<i class="ion-ios-arrow-down pull-right show-ul" id="ul'.$i.'"></i>';
        $menu .= '<ul id="ul'.$i.'">';
        $menu .= '<li class="main"><a href="?m='.$slug.'&p='.$slug.'">'.$pages['name'].'</a></li>';

        foreach($pages['subpages'] as $slug_sub=>$pages_sub){

          if($_page==$slug_sub){
            $sel2 = ' class="current"';
          }else{
            $sel2 = '';
          }

          if(in_array($_user['role'], $pages_sub['role'])){
            $menu .= '<li'.$sel2.'><a href="?m='.$slug.'&p='.$slug_sub.'">'.$pages_sub['name'].'</a></li>';
          }

        }

        $menu .= '</ul>';

      }

      $menu .='</li>';

    }

  }

  $menu .= '</ul>';

  return $menu;
}

 ?>
