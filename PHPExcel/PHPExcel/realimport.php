<?php
$connect = mysqli_connect("localhost", "root", "", "excel");
$output = '';
if(isset($_POST["import"]))
{
 $extension = explode(".", $_FILES["excel"]["name"]);
$file_extension = end($extension); // For getting Extension of selected file
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($file_extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
  $file = $_FILES["excel"]["tmp_name"];  // getting temporary source of excel file
  include("classes/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

  $output .= "<label class='text-success'>Data Inserted</label><br /><table class='table table-bordered'>";
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
   $highestRow = $worksheet->getHighestRow();
   for($row=2; $row<=$highestRow; $row++)
   {
    $output .= "<tr>";
    $api_name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
    $status = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
    $description = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
    $app_name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
    if($status == 1){
    $query = "INSERT INTO excels(api_name,status_name,description_n,app_name_n) VALUES('$api_name','$status','$description','$app_name')";
    mysqli_query($connect, $query);
    }
    $output .= '<td>'.$api_name.'</td>';
    $output .= '<td>'.$status.'</td>';
    $output .= '<td>'.$description.'</td>';

    $output .= '<td>'.$app_name.'</td>';

    $output .= '</tr>';
   }
  } 
  $output .= '</table>';

 }
 else
 {
  $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
 }
}
?>

<html>
 <head>
  <title>Import Excel to Mysql using PHPExcel in PHP</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  body
  {
   margin:0;
   padding:0;
   background-color:#f1f1f1;
  }
  .box
  {
   width:700px;
   border:1px solid #ccc;
   background-color:#fff;
   border-radius:5px;
   margin-top:100px;
  }
  
  </style>
 </head>
 <body>
  <div class="container box">
   <h3 align="center">Import Excel to Mysql using PHPExcel in PHP</h3><br />
   <form method="post" enctype="multipart/form-data">
    <label>Select Excel File</label>
    <input type="file" name="excel" />
    <br />
    <input type="submit" name="import" class="btn btn-info" value="Import" />
   </form>
   <br />
   <br />
   <?php
   echo $output;
   ?>
  </div>
 </body>
</html>