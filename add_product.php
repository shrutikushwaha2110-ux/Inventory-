<?php
  $x64 = 'Add Product';
  require_once('includes/load.php');
  
  fn_a28(2);
  $x3 = fn_a9('categories');
  $x5 = fn_a9('media');
?>
<?php
 if(isset($_POST['add_product'])){
   $x86 = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
   fn_a42($x86);
   if(empty($x25)){
     $x61  = fn_a35($x20->escape($_POST['product-title']));
     $x59   = fn_a35($x20->escape($_POST['product-categorie']));
     $x62   = fn_a35($x20->escape($_POST['product-quantity']));
     $x58   = fn_a35($x20->escape($_POST['buying-price']));
     $x63  = fn_a35($x20->escape($_POST['saleing-price']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
       $x51 = '0';
     } else {
       $x51 = fn_a35($x20->escape($_POST['product-photo']));
     }
     $x19    = fn_a25();
     $x78  = "INSERT INTO products (";
     $x78 .=" name,quantity,buy_price,sale_price,categorie_id,media_id,date";
     $x78 .=") VALUES (";
     $x78 .=" '{$x61}', '{$x62}', '{$x58}', '{$x63}', '{$x59}', '{$x51}', '{$x19}'";
     $x78 .=")";
     $x78 .=" ON DUPLICATE KEY UPDATE name='{$x61}'";
     if($x20->query($x78)){
       $x97->msg('s',"Product added ");
       fn_a34('add_product.php', false);
     } else {
       $x97->msg('d',' Sorry failed to added!');
       fn_a34('product.php', false);
     }

   } else{
     $x97->msg("d", $x25);
     fn_a34('add_product.php',false);
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
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Product Title">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                      <option value="">Select Product Category</option>
                    <?php  foreach ($x3 as $x11): ?>
                      <option value="<?php echo (int)$x11['id'] ?>">
                        <?php echo $x11['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value="">Select Product Photo</option>
                    <?php  foreach ($x5 as $x68): ?>
                      <option value="<?php echo (int)$x68['id'] ?>">
                        <?php echo $x68['file_name'] ?></option>
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
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity">
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="number" class="form-control" name="buying-price" placeholder="Buying Price">
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="number" class="form-control" name="saleing-price" placeholder="Selling Price">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
