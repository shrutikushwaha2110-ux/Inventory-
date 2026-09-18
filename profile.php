<?php
  $x64 = 'My profile';
  require_once('includes/load.php');
  
   fn_a28(3);
?>
  <?php
  $x116 = (int)$_GET['id'];
  if(empty($x116)):
    fn_a34('home.php',false);
  else:
    $x119 = fn_a15('users',$x116);
  endif;
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-4">
       <div class="panel profile">
         <div class="jumbotron text-center bg-red">
            <img class="img-circle img-size-2" src="uploads/users/<?php echo $x119['image'];?>" alt="">
           <h3><?php echo fn_a22($x119['name']); ?></h3>
         </div>
        <?php if( $x119['id'] === $x114['id']):?>
         <ul class="nav nav-pills nav-stacked">
          <li><a href="edit_account.php"> <i class="glyphicon glyphicon-edit"></i> Edit profile</a></li>
         </ul>
       <?php endif;?>
       </div>
   </div>
</div>
<?php include_once('layouts/footer.php'); ?>
