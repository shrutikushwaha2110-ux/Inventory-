<?php
  $x64 = 'Edit categorie';
  require_once('includes/load.php');
  
  fn_a28(1);
?>
<?php
  
  $x13 = fn_a15('categories',(int)$_GET['id']);
  if(!$x13){
    $x97->msg("d","Missing categorie id.");
    fn_a34('categorie.php');
  }
?>

<?php
if(isset($_POST['edit_cat'])){
  $x85 = array('categorie-name');
  fn_a42($x85);
  $x12 = fn_a35($x20->escape($_POST['categorie-name']));
  if(empty($x25)){
        $x98 = "UPDATE categories SET name='{$x12}'";
       $x98 .= " WHERE id='{$x13['id']}'";
     $x88 = $x20->query($x98);
     if($x88 && $x20->affected_rows() === 1) {
       $x97->msg("s", "Successfully updated Categorie");
       fn_a34('categorie.php',false);
     } else {
       $x97->msg("d", "Sorry! Failed to Update");
       fn_a34('categorie.php',false);
     }
  } else {
    $x97->msg("d", $x25);
    fn_a34('categorie.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo fn_a8($x53); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editing <?php echo fn_a35(ucfirst($x13['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_categorie.php?id=<?php echo (int)$x13['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="categorie-name" value="<?php echo fn_a35(ucfirst($x13['name']));?>">
           </div>
           <button type="submit" name="edit_cat" class="btn btn-primary">Update categorie</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
