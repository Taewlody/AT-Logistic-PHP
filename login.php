<?php 
session_start();
?>
<!DOCTYPE html>
<html>
   <script>
$(document).ready(function () {

    $("#form").validate({
                 rules: {
                  atusername: {required: true },
                  atpassword: {required: true }
                     
                  
                 }
     });
  });
    </script>   
<?php
require_once( 'class.php' );
require_once( 'function.php' );
$db = new cl;
if(isset($_POST['btnSubmit'])){
$login_username=isset($_POST['atusername'])?$_POST['atusername']:'';
$login_password=isset($_POST['atpassword'])?$_POST['atpassword']:'';
 $sql_check=" SELECT
u.comCode,
u.usercode,
u.username,
u.userpass,
u.surname,
u.userTypecode,
u.img_sinal
FROM
`user` AS u
WHERE u.usercode='$login_username' AND u.userpass =MD5('$login_password') AND u.isActive=1 ";
		$info=$db->fetch($sql_check);
		if (isset($info['usercode'])!=''){
          $_SESSION['userID']=$info['usercode'];
          $_SESSION['userTypecode']=$info['userTypecode'];
            
            if($info['userTypecode']==4){
               echo'<script  type="text/javascript">location.replace("advance_payment");</script>'; 
            }else{
			echo'<script  type="text/javascript">location.replace("dashboard");</script>';
            }
            
		}else{
			echo'<script  type="text/javascript">alert("ไม่พบชื่อผู้ใช้งานนี้กรุณาตรวจสอบ");</script>';
		}

	

}
    
?>    
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AT Logistic | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>
<style type="text/css">
    body {
  background-image: url('img/bg.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: left;
}
    </style>
<body class="gray-bg" >

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">AT</h1>

            </div>
            <h3>Logistic Management System</h3>
   
            <p>Login in. To see it in action.</p>
        
    
         
            <form class="m-t" id="m-t" name="form1" role="form"  autocomplete="off" method="post" action="" enctype="multipart/form-data">
    
                <div class="form-group">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" autocomplete="off" id="atusername" name="atusername" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password"  autocomplete="new-password" id="Password" name="atpassword" required="">
                </div>
                <button type="submit" name="btnSubmit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
   
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>
