<?php
  $x64 = 'Add Transfer';
  require_once('includes/load.php');

   fn_a28(3);
   $x2 = fn_a9('products');
   $x1 = fn_a9('locations');
?>
<?php
 if(isset($_POST['add_transfer'])){
   $x86 = array('transfer-product','transfer-source','transfer-destination','transfer-qty' );
   fn_a42($x86);
   if(empty($x25)){
     $x129 = (int)$_POST['transfer-product'];
     $x130 = (int)$_POST['transfer-source'];
     $x131 = (int)$_POST['transfer-destination'];
     $x132 = (int)$_POST['transfer-qty'];
     if($x130 === $x131){
       $x97->msg("d", "Source and destination location can't be the same.");
       fn_a34('add_transfer.php', false);
     }
     $x133 = fn_a49($x129,$x130);
     if($x132 > $x133){
       $x134 = max(0, $x133);
       $x97->msg("d", "Not enough stock at the source location (has {$x134} available, tried to transfer {$x132}).");
       fn_a34('add_transfer.php', false);
     }
     if(fn_a46($x129,$x130,$x131,$x132)){
       $x97->msg('s',"Transfer recorded ");
       fn_a34('add_transfer.php', false);
     } else {
       $x97->msg('d',' Sorry failed to record transfer!');
       fn_a34('add_transfer.php', false);
     }
   } else{
     $x97->msg("d", $x25);
     fn_a34('add_transfer.php',false);
   }
 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo fn_a8($x53); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-transfer"></span>
            <span>Record Stock Transfer</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_transfer.php" class="clearfix">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <select class="form-control" name="transfer-product">
                      <option value="">Select Product</option>
                    <?php  foreach ($x2 as $x11): ?>
                      <option value="<?php echo (int)$x11['id'] ?>">
                        <?php echo fn_a35($x11['name']) ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                   <label for="transfer-source"> Source Location </label>
                   <select class="form-control" name="transfer-source">
                     <option value="">Select Source Location</option>
                   <?php  foreach ($x1 as $x68): ?>
                     <option value="<?php echo (int)$x68['id'] ?>">
                       <?php echo fn_a35($x68['name']) ?></option>
                   <?php endforeach; ?>
                   </select>
                 </div>
                 <div class="col-md-6">
                   <label for="transfer-destination"> Destination Location </label>
                   <select class="form-control" name="transfer-destination">
                     <option value="">Select Destination Location</option>
                   <?php  foreach ($x1 as $x68): ?>
                     <option value="<?php echo (int)$x68['id'] ?>">
                       <?php echo fn_a35($x68['name']) ?></option>
                   <?php endforeach; ?>
                   </select>
                 </div>
               </div>
              </div>
              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-transfer"></i>
                     </span>
                     <input type="number" class="form-control" name="transfer-qty" placeholder="Quantity to transfer">
                  </div>
                 </div>
               </div>
              </div>
              <button type="submit" name="add_transfer" class="btn btn-danger">Record transfer</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
