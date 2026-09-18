<?php
  $x64 = 'Transfer History';
  require_once('includes/load.php');

   fn_a28(3);
?>
<?php
  $x133 = fn_a48();
  $x95  = fn_a47();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo fn_a8($x53); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Current Stock by Location</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product name </th>
                <th> Location </th>
                <th class="text-center" style="width: 15%;"> Quantity </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($x133 as $x69):?>
             <tr>
               <td class="text-center"><?php echo fn_a4();?></td>
               <td><?php echo fn_a35($x69['product_name']); ?></td>
               <td><?php echo fn_a35($x69['location_name']); ?></td>
               <td class="text-center"><?php echo (int)$x69['quantity']; ?></td>
             </tr>
             <?php endforeach;?>
             <?php if(empty($x133)): ?>
             <tr>
               <td class="text-center" colspan="4"> No stock recorded at any location yet. </td>
             </tr>
             <?php endif; ?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-transfer"></span>
            <span>All Transfers</span>
          </strong>
          <div class="pull-right">
            <a href="add_transfer.php" class="btn btn-primary">Add Transfer</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product name </th>
                <th> Source </th>
                <th> Destination </th>
                <th class="text-center" style="width: 15%;"> Quantity</th>
                <th class="text-center" style="width: 15%;"> Date </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($x95 as $x94):?>
             <tr>
               <td class="text-center"><?php echo fn_a4();?></td>
               <td><?php echo fn_a35($x94['product_name']); ?></td>
               <td><?php echo fn_a35($x94['source_name']); ?></td>
               <td><?php echo fn_a35($x94['destination_name']); ?></td>
               <td class="text-center"><?php echo (int)$x94['qty']; ?></td>
               <td class="text-center"><?php echo $x94['date']; ?></td>
             </tr>
             <?php endforeach;?>
             <?php if(empty($x95)): ?>
             <tr>
               <td class="text-center" colspan="6"> No transfers recorded yet. </td>
             </tr>
             <?php endif; ?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>
