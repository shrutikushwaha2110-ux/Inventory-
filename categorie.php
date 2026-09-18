<?php
  $x64 = 'All categories';
  require_once('includes/load.php');
  
  fn_a28(1);
  
  $x3 = fn_a9('categories')
?>
<?php
 if(isset($_POST['add_cat'])){
   $x85 = array('categorie-name');
   fn_a42($x85);
   $x12 = fn_a35($x20->escape($_POST['categorie-name']));
   if(empty($x25)){
      $x98  = "INSERT INTO categories (name)";
      $x98 .= " VALUES ('{$x12}')";
      if($x20->query($x98)){
        $x97->msg("s", "Successfully Added Categorie");
        fn_a34('categorie.php',false);
      } else {
        $x97->msg("d", "Sorry Failed to insert.");
        fn_a34('categorie.php',false);
      }
   } else {
     $x97->msg("d", $x25);
     fn_a34('categorie.php',false);
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
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Categorie</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="categorie.php">
            <div class="form-group">
                <input type="text" class="form-control" name="categorie-name" placeholder="Categorie Name">
            </div>
            <button type="submit" name="add_cat" class="btn btn-primary">Add categorie</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Categories</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Categories</th>
                    <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($x3 as $x11):?>
                <tr>
                    <td class="text-center"><?php echo fn_a4();?></td>
                    <td><?php echo fn_a35(ucfirst($x11['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_categorie.php?id=<?php echo (int)$x11['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="delete_categorie.php?id=<?php echo (int)$x11['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a>
                      </div>
                    </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
