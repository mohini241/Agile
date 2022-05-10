<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Predictor</title>

    <!-- Bootstrap -->
    <!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
  
    <script src="bootstrap/js/jquery-1.11.3.min.js"></script>
  
    <script src="bootstrap/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="template.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Slabo+27px&display=swap" rel="stylesheet">
	
  </head>
<body>
<div class="header">
        
        </div>
        <!--- navbar --->
        <?php
        include 'connection.php';
        session_start(); 
        include 'navbar.php';
        
        ?>
        <style>
            <style>
  .navbar-text {
    float: right; }

    #navbarText{
      font-size: 20px;

    }
    body{
        background-image: url('https://nmrql.com/wp-content/uploads/2017/11/shutterstock_695385187-scaled.jpg');
background-color: #d7edef;
background-size: cover;
background-repeat: repeat;
      /* background-image: url('https://thumbs.dreamstime.com/b/agile-concept-blurred-city-lights-agile-concept-blurred-city-abstract-lights-background-157530337.jpg'); */
      /* repeat:no-repeat fixed center; background-color: #000000; background-size: cover;
      background-color: rgba(255, 255, 255, -2.514);
  background-blend-mode: overlay; */
  /* background-color: #d7edef; */
    }
    .table thead.thead-primary {
    background: #343a40;
}

.heading-section{
  font-family: 'Slabo 27px', serif;
  font-size: 52px;
}
.navbar-nav{
  
  transform: translateX(90%);
  transform: translateY(32%);
}
.navbar-dark .navbar-text {
    color: rgb(20 168 254);
}
.btn-info {
   
    background-color: #14a8fe;
}


.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
}
.dropbtn {
  background-color: #14a8fe;
  color: white;
  padding: 8px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  text-align: center;
  position:relative;
  float:right;
}

.dropdown {
  position: relative;
  display: inline-block;
}
.navbar-text{
    float:right;
}


            </style>
    
        
    <div class="content">
            <!-- notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php 
                  echo $_SESSION['success']; 
                  unset($_SESSION['success']);
              ?>
                </h3>
            </div>
            <?php endif ?>
    
            <!-- logged in user information -->
            <?php  if (isset($_SESSION['username'])) : ?>
            
            
            <?php endif ?>
        </div>
        

<br><br><br><br>

<div class="container">
  <div class="column" style="width:400px;">
<form role="form" method="post" action="linear.php" >
    <div class="input-group col-md-8">
		
		<input type="hidden"name="Xf" id="Xf" type="text" class="form-control" placeholder="" aria-describedby="basic-addon1"  pattern="[0-9,.-]{3,}">
	</div>
	<br>
	<div class="input-group col-md-8">
		
		<input type="hidden" name="Yf" id="Yf" type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" pattern="[0-9,.-]{3,}">
	</div>
	<br>
	<div class="input-group col-md-8">
	<h2 style="color:white;">Input Estimated Hours</h2>
		<input style="width:100px;"name="Find" id="Find" type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="4" pattern="[0-9.-]{1,}">
	</div>
	<br>
	  <button type="submit" class="btn btn-info btn-lg" formaction="linear.php" formmethod="post" formtarget="_blank">Predict Acceptance Time</button>
	  <br><br>
	 
	  <div class="input-group col-md-8">
		 <div class="radio">
			<label style="color:white !important;"><input  type="radio" name="Regression" value="Linear" Checked><strong>Plot Linear Line Graph</strong></label>
		</div>
		
	</div>	  
	  <button type="submit" class="btn btn-info btn-lg" formaction="plot.php" formmethod="post" formtarget="iframe1">Plot</button>
</form>
	
            </div>
<div class="column" style="width:600px; height:600px;">
<iframe  src="plot.php" name="iframe1" height="650px" width="100%" title="Iframe Example">

</iframe>
            </div>
</div>
<style>
  
  .column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

  </style>

  </body>
</html>