
<?php 
  if(isset($_POST['hidden_key'])){
      $username = $_POST['username'];
      $password = $_POST['password'];

      $conn = mysqli_connect('localhost','root','','newajax');
      $result = mysqli_query($conn,"INSERT INTO ajax (username,pass) VALUES('$username','$password')");
      if(!empty($result)){
        return exit(json_encode(["response" => ["code" => '1', "success" => "success", "msg" => "insert sucessfully"]]));
      }else{
        return exit(json_encode(["response" => ["code" => '0', "success" => "warning", "msg" => 'something went wrong']]));
      }

  }

?>

<html>
<head>

</head>
<body>
    <form method="post" id="formData">
       <table>
        <tr>
           <td>
             <input type="text" name="username" placeholder="username">
           </td>
        </tr>
        <tr>
           <td>
             <input type="text" name="password" placeholder="password">
           </td>
        </tr>
        <tr>
           <td>
             <input type="hidden" name="hidden_key">
           </td>
        </tr>
        <tr>
           <td>
             <input type="submit" name="b1" value="submit">
           </td>
        </tr>
       </table>
    
    </form>
</body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" />
  <script>
     $(document).ready(function(){
          $('#formData').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
              console.log(formData);
              $.ajax({
                  url:'insert.php',
                  type:'POST',
                  data:formData,
                  cache: false,
                    dataType: 'json',
                    contentType: false,
                    processData: false,

                            success:function(data){
                        console.log(data);
                        if(data.response.code == '1'){
                            $.toast({
                            heading: 'Success',
                            text: data.response.msg,
                            showHideTransition: 'slide',
                            icon: 'success',
                            showHideTransition: 'fade',
                            hideAfter: 3000,
                            position: 'top-right',
                            loaderBg: '#9EC600'
                              });   
                              setTimeout(function() {
                            window.location.href = "insert.php";
                        }, 3000);     
                        }
                        if(data.response.code == '0')
                                {
                                    $.toast({
                                heading: 'Warning',
                                text: data.response.msg,
                                showHideTransition: 'slide',
                                icon: 'warning',
                                showHideTransition: 'fade',
                                hideAfter: 3000,
                                position: 'top-right',
                                loaderBg: '#9EC600'
                            });             }
                    },
                    error:function(data){
                        console.log(data);
                        console.log("errors");
                    }
              });

          });
     });
  </script>
</html>