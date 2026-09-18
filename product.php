<?php
  $x64 = 'All Product';
  require_once('includes/load.php');
  
   fn_a28(2);
  $x74 = fn_a24();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo fn_a8($x53); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-primary">Add New</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Photo</th>
                <th> Product Title </th>
                <th class="text-center" style="width: 10%;"> Categorie </th>
                <th class="text-center" style="width: 10%;"> Instock </th>
                <th class="text-center" style="width: 10%;"> Buying Price </th>
                <th class="text-center" style="width: 10%;"> Saleing Price </th>
                <th class="text-center" style="width: 10%;"> Product Added </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($x74 as $x69):?>
              <tr>
                <td class="text-center"><?php echo fn_a4();?></td>
                <td>
                  <?php if($x69['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $x69['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo fn_a35($x69['name']); ?></td>
                <td class="text-center"> <?php echo fn_a35($x69['categorie']); ?></td>
                <td class="text-center"> <?php echo fn_a35($x69['quantity']); ?></td>
                <td class="text-center"> <?php echo fn_a35($x69['buy_price']); ?></td>
                <td class="text-center"> <?php echo fn_a35($x69['sale_price']); ?></td>
                <td class="text-center"> <?php echo fn_a32($x69['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$x69['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_product.php?id=<?php echo (int)$x69['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
