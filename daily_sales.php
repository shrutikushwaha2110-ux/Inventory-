<?php
  $x64 = 'Daily Sales';
  require_once('includes/load.php');
  
   fn_a28(3);
?>

<?php
 $x125  = date('Y');
 $x52 = date('m');
 $x95 = fn_a6($x125,$x52);
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
            <span>Daily Sales</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product name </th>
                <th class="text-center" style="width: 15%;"> Quantity sold</th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 15%;"> Date </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($x95 as $x94):?>
             <tr>
               <td class="text-center"><?php echo fn_a4();?></td>
               <td><?php echo fn_a35($x94['name']); ?></td>
               <td class="text-center"><?php echo (int)$x94['qty']; ?></td>
               <td class="text-center"><?php echo fn_a35($x94['total_saleing_price']); ?></td>
               <td class="text-center"><?php echo $x94['date']; ?></td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
