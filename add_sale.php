<?php
  $x64 = 'Add Sale';
  require_once('includes/load.php');
  
   fn_a28(3);
?>
<?php

  if(isset($_POST['add_sale'])){
    $x86 = array('s_id','quantity','price','total', 'date' );
    fn_a42($x86);
        if(empty($x25)){
          $x60      = $x20->escape((int)$_POST['s_id']);
          $x92     = $x20->escape((int)$_POST['quantity']);
          $x93   = $x20->escape($_POST['total']);
          $x19      = $x20->escape($_POST['date']);
          $x91    = fn_a25();

          $x98  = "INSERT INTO sales (";
          $x98 .= " product_id,qty,price,date";
          $x98 .= ") VALUES (";
          $x98 .= "'{$x60}','{$x92}','{$x93}','{$x91}'";
          $x98 .= ")";

                if($x20->query($x98)){
                  fn_a39($x92,$x60);
                  $x97->msg('s',"Sale added. ");
                  fn_a34('add_sale.php', false);
                } else {
                  $x97->msg('d',' Sorry failed to add!');
                  fn_a34('add_sale.php', false);
                }
        } else {
           $x97->msg("d", $x25);
           fn_a34('add_sale.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo fn_a8($x53); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Find It</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Search for product name">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Sale Eidt</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
         <table class="table table-bordered">
           <thead>
            <th> Item </th>
            <th> Price </th>
            <th> Qty </th>
            <th> Total </th>
            <th> Date</th>
            <th> Action</th>
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
