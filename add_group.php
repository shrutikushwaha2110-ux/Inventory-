<?php
  $x64 = 'Add Group';
  require_once('includes/load.php');
  
   fn_a28(1);
?>
<?php
  if(isset($_POST['add'])){

   $x86 = array('group-name','group-level');
   fn_a42($x86);

   if(fn_a14($_POST['group-name']) === false ){
     $x97->msg('d','<b>Sorry!</b> Entered Group Name already in database!');
     fn_a34('add_group.php', false);
   }elseif(fn_a13($_POST['group-level']) === false) {
     $x97->msg('d','<b>Sorry!</b> Entered Group Level already in database!');
     fn_a34('add_group.php', false);
   }
   if(empty($x25)){
           $x54 = fn_a35($x20->escape($_POST['group-name']));
          $x45 = fn_a35($x20->escape($_POST['group-level']));
         $x101 = fn_a35($x20->escape($_POST['status']));

        $x78  = "INSERT INTO user_groups (";
        $x78 .="group_name,group_level,group_status";
        $x78 .=") VALUES (";
        $x78 .=" '{$x54}', '{$x45}','{$x101}'";
        $x78 .=")";
        if($x20->query($x78)){
          
          $x97->msg('s',"Group has been creted! ");
          fn_a34('add_group.php', false);
        } else {
          
          $x97->msg('d',' Sorry failed to create Group!');
          fn_a34('add_group.php', false);
        }
   } else {
     $x97->msg("d", $x25);
      fn_a34('add_group.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Add new user Group</h3>
     </div>
     <?php echo fn_a8($x53); ?>
      <form method="post" action="add_group.php" class="clearfix">
        <div class="form-group">
              <label for="name" class="control-label">Group Name</label>
              <input type="name" class="form-control" name="group-name">
        </div>
        <div class="form-group">
              <label for="level" class="control-label">Group Level</label>
              <input type="number" class="form-control" name="group-level">
        </div>
        <div class="form-group">
          <label for="status">Status</label>
            <select class="form-control" name="status">
              <option value="1">Active</option>
              <option value="0">Deactive</option>
            </select>
        </div>
        <div class="form-group clearfix">
                <button type="submit" name="add" class="btn btn-info">Update</button>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>
