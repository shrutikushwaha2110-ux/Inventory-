<?php
  $x64 = 'Edit Account';
  require_once('includes/load.php');
   fn_a28(3);
?>
<?php

  if(isset($_POST['submit'])) {
  $x68 = new ClassB1();
  $x116 = (int)$_POST['user_id'];
  $x68->upload($_FILES['file_upload']);
  if($x68->fn_a30($x116)){
    $x97->msg('s','photo has been uploaded.');
    fn_a34('edit_account.php');
    } else{
      $x97->msg('d',join($x68->x25));
      fn_a34('edit_account.php');
    }
  }
?>
<?php
 
  if(isset($_POST['update'])){
    $x86 = array('name','username' );
    fn_a42($x86);
    if(empty($x25)){
             $x40 = (int)$_SESSION['user_id'];
           $x54 = fn_a35($x20->escape($_POST['name']));
       $x120 = fn_a35($x20->escape($_POST['username']));
            $x98 = "UPDATE users SET name ='{$x54}', username ='{$x120}' WHERE id='{$x40}'";
    $x88 = $x20->query($x98);
          if($x88 && $x20->affected_rows() === 1){
            $x97->msg('s',"Acount updated ");
            fn_a34('edit_account.php', false);
          } else {
            $x97->msg('d',' Sorry failed to updated!');
            fn_a34('edit_account.php', false);
          }
    } else {
      $x97->msg("d", $x25);
      fn_a34('edit_account.php',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo fn_a8($x53); ?>
  </div>
  <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span>Change My photo</span>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
                <img class="img-circle img-size-2" src="uploads/users/<?php echo $x114['image'];?>" alt="">
            </div>
            <div class="col-md-8">
              <form class="form" action="edit_account.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" name="file_upload" multiple="multiple" class="btn btn-default btn-file"/>
              </div>
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $x114['id'];?>">
                 <button type="submit" name="submit" class="btn btn-warning">Change</button>
              </div>
             </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Edit My Account</span>
      </div>
      <div class="panel-body">
          <form method="post" action="edit_account.php?id=<?php echo (int)$x114['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input type="name" class="form-control" name="name" value="<?php echo fn_a35(ucwords($x114['name'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo fn_a35(ucwords($x114['username'])); ?>">
            </div>
            <div class="form-group clearfix">
                    <a href="change_password.php" title="change password" class="btn btn-danger pull-right">Change Password</a>
                    <button type="submit" name="update" class="btn btn-info">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php include_once('layouts/footer.php'); ?>
