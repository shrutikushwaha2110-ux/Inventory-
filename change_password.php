<?php
  $x64 = 'Change Password';
  require_once('includes/load.php');
  
  fn_a28(3);
?>
<?php $x114 = fn_a5(); ?>
<?php
  if(isset($_POST['update'])){

    $x86 = array('new-password','old-password','id' );
    fn_a42($x86);

    if(empty($x25)){

             if(sha1($_POST['old-password']) !== fn_a5()['password'] ){
               $x97->msg('d', "Your old password not match");
               fn_a34('change_password.php',false);
             }

            $x40 = (int)$_POST['id'];
            $x55 = fn_a35($x20->escape(sha1($_POST['new-password'])));
            $x98 = "UPDATE users SET password ='{$x55}' WHERE id='{$x20->escape($x40)}'";
            $x88 = $x20->query($x98);
                if($x88 && $x20->affected_rows() === 1):
                  $x97->logout();
                  $x97->msg('s',"Login with your new password.");
                  fn_a34('index.php', false);
                else:
                  $x97->msg('d',' Sorry failed to updated!');
                  fn_a34('change_password.php', false);
                endif;
    } else {
      $x97->msg("d", $x25);
      fn_a34('change_password.php',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Change your password</h3>
     </div>
     <?php echo fn_a8($x53); ?>
      <form method="post" action="change_password.php" class="clearfix">
        <div class="form-group">
              <label for="newPassword" class="control-label">New password</label>
              <input type="password" class="form-control" name="new-password" placeholder="New password">
        </div>
        <div class="form-group">
              <label for="oldPassword" class="control-label">Old password</label>
              <input type="password" class="form-control" name="old-password" placeholder="Old password">
        </div>
        <div class="form-group clearfix">
               <input type="hidden" name="id" value="<?php echo (int)$x114['id'];?>">
                <button type="submit" name="update" class="btn btn-info">Change</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
