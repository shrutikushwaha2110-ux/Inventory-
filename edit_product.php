<?php
  $x64 = 'Edit product';
  require_once('includes/load.php');
  
   fn_a28(2);
?>
<?php
$x69 = fn_a15('products',(int)$_GET['id']);
$x3 = fn_a9('categories');
$x5 = fn_a9('media');
if(!$x69){
  $x97->msg("d","Missing product id.");
  fn_a34('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $x86 = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
    fn_a42($x86);

   if(empty($x25)){
       $x61  = fn_a35($x20->escape($_POST['product-title']));
       $x59   = (int)$_POST['product-categorie'];
       $x62   = fn_a35($x20->escape($_POST['product-quantity']));
       $x58   = fn_a35($x20->escape($_POST['buying-price']));
       $x63  = fn_a35($x20->escape($_POST['saleing-price']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $x51 = '0';
       } else {
         $x51 = fn_a35($x20->escape($_POST['product-photo']));
       }
       $x78   = "UPDATE products SET";
       $x78  .=" name ='{$x61}', quantity ='{$x62}',";
       $x78  .=" buy_price ='{$x58}', sale_price ='{$x63}', categorie_id ='{$x59}',media_id='{$x51}'";
       $x78  .=" WHERE id ='{$x69['id']}'";
       $x88 = $x20->query($x78);
               if($x88 && $x20->affected_rows() === 1){
                 $x97->msg('s',"Product updated ");
                 fn_a34('product.php', false);
               } else {
                 $x97->msg('d',' Sorry failed to updated!');
                 fn_a34('edit_product.php?id='.$x69['id'], false);
               }

   } else{
       $x97->msg("d", $x25);
       fn_a34('edit_product.php?id='.$x69['id'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$x69['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo fn_a35($x69['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                    <option value=""> Select a categorie</option>
                   <?php  foreach ($x3 as $x11): ?>
                     <option value="<?php echo (int)$x11['id']; ?>" <?php if($x69['categorie_id'] === $x11['id']): echo "selected"; endif; ?> >
                       <?php echo fn_a35($x11['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value=""> No image</option>
                      <?php  foreach ($x5 as $x68): ?>
                        <option value="<?php echo (int)$x68['id'];?>" <?php if($x69['media_id'] === $x68['id']): echo "selected"; endif; ?> >
                          <?php echo $x68['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" value="<?php echo fn_a35($x69['quantity']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Buying price</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="number" class="form-control" name="buying-price" value="<?php echo fn_a35($x69['buy_price']);?>">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Selling price</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <input type="number" class="form-control" name="saleing-price" value="<?php echo fn_a35($x69['sale_price']);?>">
                       <span class="input-group-addon">.00</span>
                    </div>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="product" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
