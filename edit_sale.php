<?php
  $x64 = 'Edit sale';
  require_once('includes/load.php');
  
   fn_a28(3);
?>
<?php
$x94 = fn_a15('sales',(int)$_GET['id']);
if(!$x94){
  $x97->msg("d","Missing product id.");
  fn_a34('sales.php');
}
?>
<?php $x69 = fn_a15('products',$x94['product_id']); ?>
<?php

  if(isset($_POST['update_sale'])){
    $x86 = array('title','quantity','price','total', 'date' );
    fn_a42($x86);
        if(empty($x25)){
          $x60      = $x20->escape((int)$x69['id']);
          $x92     = $x20->escape((int)$_POST['quantity']);
          $x93   = $x20->escape($_POST['total']);
          $x19      = $x20->escape($_POST['date']);
          $x91    = date("Y-m-d", strtotime($x19));

          $x98  = "UPDATE sales SET";
          $x98 .= " product_id= '{$x60}',qty={$x92},price='{$x93}',date='{$x91}'";
          $x98 .= " WHERE id ='{$x94['id']}'";
          $x88 = $x20->query($x98);
          if( $x88 && $x20->affected_rows() === 1){
                    fn_a39($x92,$x60);
                    $x97->msg('s',"Sale updated.");
                    fn_a34('edit_sale.php?id='.$x94['id'], false);
                  } else {
                    $x97->msg('d',' Sorry failed to updated!');
                    fn_a34('sales.php', false);
                  }
        } else {
           $x97->msg("d", $x25);
           fn_a34('edit_sale.php?id='.(int)$x94['id'],false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo fn_a8($x53); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
  <div class="panel">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>All Sales</span>
     </strong>
     <div class="pull-right">
       <a href="sales.php" class="btn btn-primary">Show all sales</a>
     </div>
    </div>
    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Product title </th>
          <th> Qty </th>
          <th> Price </th>
          <th> Total </th>
          <th> Date</th>
          <th> Action</th>
         </thead>
           <tbody  id="product_info">
              <tr>
              <form method="post" action="edit_sale.php?id=<?php echo (int)$x94['id']; ?>">
                <td id="s_name">
                  <input type="text" class="form-control" id="sug_input" name="title" value="<?php echo fn_a35($x69['name']); ?>">
                  <div id="result" class="list-group"></div>
                </td>
                <td id="s_qty">
                  <input type="text" class="form-control" name="quantity" value="<?php echo (int)$x94['qty']; ?>">
                </td>
                <td id="s_price">
                  <input type="text" class="form-control" name="price" value="<?php echo fn_a35($x69['sale_price']); ?>" >
                </td>
                <td>
                  <input type="text" class="form-control" name="total" value="<?php echo fn_a35($x94['price']); ?>">
                </td>
                <td id="s_date">
                  <input type="date" class="form-control datepicker" name="date" data-date-format="" value="<?php echo fn_a35($x94['date']); ?>">
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-primary">Update sale</button>
                </td>
              </form>
              </tr>
           </tbody>
       </table>

    </div>
  </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
