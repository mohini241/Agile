<?php include('server.php'); 
include 'connection.php';?>



<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
  
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="styles.css">
    
</head>
<body>
<div class="container">

	<div class="d-flex justify-content-center h-100" style="margin-right: 52px;">
		<div class="card" style="margin-right: 15px;">
			<div class="card-header">
				<h3>Register</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
            
            <form method="post" action="register.php">
                <div class="inputs">
  	             
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input name="username" type="text" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
						
					</div>
                    <div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fas fa-envelope"></i></span>
						</div>
						<input name="email" type="text" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
						
					</div>

					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input name="password_1" type="password" class="form-control" placeholder="Password">
					</div>
                    <div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input name="password_2" type="password" class="form-control" placeholder="Confirm Password">
					</div>
                    <div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-users"></i></span>
						</div>
						
  <select name="usertype" id="usertype">
  <option value="">--Select User Type--</option>
    <option value="scrummaster">Scrum Master</option>
    <option value="teammember">Team Member</option>
						
					</div>
					
					<div class="form-group">
						<input type="submit" name="reg_user" class="btn float-right login_btn">
					</div>


</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links" style="text-shadow: 2px 2px #0a0a0a">
					Already have an account?<a href="login.php">Log In</a>
				</div>
				
			</div>
		</div>
        <div class="d-flex justify-content-center h-100">
<?php include('errors.php'); ?>
<div>
	</div>
    

</body>
</html>