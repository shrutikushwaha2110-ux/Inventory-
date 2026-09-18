<?php
  require_once('includes/load.php');
  if (!$x97->isUserLoggedIn(true)) { fn_a34('index.php', false);}
?>

<?php
 
    $x39 = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $x74 = fn_a18($_POST['product_name']);
     if($x74){
        foreach ($x74 as $x69):
           $x39 .= "<li class=\"list-group-item\">";
           $x39 .= $x69['name'];
           $x39 .= "</li>";
         endforeach;
      } else {

        $x39 .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $x39 .= 'Not found';
        $x39 .= "</li>";

      }

      echo json_encode($x39);
   }
 ?>
 <?php
 
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $x73 = fn_a35($x20->escape($_POST['p_name']));
    if($x90 = fn_a10($x73)){
        foreach ($x90 as $x88) {

          $x39 .= "<tr>";

          $x39 .= "<td id=\"s_name\">".$x88['name']."</td>";
          $x39 .= "<input type=\"hidden\" name=\"s_id\" value=\"{$x88['id']}\">";
          $x39  .= "<td>";
          $x39  .= "<input type=\"text\" class=\"form-control\" name=\"price\" value=\"{$x88['sale_price']}\">";
          $x39  .= "</td>";
          $x39 .= "<td id=\"s_qty\">";
          $x39 .= "<input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"1\">";
          $x39  .= "</td>";
          $x39  .= "<td>";
          $x39  .= "<input type=\"text\" class=\"form-control\" name=\"total\" value=\"{$x88['sale_price']}\">";
          $x39  .= "</td>";
          $x39  .= "<td>";
          $x39  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
          $x39  .= "</td>";
          $x39  .= "<td>";
          $x39  .= "<button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Add sale</button>";
          $x39  .= "</td>";
          $x39  .= "</tr>";

        }
    } else {
        $x39 ='<tr><td>product name not resgister in database</td></tr>';
    }

    echo json_encode($x39);
  }
 ?>
