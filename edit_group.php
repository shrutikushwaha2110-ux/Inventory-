<?php
  $x64 = 'Edit Group';
  require_once('includes/load.php');
  
   fn_a28(1);
?>
<?php
  $x22 = fn_a15('user_groups',(int)$_GET['id']);
  if(!$x22){
    $x97->msg("d","Missing Group id.");
    fn_a34('group.php');
  }
?>
<?php
  if(isset($_POST['update'])){

   $x86 = array('group-name','group-level');
   fn_a42($x86);
   if(empty($x25)){
           $x54 = fn_a35($x20->escape($_POST['group-name']));
          $x45 = fn_a35($x20->escape($_POST['group-level']));
         $x101 = fn_a35($x20->escape($_POST['status']));

        $x78  = "UPDATE user_groups SET ";
        $x78 .= "group_name='{$x54}',group_level='{$x45}',group_status='{$x101}'";
        $x78 .= "WHERE ID='{$x20->escape($x22['id'])}'";
        $x88 = $x20->query($x78);
         if($x88 && $x20->affected_rows() === 1){
          
          $x97->msg('s',"Group has been updated! ");
          fn_a34('edit_group.php?id='.(int)$x22['id'], false);
        } else {
          
          $x97->msg('d',' Sorry failed to updated Group!');
          fn_a34('edit_group.php?id='.(int)$x22['id'], false);
        }
   } else {
     $x97->msg("d", $x25);
    fn_a34('edit_group.php?id='.(int)$x22['id'], false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Edit Group</h3>
     </div>
     <?php echo fn_a8($x53); ?>
      <form method="post" action="edit_group.php?id=<?php echo (int)$x22['id'];?>" class="clearfix">
        <div class="form-group">
              <label for="name" class="control-label">Group Name</label>
              <input type="name" class="form-control" name="group-name" value="<?php echo fn_a35(ucwords($x22['group_name'])); ?>">
        </div>
        <div class="form-group">
              <label for="level" class="control-label">Group Level</label>
              <input type="number" class="form-control" name="group-level" value="<?php echo (int)$x22['group_level']; ?>">
        </div>
        <div class="form-group">
          <label for="status">Status</label>
              <select class="form-control" name="status">
                <option <?php if($x22['group_status'] === '1') echo 'selected="selected"';?> value="1"> Active </option>
                <option <?php if($x22['group_status'] === '0') echo 'selected="selected"';?> value="0">Deactive</option>
              </select>
        </div>
        <div class="form-group clearfix">
                <button type="submit" name="update" class="btn btn-info">Update</button>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>
