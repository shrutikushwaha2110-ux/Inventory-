<?php
  $x64 = 'All Image';
  require_once('includes/load.php');
  
  fn_a28(2);
?>
<?php $x50 = fn_a9('media');?>
<?php
  if(isset($_POST['submit'])) {
  $x68 = new ClassB1();
  $x68->upload($_FILES['file_upload']);
    if($x68->fn_a29()){
        $x97->msg('s','photo has been uploaded.');
        fn_a34('media.php');
    } else{
      $x97->msg('d',join($x68->x25));
      fn_a34('media.php');
    }

  }

?>
<?php include_once('layouts/header.php'); ?>
     <div class="row">
        <div class="col-md-6">
          <?php echo fn_a8($x53); ?>
        </div>

      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span>All Photos</span>
            <div class="pull-right">
              <form class="form-inline" action="media.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-btn">
                    <input type="file" name="file_upload" multiple="multiple" class="btn btn-primary btn-file"/>
                 </span>

                 <button type="submit" name="submit" class="btn btn-default">Upload</button>
               </div>
              </div>
             </form>
            </div>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th class="text-center">Photo</th>
                  <th class="text-center">Photo Name</th>
                  <th class="text-center" style="width: 20%;">Photo Type</th>
                  <th class="text-center" style="width: 50px;">Actions</th>
                </tr>
              </thead>
                <tbody>
                <?php foreach ($x50 as $x49): ?>
                <tr class="list-inline">
                 <td class="text-center"><?php echo fn_a4();?></td>
                  <td class="text-center">
                      <img src="uploads/products/<?php echo $x49['file_name'];?>" class="img-thumbnail" />
                  </td>
                <td class="text-center">
                  <?php echo $x49['file_name'];?>
                </td>
                <td class="text-center">
                  <?php echo $x49['file_type'];?>
                </td>
                <td class="text-center">
                  <a href="delete_media.php?id=<?php echo (int) $x49['id'];?>" class="btn btn-danger btn-xs"  title="Edit">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                </td>
               </tr>
              <?php endforeach;?>
            </tbody>
          </div>
        </div>
      </div>
</div>


<?php include_once('layouts/footer.php'); ?>
