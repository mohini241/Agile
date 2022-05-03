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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="template.css">
</head>

<body>

    <div class="header">
        <h2>Home Page</h2>
    </div>
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
        <p>Welcome <strong><?php echo $_SESSION['username'];  ?></strong></p>
        <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
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
          <h4 class="modal-title">Project Creation Form</h4>

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

    </div>
        <div class="mb-3">
        <label for="members" class="form-label">Select Team Members</label>
        <select name="members[]" multiple>';
        for ($x = 0; $x < $username_count; $x++) {
        echo' <option value='.$list_of_usernames[$x].'>'.$list_of_usernames[$x].'</option>';
        }
      echo'
    </select>
      </div>
      <button type="submit" class="btn" name="create_pro">Save Project</button>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  </form>
</div>';








$result2 = mysqli_query($db, "SELECT * FROM project") or die('Error');
echo '<div class="panel"><table class="table table-striped title1"  style="vertical-align:middle">
<tr><td style="vertical-align:middle"><b>S.N.</b></td><td style="vertical-align:middle"><b>Title</b></td><td style="vertical-align:middle"><b>Description</b></td><td style="vertical-align:middle"><b>Start Date</b></td><td style="vertical-align:middle"><b>End Date</b></td><td style="vertical-align:middle"><b>Current Status</b></td><td style="vertical-align:middle"><b>Change Status</b></td><td style="vertical-align:middle"><b>Members</b></td></tr>';
$c = 1;
while ($row2 = mysqli_fetch_array($result2)) {
  
    $title   = $row2['title'];
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
   <td style="vertical-align:middle">' . $c++ . '</td>
   <td style="vertical-align:middle">' . $title .'</td>
   <td style="vertical-align:middle">' . $description. '</td>
   <td style="vertical-align:middle">' .$start_date . '</td>
   <td style="vertical-align:middle">' . $end_date. '</td>
   <td style="vertical-align:middle">' .  $activity. '</td>
   ';
   
   if($status=='active'){
   echo'
   <td style="vertical-align:middle">
   <a href="change_status.php?title='.$title.'&status=' .$status. '" class="btn logb" style="color:#FFFFFF;background:#ff0000;font-size:12px;padding:5px;">
   &nbsp;<span><b>DISABLE</b></span></a></b></td>';}
   else{ echo'
    <td style="vertical-align:middle">
    <a href="change_status.php?title='.$title.'&status=' .$status. '" class="btn logb" style="color:#FFFFFF;background:darkgreen;font-size:12px;padding:5px;">
    &nbsp;<span><b>ENABLE</b></span></a></b></td>';
   };
   echo'
   <td style="vertical-align:middle">' . $members. '</td>
   </tr>';
  
}

  }
  if ($_SESSION['usertype']=='teammember') {
    echo "teammember";
    }
?>
</body>

</html>