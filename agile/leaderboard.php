<?php 
  session_start(); 
  include 'connection.php';
  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
$username=$_SESSION['username'];

$query1 = "SELECT * from users where username= ?";
if($stmt1 = mysqli_prepare($db, $query1)){
  mysqli_stmt_bind_param($stmt1, "s", $username);
      if(mysqli_stmt_execute($stmt1)){
          $result1 = mysqli_stmt_get_result($stmt1);
              $rowemp = mysqli_fetch_array($result1);

           
             $_SESSION['usertype']=$rowemp[4];
      }
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="template.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Slabo+27px&display=swap" rel="stylesheet">
<?php
$leaderboard_query = "select sum(score),username from leaderboard GROUP BY username order by sum(score) desc limit 10";
$leaderboard = mysqli_query($db, $leaderboard_query);
while($leaderboard_array = mysqli_fetch_assoc($leaderboard)){
$usernames[]=$leaderboard_array['username'];
$scores[]=$leaderboard_array['sum(score)'];
}

// print_r($usernames);
// print_r($scores);

$usernames_count=count($usernames);
?>
    
   
</head>
<body>
<div class="header">
        
        </div>
        <!--- navbar --->
        <?php
        include 'navbar.php';
        ?>

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




<div class="container">

<?php echo'
<div class="leaderboard">
    <h1>
        <svg class="ico-cup">
            <use xlink:href="#cup"></use>
        </svg>
        Top 10 Performers
    </h1>
    <ol style="list-style-type: none; transform:translateX(-2%);">';
    for ($x = 0; $x < 10; $x++) {
        
        if(isset($usernames[$x])){
            if($x==0){ echo'
                <li style=" text-transform: capitalize;">
                <mark><strong>'.$usernames[$x].'</strong> <img src="medal1.png"  width="20px" height="20px" style=" border-radius: 50%;"></mark>
                
                <small style="color:black;"><strong>'.$scores[$x].'</strong></small>
            </li>';

            }elseif($x==1){ echo'
                <li style=" text-transform: capitalize;">
                <mark><strong>'.$usernames[$x].'</strong> <img src="medal2.png"  width="20px" height="20px" style=" border-radius: 50%;"></mark>
                
                <small style="color:black;"><strong>'.$scores[$x].'</strong></small>
            </li>';

            }elseif($x==2){ echo'
                <li style=" text-transform: capitalize;">
                <mark><strong>'.$usernames[$x].'</strong> <img src="medal3.png"  width="20px" height="20px" style=" border-radius: 50%;"></mark>
                
                <small style="color:black;"><strong>'.$scores[$x].'</strong></small>
            </li>';

            }


        
           
            else{
                echo'
        <li style=" text-transform: capitalize;">
            <mark><strong>'.$usernames[$x].'</strong></mark>
            <small style="color:black;"><strong>'.$scores[$x].'</strong></small>
        </li>';
            }
    }else{
        ;echo' 
        <li style="height:53px;">
            <mark>   </mark>
            <small>  </small>
        </li>';

    }
} 
    echo'
    </ol>
</div>
';
?>

<svg style="display: none;">
    <symbol id="cup" x="0px" y="0px" width="25px" height="26px" viewBox="0 0 25 26" enable-background="new 0 0 25 26" xml:space="preserve">
        <path fill="#F26856" d="M21.215,1.428c-0.744,0-1.438,0.213-2.024,0.579V0.865c0-0.478-0.394-0.865-0.88-0.865H6.69
	C6.204,0,5.81,0.387,5.81,0.865v1.142C5.224,1.641,4.53,1.428,3.785,1.428C1.698,1.428,0,3.097,0,5.148
	C0,7.2,1.698,8.869,3.785,8.869h1.453c0.315,0,0.572,0.252,0.572,0.562c0,0.311-0.257,0.563-0.572,0.563
	c-0.486,0-0.88,0.388-0.88,0.865c0,0.478,0.395,0.865,0.88,0.865c0.421,0,0.816-0.111,1.158-0.303
	c0.318,0.865,0.761,1.647,1.318,2.31c0.686,0.814,1.515,1.425,2.433,1.808c-0.04,0.487-0.154,1.349-0.481,2.191
	c-0.591,1.519-1.564,2.257-2.975,2.257H5.238c-0.486,0-0.88,0.388-0.88,0.865v4.283c0,0.478,0.395,0.865,0.88,0.865h14.525
	c0.485,0,0.88-0.388,0.88-0.865v-4.283c0-0.478-0.395-0.865-0.88-0.865h-1.452c-1.411,0-2.385-0.738-2.975-2.257
	c-0.328-0.843-0.441-1.704-0.482-2.191c0.918-0.383,1.748-0.993,2.434-1.808c0.557-0.663,1-1.445,1.318-2.31
	c0.342,0.192,0.736,0.303,1.157,0.303c0.486,0,0.88-0.387,0.88-0.865c0-0.478-0.394-0.865-0.88-0.865
	c-0.315,0-0.572-0.252-0.572-0.563c0-0.31,0.257-0.562,0.572-0.562h1.452C23.303,8.869,25,7.2,25,5.148
	C25,3.097,23.303,1.428,21.215,1.428z M5.238,7.138H3.785c-1.116,0-2.024-0.893-2.024-1.99c0-1.097,0.908-1.99,2.024-1.99
	c1.117,0,2.025,0.893,2.025,1.99v2.06C5.627,7.163,5.435,7.138,5.238,7.138z M18.883,21.717v2.553H6.118v-2.553H18.883
	L18.883,21.717z M13.673,18.301c0.248,0.65,0.566,1.214,0.947,1.686h-4.24c0.381-0.472,0.699-1.035,0.947-1.686
	c0.33-0.865,0.479-1.723,0.545-2.327c0.207,0.021,0.416,0.033,0.627,0.033c0.211,0,0.42-0.013,0.627-0.033
	C13.195,16.578,13.344,17.436,13.673,18.301z M12.5,14.276c-2.856,0-4.93-2.638-4.93-6.273V1.73h9.859v6.273
	C17.43,11.638,15.357,14.276,12.5,14.276z M21.215,7.138h-1.452c-0.197,0-0.39,0.024-0.572,0.07v-2.06
	c0-1.097,0.908-1.99,2.024-1.99c1.117,0,2.025,0.893,2.025,1.99C23.241,6.246,22.333,7.138,21.215,7.138z" />
    </symbol>
</svg>

<style>
*,
*::before,
*::after {
    box-sizing: border-box;
}

body {
    min-height: 450px;
    height: 100vh;
    margin: 0;
    background: radial-gradient(ellipse farthest-corner at center top, #f39264 0%, #f2606f 100%);
    color: #fff;
    font-family: "Open Sans", sans-serif;
}

/*--------------------
Leaderboard
--------------------*/
.leaderboard {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -35%);
    width: 669px;
    height: 588px;
    background: linear-gradient(to bottom, #3a404d, #181c26);
    border-radius: 10px;
    box-shadow: 0 7px 30px rgba(62, 9, 11, 0.3);
}

.leaderboard h1 {
    font-size: 18px;
    color: #e1e1e1;
    padding: 12px 13px 18px;
}

.leaderboard h1 svg {
    width: 25px;
    height: 26px;
    position: relative;
    top: 3px;
    margin-right: 6px;
    vertical-align: baseline;
}

.leaderboard ol {
    counter-reset: leaderboard;
}

.leaderboard ol li {
    position: relative;
    z-index: 1;
    font-size: 14px;
    counter-increment: leaderboard;
    padding: 18px 10px 18px 50px;
    cursor: pointer;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transform: translateZ(0) scale(1, 1);
}

.leaderboard ol li::before {
    content: counter(leaderboard);
    position: absolute;
    z-index: 2;
    top: 15px;
    left: 15px;
    width: 20px;
    height: 20px;
    line-height: 20px;
    color: #c24448;
    background: #fff;
    border-radius: 20px;
    text-align: center;
}

.leaderboard ol li mark {
    position: absolute;
    z-index: 2;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding: 18px 10px 18px 50px;
    margin: 0;
    background: none;
    color: #fff;
}

.leaderboard ol li mark::before,
.leaderboard ol li mark::after {
    content: "";
    position: absolute;
    z-index: 1;
    bottom: -11px;
    left: -9px;
    border-top: 10px solid #c24448;
    border-left: 10px solid transparent;
    transition: all 0.1s ease-in-out;
    opacity: 0;
}

.leaderboard ol li mark::after {
    left: auto;
    right: -9px;
    border-left: none;
    border-right: 10px solid transparent;
}

.leaderboard ol li small {
    position: relative;
    z-index: 2;
    display: block;
    text-align: right;
}

.leaderboard ol li::after {
    content: "";
    position: absolute;
    z-index: 1;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fa6855;
    box-shadow: 0 3px 0 rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease-in-out;
    opacity: 0;
}

.leaderboard ol li:nth-child(1) {
    background: #fa6855;
}

.leaderboard ol li:nth-child(1)::after {
    background: #fa6855;
}

.leaderboard ol li:nth-child(2) {
    background: #e0574f;
}

.leaderboard ol li:nth-child(2)::after {
    background: #e0574f;
    box-shadow: 0 2px 0 rgba(0, 0, 0, 0.08);
}

.leaderboard ol li:nth-child(2) mark::before,
.leaderboard ol li:nth-child(2) mark::after {
    border-top: 6px solid #ba4741;
    bottom: -7px;
}

.leaderboard ol li:nth-child(3) {
    background: #d7514d;
}

.leaderboard ol li:nth-child(3)::after {
    background: #d7514d;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.11);
}

.leaderboard ol li:nth-child(3) mark::before,
.leaderboard ol li:nth-child(3) mark::after {
    border-top: 2px solid #b0433f;
    bottom: -3px;
}

.leaderboard ol li:nth-child(4) {
    background: #cd4b4b;
}

.leaderboard ol li:nth-child(4)::after {
    background: #cd4b4b;
    box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.15);
}

.leaderboard ol li:nth-child(4) mark::before,
.leaderboard ol li:nth-child(4) mark::after {
    top: -7px;
    bottom: auto;
    border-top: none;
    border-bottom: 6px solid #a63d3d;
}

.leaderboard ol li:nth-child(5) {
    background: #c24448;
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(5)::after {
    background: #c24448;
    box-shadow: 0 -2.5px 0 rgba(0, 0, 0, 0.12);
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(5) mark::before,
.leaderboard ol li:nth-child(5) mark::after {
    top: -9px;
    bottom: auto;
    border-top: none;
    border-bottom: 8px solid #993639;
}

.leaderboard ol li:nth-child(6) {
    background: #c24448;
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(6)::after {
    background: #c24448;
    box-shadow: 0 -2.5px 0 rgba(0, 0, 0, 0.12);
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(6) mark::before,
.leaderboard ol li:nth-child(6) mark::after {
    top: -9px;
    bottom: auto;
    border-top: none;
    border-bottom: 8px solid #993639;
}

.leaderboard ol li:nth-child(7) {
    background: #c24448;
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(7)::after {
    background: #c24448;
    box-shadow: 0 -2.5px 0 rgba(0, 0, 0, 0.12);
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(7) mark::before,
.leaderboard ol li:nth-child(7) mark::after {
    top: -9px;
    bottom: auto;
    border-top: none;
    border-bottom: 8px solid #993639;
}
.leaderboard ol li:nth-child(8) {
    background: #c24448;
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(8)::after {
    background: #c24448;
    box-shadow: 0 -2.5px 0 rgba(0, 0, 0, 0.12);
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(8) mark::before,
.leaderboard ol li:nth-child(8) mark::after {
    top: -9px;
    bottom: auto;
    border-top: none;
    border-bottom: 8px solid #993639;
}
.leaderboard ol li:nth-child(9) {
    background: #c24448;
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(9)::after {
    background: #c24448;
    box-shadow: 0 -2.5px 0 rgba(0, 0, 0, 0.12);
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(9) mark::before,
.leaderboard ol li:nth-child(9) mark::after {
    top: -9px;
    bottom: auto;
    border-top: none;
    border-bottom: 8px solid #993639;
}
.leaderboard ol li:nth-child(10) {
    background: #c24448;
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(10)::after {
    background: #c24448;
    box-shadow: 0 -2.5px 0 rgba(0, 0, 0, 0.12);
    border-radius: 0 0 10px 10px;
}

.leaderboard ol li:nth-child(10) mark::before,
.leaderboard ol li:nth-child(10) mark::after {
    top: -9px;
    bottom: auto;
    border-top: none;
    border-bottom: 8px solid #993639;
}
.leaderboard ol li:hover mark::before,
.leaderboard ol li:hover mark::after {
    opacity: 1;
    transition: all 0.35s ease-in-out;
}

.the-most {
    position: fixed;
    z-index: 1;
    bottom: 0;
    left: 0;
    width: 50vw;
    max-width: 200px;
    padding: 10px;
}

.the-most img {
    max-width: 100%;
}


</style>




</div>
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
}

.dropdown {
  position: relative;
  display: inline-block;
}
</style>