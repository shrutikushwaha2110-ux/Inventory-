<?php
  $x64 = 'All sale';
  require_once('includes/load.php');
  
   fn_a28(3);
?>
<?php
$x95 = fn_a11();
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
            <span>All Sales</span>
          </strong>
          <div class="pull-right">
            <a href="add_sale.php" class="btn btn-primary">Add sale</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product name </th>
                <th class="text-center" style="width: 15%;"> Quantity</th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 15%;"> Date </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($x95 as $x94):?>
             <tr>
               <td class="text-center"><?php echo fn_a4();?></td>
               <td><?php echo fn_a35($x94['name']); ?></td>
               <td class="text-center"><?php echo (int)$x94['qty']; ?></td>
               <td class="text-center"><?php echo fn_a35($x94['price']); ?></td>
               <td class="text-center"><?php echo $x94['date']; ?></td>
               <td class="text-center">
                  <div class="btn-group">
                     <a href="edit_sale.php?id=<?php echo (int)$x94['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a href="delete_sale.php?id=<?php echo (int)$x94['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                  </div>
               </td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>
