<?php
  $x64 = 'Low Stock Alert';
  require_once('includes/load.php');

   fn_a28(2);

  $x126 = LOW_STOCK_THRESHOLD;
  $x25  = '';

  if(isset($_GET['threshold'])){
    $x102 = trim($_GET['threshold']);
      if($x102 === ''){
        $x25 = "Threshold can't be blank. Showing the default threshold.";
      } elseif(!is_numeric($x102)){
        $x25 = "Threshold must be a number. Showing the default threshold.";
      } elseif((int)$x102 < 0){
        $x25 = "Threshold can't be negative. Showing the default threshold.";
      } else {
        $x126 = (int)$x102;
      }
  }

  $x127 = fn_a45($x126);
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo fn_a8($x53); ?>
       <?php echo fn_a8(!empty($x25) ? array('danger' => $x25) : ''); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-warning-sign"></span>
            <span>Products at or below the threshold, by location</span>
          </strong>
         <div class="pull-right">
           <form method="get" action="low_stock.php" class="form-inline">
             <div class="form-group">
               <label for="threshold"> Threshold </label>
               <input type="text" class="form-control input-sm" id="threshold" name="threshold" value="<?php echo (int)$x126;?>">
             </div>
             <button type="submit" class="btn btn-primary btn-sm">Apply</button>
           </form>
         </div>
        </div>
        <div class="panel-body">
          <p class="text-muted">
            Threshold is <strong><?php echo (int)$x126;?></strong>.
            A product is low stock at a location when its quantity there is less than or equal to the threshold.
            <strong><?php echo count($x127);?></strong> product/location row(s) match.
          </p>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Location </th>
                <th> Product Title </th>
                <th class="text-center" style="width: 10%;"> Quantity </th>
                <th class="text-center" style="width: 10%;"> Threshold </th>
                <th class="text-center" style="width: 10%;"> Status </th>
              </tr>
            </thead>
            <tbody>
              <?php if(empty($x127)): ?>
              <tr>
                <td class="text-center" colspan="6"> No product is at or below the threshold at any location. </td>
              </tr>
              <?php endif; ?>
              <?php foreach ($x127 as $x69):?>
              <tr>
                <td class="text-center"><?php echo fn_a4();?></td>
                <td> <?php echo fn_a35($x69['location_name']); ?></td>
                <td> <?php echo fn_a35($x69['product_name']); ?></td>
                <td class="text-center"> <?php echo max(0, (int)$x69['quantity']); ?></td>
                <td class="text-center"> <?php echo (int)$x126; ?></td>
                <td class="text-center">
                  <?php if((int)$x69['quantity'] <= 0): ?>
                    <span class="label label-danger">Out of stock</span>
                  <?php else: ?>
                    <span class="label label-warning">Low stock</span>
                  <?php endif; ?>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
