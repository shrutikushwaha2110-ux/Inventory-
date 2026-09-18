<?php
  $x64 = 'Admin Home Page';
  require_once('includes/load.php');
  
   fn_a28(1);
?>
<?php
 $x7     = fn_a3('categories');
 $x8       = fn_a3('products');
 $x9          = fn_a3('sales');
 $x10          = fn_a3('users');
 $x75   = fn_a17('10');
 $x81 = fn_a19('5');
 $x83    = fn_a20('5')
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-6">
     <?php echo fn_a8($x53); ?>
   </div>
</div>
  <div class="row">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-green">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $x10['total']; ?> </h2>
          <p class="text-muted">Users</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-list"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $x7['total']; ?> </h2>
          <p class="text-muted">Categories</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $x8['total']; ?> </h2>
          <p class="text-muted">Products</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-yellow">
          <i class="glyphicon glyphicon-usd"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $x9['total']; ?></h2>
          <p class="text-muted">Sales</p>
        </div>
       </div>
    </div>
</div>
  <div class="row">
   <div class="col-md-12">
      <div class="panel">
        <div class="jumbotron text-center">
           <h1>Thank You! for your support and love.</h1>
           <p> <strong>OSWA-INV v2</strong> way more better then <strong> v1 </strong>.
           </br>If you have a question regarding the usage of this applications, please ask on <a href="https://www.facebook.com/oswapp" title="Facebook" target="_blank">Facebook</a> OSWA Fan page.</p>

        </div>
      </div>
   </div>
  </div>
  <div class="row">
   <div class="col-md-4">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Highest Saleing Products</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
          <thead>
           <tr>
             <th>Title</th>
             <th>Total Sold</th>
             <th>Total Quantity</th>
           <tr>
          </thead>
          <tbody>
            <?php foreach ($x75 as  $x72): ?>
              <tr>
                <td><?php echo fn_a35(fn_a22($x72['name'])); ?></td>
                <td><?php echo (int)$x72['totalSold']; ?></td>
                <td><?php echo (int)$x72['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          <tbody>
         </table>
       </div>
     </div>
   </div>
   <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>LATEST SALES</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
       <thead>
         <tr>
           <th class="text-center" style="width: 50px;">#</th>
           <th>Product Name</th>
           <th>Date</th>
           <th>Total Sale</th>
         </tr>
       </thead>
       <tbody>
         <?php foreach ($x83 as  $x82): ?>
         <tr>
           <td class="text-center"><?php echo fn_a4();?></td>
           <td>
            <a href="edit_sale.php?id=<?php echo (int)$x82['id']; ?>">
             <?php echo fn_a35(fn_a22($x82['name'])); ?>
           </a>
           </td>
           <td><?php echo fn_a35(ucfirst($x82['date'])); ?></td>
           <td>$<?php echo fn_a35(fn_a22($x82['price'])); ?></td>
        </tr>

       <?php endforeach; ?>
       </tbody>
     </table>
    </div>
   </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Recently Added Products</span>
        </strong>
      </div>
      <div class="panel-body">

        <div class="list-group">
      <?php foreach ($x81 as  $x80): ?>
            <a class="list-group-item clearfix" href="edit_product.php?id=<?php echo    (int)$x80['id'];?>">
                <h4 class="list-group-item-heading">
                 <?php if($x80['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $x80['image'];?>" alt="" />
                <?php endif;?>
                <?php echo fn_a35(fn_a22($x80['name']));?>
                  <span class="label label-warning pull-right">
                 $<?php echo (int)$x80['sale_price']; ?>
                  </span>
                </h4>
                <span class="list-group-item-text pull-right">
                <?php echo fn_a35(fn_a22($x80['categorie'])); ?>
              </span>
          </a>
      <?php endforeach; ?>
    </div>
  </div>
 </div>
</div>
 </div>
  <div class="row">

  </div>



<?php include_once('layouts/footer.php'); ?>
