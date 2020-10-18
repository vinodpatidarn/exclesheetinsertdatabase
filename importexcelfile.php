<?php
if(isset($_POST["submit"]))
{

                $url='localhost';
                $username='root';
                $password='';
                $conn=mysqli_connect($url,$username,$password,"excel");
                
          if(!$conn){
          die('Could not Connect My Sql:' .mysqli_error());
		  }
          $file = $_FILES['file']['tmp_name'];
          $file_name = $_FILES['file']['name'];
          $handle =fopen($file, "r");
          mysqli_set_charset($conn,"utf8");
          
          $c = 0;
          while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
                    {
        //  $api_name = $filesop[0];
        //  $status = base64_decode(base64_decode($filesop[1]));
        //  $description = base64_decode(base64_decode($filesop[2]));
        //  $app_name = base64_decode(base64_decode($filesop[3]));

         $api_name ='';

            // $description= $filesop[2];
            // $app_name = $filesop[3];

           $sql = "insert into excels(api_name) VALUES ('$api_name')";
           $stmt = mysqli_prepare($conn,$sql);
           mysqli_stmt_execute($stmt);
           $limit = 1600;

          $c = $c + 1;
          }

            if($sql){
                echo "sucess";
              } 
		  else
		  {
             echo "Sorry! Unable to impo.";
           }

}
?>
<!DOCTYPE html>
<html>
<body>
<form enctype="multipart/form-data" method="post" role="form">
    <div class="form-group">
        <label for="exampleInputFile">File Upload</label>
        <input type="file" name="file" id="file" size="150">
        <p class="help-block">Only Excel/CSV File Import.</p>
    </div>
    <button type="submit" class="btn btn-default" name="submit" value="submit">Upload</button>
</form>
</body>
</html>