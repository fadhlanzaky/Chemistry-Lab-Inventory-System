<?php
include('login.php'); // Includes Login Script
if(isset($_SESSION['login_user'])){
header("location: admin.php"); // Redirecting To Profile Page
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chemistry Lab Inventory System</title>
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css",>
    <script src="js/jquery.js" type="text/javascript"></script>
    <style type="text/css">
    @import url(css/style-index.css);
    </style>
</head>
<body>
<center>
<p>Chemistry Lab Inventory System</p>

<a class="show-login-btn"><i class="fas fa-sign-in-alt fa-rotate-90" style="font-size:15pt; color:white;"></i></a>
    

    <div class="login-box">
        <div class="hide-login-btn"><i class="fas fa-times"></i></div>
        
        <form id="login-form" action="" method="post">
        <i class="far fa-user" 
        style="font-size:16pt; 
                color:#959393; 
                margin-bottom: 30px;
                border: none;
                background: rgba(255, 255, 255, 0.76);
                border-radius: 100%;
                padding: 10px 12px 10px 12px;"></i>
        <input id="name" type="username" name="username" class="input" placeholder="Username ">
        <input id="password" type="password" name="password" class="input" placeholder="Password ">
		<span> <br><br> <?php echo $error; ?> </span>
        <button value="button" name="submit" type="submit">Sign In</button> 
		
    </form>
    </div>
    
        
        <script type="text/javascript">
          $(document).ready(function()
          {
            $(".show-login-btn").click(function(){showpopup();});
            $(".hide-login-btn").click(function(){hidepopup();});
          });

          function showpopup()
          {
            $(".login-box").fadeIn();
            $(".login-box").css({"visibility":"visible","display":"block","transform":"scale(1)"});
          }
          function hidepopup()
          {
            $(".login-box").fadeOut();
            $(".login-box").css({"visibility":"hidden","display":"none","transform":"scale(0.01)"});
          }
            </script>
</center>

</body>
</html>