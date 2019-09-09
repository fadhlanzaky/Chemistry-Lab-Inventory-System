<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">

    <script src="js/jquery.js" type="text/javascript"></script>
    <style type="text/css">
    @import url(css/style-addUser.css);
    </style>
	 <script type="text/javascript">
		function checkAvailability() {
		jQuery.ajax({
		url: "checkdatauser.php",
		data:'username='+$("#username").val(),
		type: "POST",
		success:function(data){
			$("#user-availability-status").html(data);
			if (data == "Registered" ){
				$("#submit").prop('disabled', true);
			}else{
				$("#submit").prop('disabled', false);
			}
		},
		error:function (){}
		});
		}
	</script>
	
</head>
<body>
    <div class="container">
        <div class="sub-container1">
            <h1>Create New Account</h1>
        </div>

        <div class="sub-container2">
        <p>Please fill in this form to create an account.</p>
        <hr>
               <form id="login-form" action="user_form.php" method="post">
                    <input type="name" id="fullname" name="fullname" class="input1" placeholder="Full Name">
                    <input type="username" id="username" name="username" class="input2" placeholder="Username " onkeyup="checkAvailability()" >
					<span id="user-availability-status"></span>
                    <input type="password" id="password" name="password" class="input3" onkeyup='check();' placeholder="Password " required>
                    <input type="password" id="confirm_password" name="confpassword" class="input4" onkeyup='valid();' placeholder="Repeat Password " required>
                    <select name="akses">
                      <option value="user">user</option>                    
                      <option value="admin">admin</option>
                    </select>
                    <button value="button" id="submit" name="submit">Create</button> 
                    </form>
                </div>
        </div>
    </div>
</body>

<script>
function valid(){
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
}
</script>
</html>