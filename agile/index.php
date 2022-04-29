<?php 
  session_start(); 
  include('create_project.php'); 
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

$list_of_usernames=array();

$query2 = "SELECT username from users where usertype='teammember'";
  $result2 = mysqli_query($db, $query2);
  while($user2 = mysqli_fetch_assoc($result2)){
    $list_of_usernames[]=$user2['username'];

  }

  //  print_r($list_of_usernames);
   $username_count=count($list_of_usernames);
  //  echo $username_count;
   
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

    
   
</head>

<body>

    <div class="header">
        
    </div>
    <!--- navbar --->
    <?php
    include 'navbar.php';

    ?>
<!--- navbar --->



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
    <?php
 
if ($_SESSION['usertype']=='scrummaster') {
// echo "scrummaster";

echo'
<div class="container">
  
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create Project</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="position:absolute; float:left;">Project Creation Form</h4>

        </div>

        <div class="modal-body">
        <div class="mb-3">
        <form method="post" action="index.php">

        <label for="project_title" class="form-label">Project Title</label>
        <input type="text" class="form-control" name="project_title" placeholder="Enter Project Title">
      </div>
      <div class="mb-3">

        <label for="project_description" class="form-label">Description</label>
        <input type="text" class="form-control" name="project_description" placeholder="Enter Project Description">
      </div>

      <div class="mb-3">
        <label for="start_date" class="form-label">Planned Start Date</label>
        <input type="date" class="form-control" name="start_date" placeholder="Enter Start Date">
      </div>

      <div class="mb-3">
        <label for="end_date" class="form-label">Planned End Date</label>
        <input type="date" class="form-control" name="end_date" placeholder="Enter End Date">
      </div>
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <input type="text" class="form-control" name="status" value="active" readonly>
      </div>

    
        <div class="mb-3">
        <label for="members" class="form-label">Select Team Members</label><br>
        <select  size="1" name="members[]" multiple style="padding: 10px; background:#edf2ff; border:none;">
        <option value="">-- Select Members -- </option>';
        for ($x = 0; $x < $username_count; $x++) {
        echo' <option value='.$list_of_usernames[$x].'>'.$list_of_usernames[$x].'</option>';
        }
      echo'
    </select>
      </div>
      </div>
      <button type="submit" class="btn-info" name="create_pro">Save Project</button>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  </form>
</div>';








$result2 = mysqli_query($db, "SELECT * FROM project") or die('Error');
echo '		<div class="container">
<div class="row justify-content-center">
  <div class="col-md-6 text-center mb-5">
    <h2 class="heading-section" style="color: white;
    text-shadow: 2px 2px 4px #000000;" >Projects</h2>
  </div>
</div>
<div class="row" >
  <div class="col-md-12" ">
    
    <div class="table-wrap" style="overflow: hidden;">
    <table class="table">
    <thead class="thead-primary">
    <tr>

    <th>S.N.</th>
    <th>Title</th>
    <th>Description</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Current Status</th>
    <th>Change Status</th>
    <th>Total Members</th>
    </tr>
    </thead>
    <tbody>
    ';
$c = 1;
while ($row2 = mysqli_fetch_array($result2)) {
  
    $title   = $row2['title'];
    $id= $row2['id'];
    $description =$row2['description'];
    $start_date =$row2['start date'];
    $end_date =$row2['end date'];
    $status = $row2['status'];
    $activity= $row2['status'];
    $query10 = "select count(project.id) from project, project_members where project.id=project_members.project_id and project.title='$title'";
    $result10=mysqli_query($db, $query10);
    $array10=mysqli_fetch_array($result10);
    $array10[0];
  $members=$array10[0];



   echo '<tr>
   
   <th scope="row" class="scope" >' . $c++ . '</th>
   <td>' . $title .'</td>
   <td>' . $description. '</td>
   <td>' .$start_date . '</td>
   <td>' . $end_date. '</td>
   <td>' .  $activity. '</td>
   ';
   
   if($status=='active'){
   echo'
   <td>
   <a href="change_status.php?title='.$title.'&status=' .$status. '" class="btn logb" style="color:#FFFFFF;background:#ff0000;font-size:12px;padding:5px;">
   &nbsp;<span><b>DISABLE</b></span></a></b>
   </td>';}
   else{ echo'
    <td>
    <a href="change_status.php?title='.$title.'&status=' .$status. '" class="btn logb" style="color:#FFFFFF;background:darkgreen;font-size:12px;padding:5px;">
    &nbsp;<span><b>ENABLE</b></span></a></b>
    </td>';
   };
   echo'
   <td>' . $members. '</td>
   </tr>
   ';
  
}

  }




  ///////////////////////////////////////////////// teammember index page////////////////////////////////////
  if ($_SESSION['usertype']=='teammember') {
    // echo "teammember";

     ///projects table

     $result11 = mysqli_query($db, "SELECT * FROM project, project_members where project.id=project_members.project_id and project_members.member_name='$username'");
echo '		<div class="container">
<div class="row justify-content-center">
  <div class="col-md-6 text-center mb-5">
    <h2 class="heading-section" style="color: white;
    text-shadow: 2px 2px 4px #000000;" >Projects</h2>
  </div>
</div>
<div class="row" >
  <div class="col-md-12" ">
    
    <div class="table-wrap" style="overflow: hidden;">
    <table class="table">
    <thead class="thead-primary">
    <tr>

    <th>S.N.</th>
    <th>Title</th>
    <th>Description</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Current Status</th>
    <th>Total Members</th>
    </tr>
    </thead>
    <tbody>
    ';
$c11 = 1;
 $sdfsdf= mysqli_num_rows($result11);

while ($row11 = mysqli_fetch_array($result11)) {
    $id=$row11['id'];
  
    $title11  = $row11['title'];
   
    $description11 =$row11['description'];
    $start_date11 =$row11['start date'];
    $end_date11 =$row11['end date'];
    // $status11 = $row11['status'];
    $activity11= $row11['status'];
    $query12 = "select count(project.id) from project, project_members where project.id=project_members.project_id and project.title='$title11'";
    $result12=mysqli_query($db, $query12);
    $array12=mysqli_fetch_array($result12);
    $array12[0];
  $members12=$array12[0];



   echo '<tr>
   
   <th scope="row" class="scope" >' . $c11++ . '</th>
   <td><a href="scrumboard.php?id='.$id.'">' . $title11 .'</a></td>
   <td>' . $description11. '</td>
   <td>' .$start_date11 . '</td>
   <td>' . $end_date11. '</td>
   <td>' .  $activity11. '</td>
   ';
   
   echo'
   <td>' . $members12. '</td>
   </tr>
   ';
  
}

  






    }
?>
</body>


<!-- create a new file for navbar -->
<style>
  .navbar-text {
    float: right; }

    #navbarText{
      font-size: 20px;

    }
    body{
       background-image: url('https://www.cmegroup.com/content/dam/cmegroup/education/images/2021/traiana-weblink-940x600.jpg'); */
       repeat:no-repeat fixed center; background-color: #000000; background-size: cover;
      /* background-color: rgba(255, 255, 255, -2.514);
  background-blend-mode: overlay; 
  background-color: #d7edef; */
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
</html>