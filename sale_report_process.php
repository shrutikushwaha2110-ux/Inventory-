<?php
$x64 = 'Sales Report';
$x90 = '';
  require_once('includes/load.php');
  
   fn_a28(3);
?>
<?php
  if(isset($_POST['submit'])){
    $x84 = array('start-date','end-date');
    fn_a42($x84);

    if(empty($x25)):
      $x99   = fn_a35($x20->escape($_POST['start-date']));
      $x24     = fn_a35($x20->escape($_POST['end-date']));
      $x90      = fn_a21($x99,$x24);
    else:
      $x97->msg("d", $x25);
      fn_a34('sales_report.php', false);
    endif;

  } else {
    $x97->msg("d", "Select dates");
    fn_a34('sales_report.php', false);
  }
?>
<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Default Page Title</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
   <style>
   @media print {
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
    }
    .page-break{
      width: 980px;
      margin: 0 auto;
    }
     .sale-head{
       margin: 40px 0;
       text-align: center;
     }.sale-head h1,.sale-head strong{
       padding: 10px 20px;
       display: block;
     }.sale-head h1{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }.sale-head h1,table thead tr th,table tfoot tr td{
       background-color: #f8f8f8;
     }tfoot{
       color:#000;
       text-transform: uppercase;
       font-weight: 500;
     }
   </style>
</head>
<body>
  <?php if($x90): ?>
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Sales Report</h1>
           <strong><?php if(isset($x99)){ echo $x99;}?> To <?php if(isset($x24)){echo $x24;}?> </strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Product Title</th>
              <th>Buying Price</th>
              <th>Selling Price</th>
              <th>Total Qty</th>
              <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($x90 as $x88): ?>
           <tr>
              <td class=""><?php echo fn_a35($x88['date']);?></td>
              <td class="desc">
                <h6><?php echo fn_a35(ucfirst($x88['name']));?></h6>
              </td>
              <td class="text-right"><?php echo fn_a35($x88['buy_price']);?></td>
              <td class="text-right"><?php echo fn_a35($x88['sale_price']);?></td>
              <td class="text-right"><?php echo fn_a35($x88['total_sales']);?></td>
              <td class="text-right"><?php echo fn_a35($x88['total_saleing_price']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
         <tr class="text-right">
           <td colspan="4"></td>
           <td colspan="1">Grand Total</td>
           <td> $
           <?php echo number_format(fn_a37($x90)[0], 2);?>
          </td>
         </tr>
         <tr class="text-right">
           <td colspan="4"></td>
           <td colspan="1">Profit</td>
           <td> $<?php echo number_format(fn_a37($x90)[1], 2);?></td>
         </tr>
        </tfoot>
      </table>
    </div>
  <?php
    else:
        $x97->msg("d", "Sorry no sales has been found. ");
        fn_a34('sales_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($x20)) { $x20->db_disconnect(); } ?>
